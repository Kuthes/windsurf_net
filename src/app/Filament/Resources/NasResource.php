<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NasResource\Pages;
use App\Models\Nas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NasResource extends Resource
{
    protected static ?string $model = Nas::class;

    protected static ?string $navigationIcon = 'heroicon-o-server';
    
    protected static ?string $navigationGroup = 'Authentication';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nasname')
                    ->label('NAS IP Address')
                    ->required()
                    ->maxLength(128)
                    ->placeholder('192.168.1.1')
                    ->helperText('IP address or hostname of the Network Access Server'),
                Forms\Components\Select::make('venue_setting_id')
                    ->label('Linked Venue (Captive Portal)')
                    ->relationship('venueSetting', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Select the Venue/Portal this AP belongs to'),
                Forms\Components\TextInput::make('shortname')
                    ->label('Short Name')
                    ->required()
                    ->maxLength(32)
                    ->placeholder('router1'),
                Forms\Components\Select::make('type')
                    ->label('NAS Type')
                    ->options([
                        0 => 'Other',
                        1 => 'Cisco',
                        2 => 'Computone',
                        3 => 'Livingston',
                        4 => 'Juniper',
                        5 => 'Max40xx',
                        6 => 'Multitech',
                        7 => 'Netserver',
                        8 => 'Patton',
                        9 => 'Portslave',
                        10 => 'TC',
                        11 => 'USRHIPER',
                    ])
                    ->default(0),
                Forms\Components\TextInput::make('ports')
                    ->label('Ports')
                    ->numeric()
                    ->helperText('Number of ports on the NAS'),
                Forms\Components\TextInput::make('secret')
                    ->label('Shared Secret')
                    ->required()
                    ->maxLength(60)
                    ->password()
                    ->revealable()
                    ->default('secret')
                    ->helperText('RADIUS shared secret for this NAS'),
                Forms\Components\TextInput::make('community')
                    ->label('SNMP Community')
                    ->maxLength(50)
                    ->helperText('SNMP community string (optional)'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(200)
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nasname')
                    ->label('NAS IP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('venueSetting.name')
                    ->label('Venue')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('shortname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn ($state) => match ((int)$state) {
                        0 => 'Other',
                        1 => 'Cisco',
                        2 => 'Computone',
                        3 => 'Livingston',
                        4 => 'Juniper',
                        5 => 'Max40xx',
                        6 => 'Multitech',
                        7 => 'Netserver',
                        8 => 'Patton',
                        9 => 'Portslave',
                        10 => 'TC',
                        11 => 'USRHIPER',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('ports')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListNas::route('/'),
            'create' => Pages\CreateNas::route('/create'),
            'edit' => Pages\EditNas::route('/{record}/edit'),
        ];
    }
}
