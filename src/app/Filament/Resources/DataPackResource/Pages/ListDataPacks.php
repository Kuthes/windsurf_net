<?php

namespace App\Filament\Resources\DataPackResource\Pages;

use App\Filament\Resources\DataPackResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListDataPacks extends ListRecords
{
    protected static string $resource = DataPackResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
