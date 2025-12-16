<?php

namespace App\Filament\Resources\FatherResource\Pages;

use App\Filament\Resources\FatherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFathers extends ListRecords
{
    protected static string $resource = FatherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
