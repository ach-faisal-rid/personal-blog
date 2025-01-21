<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleUserResource\Pages;
use App\Filament\Resources\RoleUserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleUserResource extends Resource
{
    protected static ?string $model = 'App\Models\RoleUser';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-s-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('role_id')
                    ->label('Role')
                    ->options(
                        Role::all()->pluck('name', 'id')->toArray()
                    )
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->options(
                        User::all()->pluck('name', 'id')->toArray()
                    )
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('role.name')
                    ->label('Role')
                    ->sortable()
                    ->searchable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRoleUsers::route('/'),
            'create' => Pages\CreateRoleUser::route('/create'),
            'edit' => Pages\EditRoleUser::route('/{record}/edit'),
        ];
    }
}
