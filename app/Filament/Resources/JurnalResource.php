<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurnalResource\Pages;
use App\Filament\Resources\JurnalResource\RelationManagers;
use Modules\Jurnal\Entities\Jurnal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JurnalResource extends Resource
{
    protected static ?string $model = Jurnal::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Jurnal Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('penulis')
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('file')
                ->required()
                ->disk('public')
                ->directory('jurnals')
                ->preserveFilenames()
                ->downloadable(),

                Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),

                Forms\Components\Textarea::make('index_jurnal')
                ->label('Index Jurnal')
                ->required()
                ->columnSpanFull(),

                Forms\Components\TextInput::make('jumlah_halaman')
                ->label('Jumlah Halaman')
                ->numeric()
                ->required(),

                Forms\Components\DatePicker::make('publish')
                ->label('Tanggal Publish')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ID Column
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->icon('heroicon-o-hashtag')
                    ->color('gray')
                    ->sortable()
                    ->searchable()
                    ->alignLeft()
                    ->width('70px'),
                    
                Tables\Columns\TextColumn::make('judul')->searchable()->sortable()->limit(20)->tooltip(fn($record) => $record->judul),
                Tables\Columns\TextColumn::make('penulis')->searchable()->sortable()->limit(10)->tooltip(fn($record) => $record->penulis),
                Tables\Columns\TextColumn::make('jumlah_halaman'),
                Tables\Columns\TextColumn::make('publish')->label('Tanggal Publish')->date('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListJurnals::route('/'),
            'create' => Pages\CreateJurnal::route('/create'),
            'edit' => Pages\EditJurnal::route('/{record}/edit'),
        ];
    }
}
