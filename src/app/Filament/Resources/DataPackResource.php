<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPackResource\Pages;
use App\Models\RadGroupReply;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DataPackResource extends Resource
{
    protected static ?string $model = RadGroupReply::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    
    protected static ?string $navigationGroup = 'Authentication';
    
    protected static ?string $navigationLabel = 'Data Packs';
    
    protected static ?string $slug = 'data-packs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('groupname')
                    ->label('Pack Name')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('attribute')
                    ->required()
                    ->maxLength(64)
                    ->default('Mikrotik-Total-Limit'),
                Forms\Components\TextInput::make('value')
                    ->label('Bytes Limit')
                    ->required()
                    ->maxLength(253),
                Forms\Components\Hidden::make('op')
                    ->default(':='),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('groupname')
                    ->label('Pack Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attribute')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPacks::route('/'),
            'create' => Pages\CreateDataPack::route('/create'),
            'edit' => Pages\EditDataPack::route('/{record}/edit'),
        ];
    }
}
