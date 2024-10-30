<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    /*  */

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Almacén';

    protected static ?string $navigationLabel = 'Categorías';

    protected static ?string $modelLabel = 'Categorías';

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
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(200),

                Forms\Components\MarkdownEditor::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label(__('Description'))
                    ->searchable()->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListCategories::route('/'),


            'create' => Pages\CreateCategory::route('/create'),


            'view' => Pages\ViewCategory::route('/{record}'),


            'edit' => Pages\EditCategory::route('/{record}/edit'),


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
