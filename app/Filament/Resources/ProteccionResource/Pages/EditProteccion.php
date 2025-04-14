<?php

namespace App\Filament\Resources\ProteccionResource\Pages;

use App\Filament\Resources\ProteccionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProteccion extends EditRecord
{
    protected static string $resource = ProteccionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
