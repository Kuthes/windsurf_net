<?php

namespace App\Filament\Resources\VenueSettingResource\Pages;

use App\Filament\Resources\VenueSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVenueSettings extends ListRecords
{
    protected static string $resource = VenueSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
