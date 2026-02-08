<?php

namespace App\Filament\Resources\Tables;

use App\Models\RadCheck;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Actions;
use Filament\Tables\Filters;
use Filament\Tables\BulkActions;

class RadCheckTable extends Tables\Table
{
    protected static ?string $model = RadCheck::class;

    protected static ?string $heading = 'Wi-Fi Users';

    public static function columns(array $columns): array
    {
        return [
            Columns\Text::make('username')
                ->label('Username')
                ->searchable()
                ->sortable(),
            Columns\Text::make('attribute')
                ->label('Attribute')
                ->formatStateUsing(fn ($state) => $state->getAttribute('attribute') === 'Cleartext-Password' ? 'Password' : $state->getAttribute('attribute'))
                ->sortable(),
            Columns\Text::make('value')
                ->label('Value')
                ->formatStateUsing(fn ($state) => $state->getAttribute('attribute') === 'Cleartext-Password' ? '•••••••' : $state->getAttribute('value'))
                ->sortable(),
            Columns\Text::make('updated_at')
                ->label('Last Updated')
                ->dateTime()
                ->sortable(),
        ];
    }

    public static function filters(array $filters): array
    {
        return [
            Filters\TextFilter::make('username')
                ->label('Username'),
        ];
    }

    public static function actions(array $actions): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public static function bulkActions(array $bulkActions): array
    {
        return [
            BulkActions\DeleteBulkAction::make(),
        ];
    }
}
