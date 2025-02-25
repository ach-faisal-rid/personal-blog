<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserStats;

class UserResource extends Resource {
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected function getHeaderWidgets(): array
    {
        return [
            UserStats::class,
        ];
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Section::make('User Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
    
                    TextInput::make('email')->label('Email')
                        ->email()
                        ->required(),
    
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->minLength(6)
                        ->maxLength(length: 12)
                        ->visible(fn($record) => !$record),
    
                    Select::make('roles')
                        ->label('Roles')
                        ->relationship('roles', 'name')
                        ->preload(),

                ])->columns(2),
                Section::make('Profile Picture')
                ->schema([
                    
                    FileUpload::make('profile_photo_profile')
                        ->label('Avatar')
                        ->image()
                        ->directory('profile-photos')
                        ->maxSize(2048)
                        ->columnSpanFull()
                
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('id')
                        ->label('ID')
                        ->sortable()
                        ->searchable(),

                    ImageColumn::make('profile_photo_path')
                        ->label('Avatar')
                        ->circular()
                        ->size(50),
    
                    TextColumn::make('name')
                        ->label('Name')
                        ->sortable()
                        ->searchable(),
    
                    TextColumn::make('email')
                        ->label('Email')
                        ->icon('heroicon-m-envelope')
                        ->sortable()
                        ->searchable(),
    
                    TextColumn::make('roles.name')
                        ->label('Roles')
                        ->icon('heroicon-o-shield-check')
                        ->badge(),
                ]),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Filter by Role')
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('Set Role')
                    ->icon('heroicon-m-adjustments-vertical')
                    ->form([
                        Select::make('role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->roles()->sync($data['role'] ?? []);
                    })
                    ->successNotificationTitle('Roles updated successfully!'),

                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
