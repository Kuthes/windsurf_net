<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Models\Policy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PolicyResource extends Resource
{
    protected static ?string $model = Policy::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    
    protected static ?string $navigationGroup = 'Authentication';
    
    protected static ?string $navigationLabel = 'Policies';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Policy Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                Forms\Components\Section::make('Session Limits')
                    ->schema([
                        Forms\Components\TextInput::make('concurrency_limit')
                            ->label('Concurrency Limit')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('max_devices_limit')
                            ->label('Max Devices Limit')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\TextInput::make('daily_session_count')
                            ->label('Daily Session Count')
                            ->numeric()
                            ->nullable(),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Timeouts')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('session_timeout')
                                    ->label('Session Timeout')
                                    ->numeric(),
                                Forms\Components\Select::make('session_timeout_unit')
                                    ->label('')
                                    ->options(['Minutes' => 'Minutes', 'Hours' => 'Hours'])
                                    ->default('Minutes'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('idle_timeout')
                                    ->label('Idle Timeout')
                                    ->numeric(),
                                Forms\Components\Select::make('idle_timeout_unit')
                                    ->label('')
                                    ->options(['Minutes' => 'Minutes', 'Hours' => 'Hours'])
                                    ->default('Minutes'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('validity_interval')
                                    ->label('Validity Interval')
                                    ->numeric(),
                                Forms\Components\Select::make('validity_interval_unit')
                                    ->label('')
                                    ->options(['Hours' => 'Hours', 'Days' => 'Days', 'Months' => 'Months'])
                                    ->default('Days'),
                            ]),
                    ]),

                Forms\Components\Section::make('Quotas')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_time_quota')
                                    ->label('Total Time Quota')
                                    ->numeric(),
                                Forms\Components\Select::make('total_time_quota_unit')
                                    ->label('')
                                    ->options(['Minutes' => 'Minutes', 'Hours' => 'Hours'])
                                    ->default('Minutes'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('daily_time_quota')
                                    ->label('Daily Time Quota')
                                    ->numeric(),
                                Forms\Components\Select::make('daily_time_quota_unit')
                                    ->label('')
                                    ->options(['Minutes' => 'Minutes', 'Hours' => 'Hours'])
                                    ->default('Minutes'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_bandwidth_quota')
                                    ->label('Total Bandwidth Quota')
                                    ->numeric(),
                                Forms\Components\Select::make('total_bandwidth_quota_unit')
                                    ->label('')
                                    ->options(['MB' => 'MB', 'GB' => 'GB'])
                                    ->default('MB'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('daily_bandwidth_quota')
                                    ->label('Daily Bandwidth Quota')
                                    ->numeric(),
                                Forms\Components\Select::make('daily_bandwidth_quota_unit')
                                    ->label('')
                                    ->options(['MB' => 'MB', 'GB' => 'GB'])
                                    ->default('MB'),
                            ]),
                    ]),

                Forms\Components\Section::make('Bandwidth Rates')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('download_rate')
                                    ->label('Download Rate')
                                    ->numeric(),
                                Forms\Components\Select::make('download_rate_unit')
                                    ->label('')
                                    ->options(['Kbps' => 'Kbps', 'Mbps' => 'Mbps'])
                                    ->default('Mbps'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('upload_rate')
                                    ->label('Upload Rate')
                                    ->numeric(),
                                Forms\Components\Select::make('upload_rate_unit')
                                    ->label('')
                                    ->options(['Kbps' => 'Kbps', 'Mbps' => 'Mbps'])
                                    ->default('Mbps'),
                            ]),
                    ]),
                    
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Checkbox::make('auto_renewal')
                            ->label('Auto Renewal (Valid only for free user\'s validity interval)'),
                        Forms\Components\Checkbox::make('is_default')
                            ->label('Is Default (Set current policy as default)'),
                        Forms\Components\TextInput::make('filter_id')
                            ->label('Filter ID')
                            ->helperText('Valid only for vendors like Meraki etc.'),
                        Forms\Components\TextInput::make('redirect_url')
                            ->label('Redirect URL (Captive Portal / Splash Page)')
                            ->helperText('Used for Vendor Attributes (Aruba, Cisco, Ruckus)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Policy Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('concurrency_limit')
                    ->label('Concurrency')
                    ->sortable(),
                Tables\Columns\TextColumn::make('download_rate')
                    ->label('Download')
                    ->formatStateUsing(fn ($state, $record) => $state ? $state . ' ' . $record->download_rate_unit : '-'),
                Tables\Columns\TextColumn::make('upload_rate')
                    ->label('Upload')
                    ->formatStateUsing(fn ($state, $record) => $state ? $state . ' ' . $record->upload_rate_unit : '-'),
                Tables\Columns\IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean(),
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
            'index' => Pages\ListPolicies::route('/'),
            'create' => Pages\CreatePolicy::route('/create'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }
}
