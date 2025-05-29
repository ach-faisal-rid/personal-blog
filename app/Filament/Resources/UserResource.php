<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Widgets\UserStats;
use BezhanSalleh\FilamentShield\FilamentShield;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected function getHeaderWidgets(): array
    {
        return [
            UserStats::class,
        ];
    }

    public static function form(Form $form): Form
    {
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

                    ])->columns(2),
                
                Section::make('Roles')
                    ->schema([
                        Select::make('roles')
                            ->label('Roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ])->columns(1),
                
                Section::make('Profile Picture')
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->label('Avatar')
                            ->image()
                            ->directory('profile-photos')
                            ->maxSize(2048)
                            ->columnSpanFull(),
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
                        ->searchable()
                        ->icon('heroicon-o-hashtag')
                        ->color('gray')
                        ->width(65),

                    ImageColumn::make('profile_photo_path')
                        ->label('Avatar')
                        ->circular()
                        ->size(45),

                    Stack::make([
                        TextColumn::make('name')
                            ->label('Name')
                            ->sortable()
                            ->searchable()
                            ->icon('heroicon-o-user-circle')
                            ->weight('Bold')
                            ->color('primary'),

                        TextColumn::make('email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope')
                            ->sortable()
                            ->searchable(),
                            
                        TextColumn::make('roles.name')
                            ->label('Roles')
                            ->badge()
                            ->color('success'),
                    ])->grow(),

                    TextColumn::make('created_at')
                        ->label('created')
                        ->dateTime()
                        ->sortable(),
                ]),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
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