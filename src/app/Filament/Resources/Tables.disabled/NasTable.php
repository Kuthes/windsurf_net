<?php

namespace App\Filament\Resources\Tables;

use App\Models\Nas;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Actions;
use Filament\Tables\Filters;
use Filament\Tables\BulkActions;

class NasTable extends Tables\Table
{
    protected static ?string $model = Nas::class;

    protected static ?string $heading = 'Network Access Servers';

    public static function columns(array $columns): array
    {
        return [
            Columns\Nasname::make(),
            Columns\Shortname::make(),
            Columns\Type::make(),
            Columns\Ports::make(),
            Columns\CreatedAt::make(),
            Columns\UpdatedAt::make(),
        ];
    }

    public static function filters(array $filters): array
    {
        return [
            Filters\Nasname::make(),
            Filters\Shortname::make(),
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
