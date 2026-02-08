<?php

namespace App\Filament\Resources\DataPackResource\Pages;

use App\Filament\Resources\DataPackResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditDataPack extends EditRecord
{
    protected static string $resource = DataPackResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
