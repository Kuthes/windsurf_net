<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueSettingResource\Pages;
use App\Models\VenueSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VenueSettingResource extends Resource
{
    protected static ?string $model = VenueSetting::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; 
    // Using a default icon for now, user didn't specify. 
    
    protected static ?string $navigationGroup = 'Network Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nas_id')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('NAS ID'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Venue Name'),
                Forms\Components\FileUpload::make('logo_path')
                    ->image()
                    ->label('Logo'),
                Forms\Components\FileUpload::make('background_image_path')
                    ->image()
                    ->label('Background Image'),
                Forms\Components\ColorPicker::make('primary_color')
                    ->required()
                    ->default('#007bff')
                    ->label('Primary Color'),
                Forms\Components\Select::make('policy_id')
                    ->label('Default Policy')
                    ->relationship('policy', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (\Filament\Forms\Form $form) => \App\Filament\Resources\PolicyResource::form($form))
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nas_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('policy.name')
                    ->label('Default Policy')
                    ->sortable()
                    ->placeholder('None'),
                Tables\Columns\ImageColumn::make('logo_path'),
                Tables\Columns\ColorColumn::make('primary_color'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getNavigationLabel(): string
    {
        return 'Captive Portals';
    }

    public static function getNavigationGroup(): string
    {
        return 'Authentication';
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
            'index' => Pages\ListVenueSettings::route('/'),
            'create' => Pages\CreateVenueSetting::route('/create'),
            'edit' => Pages\EditVenueSetting::route('/{record}/edit'),
        ];
    }
}
