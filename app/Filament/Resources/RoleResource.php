<?php

namespace App\Filament\Resources;

use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\Widgets\RoleStats;

class RoleResource extends Resource {
    protected static ?string $model = Role::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function getWidgets(): array
    {
        return [
            RoleStats::class,
        ];
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Role Name')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('guard_name')
                    ->label('Guard Name')
                    ->default('web')
                    ->nullable()
                    ->maxLength(255),

                CheckboxList::make('permissions')
                    ->label('Permissions')
                    ->relationship('permissions', 'name')
                    ->columns(3)
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('id')
                        ->label('ID')
                        ->sortable()
                        ->searchable()
                        ->icon('heroicon-o-hashtag')
                        ->color('gray')
                        ->toggleable(),

                    TextColumn::make('name')
                        ->label('Role Name')
                        ->sortable()
                        ->searchable()
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'super admin' => 'danger',
                            'user' => 'success',
                            'editor' => 'warning',
                            default => 'gray',
                        })
                        ->icon(fn ($state) => match ($state) {
                            'super admin' => 'heroicon-o-shield-check',
                            'user' => 'heroicon-o-user',
                            'editor' => 'heroicon-o-pencil',
                            default => 'heroicon-o-tag',
                        })
                        ->tooltip(fn ($state) => "This role is: $state"),

                    TextColumn::make('guard_name')
                        ->label('Guard Name')
                        ->badge()
                        ->color('warning'),

                    TextColumn::make('permissions_count')
                        ->label('Permissions')
                        ->counts('permissions')
                        ->badge()
                        ->colors(['success']),
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}