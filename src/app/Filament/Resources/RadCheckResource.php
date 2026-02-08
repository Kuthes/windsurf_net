<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RadCheckResource\Pages;
use App\Models\RadCheck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RadCheckResource extends Resource
{
    protected static ?string $model = RadCheck::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Authentication';

    public static function getNavigationLabel(): string
    {
        return 'Vouchers';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(64)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('value')
                    ->label('Password')
                    ->required()
                    ->maxLength(253)
                    ->password()
                    ->revealable(),
                Forms\Components\Hidden::make('attribute')
                    ->default('Cleartext-Password'),
                Forms\Components\Hidden::make('op')
                    ->default(':='),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Password')
                    ->limit(10),
                Tables\Columns\TextColumn::make('attribute')
                     ->sortable(),
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
            'index' => Pages\ListRadChecks::route('/'),
            'create' => Pages\CreateRadCheck::route('/create'),
            'edit' => Pages\EditRadCheck::route('/{record}/edit'),
        ];
    }
}
