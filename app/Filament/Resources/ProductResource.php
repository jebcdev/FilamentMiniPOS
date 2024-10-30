<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    /*  */

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Almacén';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $modelLabel = 'Productos';

    protected static ?string $recordTitleAttribute = 'name'; //para que se pueda buscar de manera global

    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge'; //cambiar el icono de la seccion activa

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make(/* __('Product Images') */)->schema([
                    Forms\Components\FileUpload::make('images')
                        ->label(__('Product Images'))
                        ->multiple()
                        ->image()
                        ->maxFiles(5)
                        ->directory('products')
                        ->columnSpanFull(),
                ]),


                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make(__('Basic Information'))->schema([

                        Forms\Components\TextInput::make('code')
                            ->label(__('Code'))
                            ->required()
                            ->maxLength(200),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(200),

                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label(__('Category'))
                            ->preload()
                            ->searchable()
                            ->required(),

                    ]),
                ]),



                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make(__('Inventory Information'))->schema([

                        Forms\Components\TextInput::make('stock')
                            ->label(__('Stock'))
                            ->required()
                            ->numeric()
                            ->default(1),

                        Forms\Components\TextInput::make('min_stock')
                            ->label(__('Min Stock'))
                            ->required()
                            ->numeric()
                            ->default(1),

                        Forms\Components\TextInput::make('max_stock')
                            ->label(__('Max Stock'))
                            ->required()
                            ->numeric()
                            ->default(50),
                    ]),
                ]),


                Forms\Components\Section::make()->schema([

                    Forms\Components\MarkdownEditor::make('description')
                        ->label(__('Description'))
                        ->columnSpanFull(),
                ]),
                Forms\Components\Section::make(__('Pricing Information'))->schema([

                    Forms\Components\TextInput::make('purchase_price')
                        ->label(__('Purchase Price'))
                        ->required()
                        ->numeric(),

                    Forms\Components\TextInput::make('sale_price')
                        ->label(__('Sale Price'))
                        ->required()
                        ->numeric(),

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('Category')) //para mostrar el nombre de la categoria en la tabla
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label(__('Stock'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->numeric()
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('min_stock')
                    ->label(__('Min Stock'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('max_stock')
                    ->label(__('Max Stock'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('purchase_price')
                    ->label(__('Purchase Price'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label(__('Sale Price'))
                    ->numeric()
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

            ])
            ->actions(
                [

                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make(),
                        Tables\Actions\ViewAction::make(),
                    ]),

                ],
                position: Tables\Enums\ActionsPosition::BeforeColumns
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\ForceDeleteBulkAction::make(),

                    Tables\Actions\RestoreBulkAction::make(),

                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),

            'create' => Pages\CreateProduct::route('/create'),

            'view' => Pages\ViewProduct::route('/{record}'),

            'edit' => Pages\EditProduct::route('/{record}/edit'),

        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
