<?php

namespace App\Filament\Resources\FatherResource\Pages;

use App\Filament\Resources\FatherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFather extends EditRecord
{
    protected static string $resource = FatherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
