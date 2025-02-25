<?php

namespace App\Filament\Resources;

use App\Models\Role;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\Widgets\RoleStats;


class RoleResource extends Resource {
    protected static ?string $model = Role::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroupLabel = 'Roles & Permisions';

    protected function getHeaderWidgets(): array
    {
        return [
            RoleStats::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    TextInput::make('name')
                        ->label('Role Name')
                        ->required()
                        ->rule('unique:roles,name,' . (request()->route('record') ? request()->route('record') : 'NULL') . ',id'),
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

                TextColumn::make('name')
                    ->label('Role Name')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn ($record) => match ($record->name) {
                        'admin' => 'danger',
                        'editor' => 'warning',
                        'user' => 'success',
                        default => 'gray',
                    }),

                    TextColumn::make('users_count')
                        ->label('User in Role')
                        ->counts('users')
                        ->sortable()
                        ->color('primary'),
            ])

            ->filters([
                SelectFilter::make('users')
                ->relationship('users', 'name')
                ->searchable()
                ->label('Filter by users'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->requiresConfirmation(),
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
            'index' => Pages\ListRoles::route('/'),
            'view' => Pages\ViewRole::route('/{record}'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
