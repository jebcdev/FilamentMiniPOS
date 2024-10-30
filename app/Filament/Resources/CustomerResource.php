<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    /*  */

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Clientes';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $modelLabel = 'Clientes';

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
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([

                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('zip_code')
                            ->label(__('Zip Code'))
                            ->maxLength(255),

                    ]),
                ]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([

                        Forms\Components\TextInput::make('address')
                            ->label(__('Address'))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('city')
                            ->label(__('City'))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('state')
                            ->label(__('State'))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('country')
                            ->label(__('Country'))
                            ->maxLength(255),

                    ]),
                ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('zip_code')
                    ->label(__('Zip Code'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->label(__('City'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('state')
                    ->label(__('State'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('country')
                    ->label(__('Country'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
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
            'index' => Pages\ListCustomers::route('/'),

            'create' => Pages\CreateCustomer::route('/create'),

            'view' => Pages\ViewCustomer::route('/{record}'),

            'edit' => Pages\EditCustomer::route('/{record}/edit'),

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
