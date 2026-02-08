<?php

namespace App\Filament\Resources\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;

class Type extends TextColumn
{
    protected string $name = 'type';

    public function getState(): ?string
    {
        $state = parent::getState();
        
        $types = [
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
        ];

        return $types[$state] ?? 'Unknown';
    }
}
