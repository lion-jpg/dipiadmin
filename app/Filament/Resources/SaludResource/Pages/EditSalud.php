<?php

namespace App\Filament\Resources\SaludResource\Pages;

use App\Filament\Resources\SaludResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalud extends EditRecord
{
    protected static string $resource = SaludResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
