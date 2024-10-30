<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Product;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    /*  */

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Compras / Ventas';

    protected static ?string $navigationLabel = 'Compras';

    protected static ?string $modelLabel = 'Compras';

    protected static ?string $recordTitleAttribute = 'purchase_number'; //para que se pueda buscar de manera global

    protected static ?string $activeNavigationIcon = 'heroicon-o-check-badge'; //cambiar el icono de la seccion activa

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Wizard::make([
                    /* Paso 01 */
                    Forms\Components\Wizard\Step::make(__('Purchase Details'))->schema([

                        Forms\Components\Section::make()->schema([
                            
                            Forms\Components\Select::make('user_id')
                                ->label(__('Created By'))
                                ->relationship('user', 'name')
                                ->default(Auth::id()??1)
                                ->disabled()
                                ->required(),

                            Forms\Components\DatePicker::make('date')
                                ->label(__('Date'))
                                ->native(false)
                                ->default(now())
                                ->required(),
                        ])->columns(2),

                        Forms\Components\TextInput::make('purchase_number')
                            ->label(__('Purchase Number'))
                            ->required()
                            ->dehydrated()
                            ->default('ORDCMP-' . now()->format('Ymd') . '-' . rand(1000, 99999999))
                            ->maxLength(255),

                        Forms\Components\MarkdownEditor::make('description')
                            ->label(__('Description'))
                            ->required()
                            ->dehydrated()
                            ->default(now()->format('d-m-Y') . '. ')
                            ->columnSpanFull(),
                    ]),

                    /* Paso 02 */
                    Forms\Components\Wizard\Step::make(__('Purchase Items'))->schema([

                        Forms\Components\Repeater::make('purchaseDetails')
                            ->relationship()
                            ->label(__('Purchase Items'))
                            ->schema([

                                Forms\Components\Section::make()->schema([

                                    Forms\Components\Select::make('product_id')
                                        ->label(__('Product'))
                                        ->relationship('product', 'name')
                                        ->preload()
                                        ->searchable()
                                        ->live()
                                        ->dehydrated()

                                        ->afterStateUpdated(function (callable $set, $state) {
                                            // Obtener el producto seleccionado por su ID
                                            $product = Product::find($state);
                                            
                                            // Si el producto existe, actualizar el precio unitario
                                            if ($product) {
                                                $set('purchase_price', $product->purchase_price);
                                                $set('sale_price', $product->sale_price);
                                            }
                                        })

                                        ->required(),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label(__('Quantity'))
                                        ->default(1)
                                        ->live()
                                        ->dehydrated()
                                        ->required(),

                                    Forms\Components\TextInput::make('purchase_price')
                                        ->label(__('Purchase Price'))
                                        ->live()
                                        ->dehydrated()
                                        ->readOnly()
                                        ->required(),

                                    Forms\Components\TextInput::make('sale_price')
                                        ->label(__('Sale Price'))
                                        ->live()
                                        ->dehydrated()
                                        ->readOnly()
                                        ->required(),


                                ])->columns(4),
                            ]),
                    ]),

                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Created By'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label(__('Date'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('purchase_number')
                    ->label(__('Purchase Number'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label(__('Total'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),


                Tables\Filters\SelectFilter::make('user_id')
                    ->label(__('Created By'))
                    ->relationship('user', 'name')
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
            'index' => Pages\ListPurchases::route('/'),

            'create' => Pages\CreatePurchase::route('/create'),

            'view' => Pages\ViewPurchase::route('/{record}'),

            // 'edit' => Pages\EditPurchase::route('/{record}/edit'),

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
