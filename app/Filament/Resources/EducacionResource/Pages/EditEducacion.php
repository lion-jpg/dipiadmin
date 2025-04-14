<?php

namespace App\Filament\Resources\EducacionResource\Pages;

use App\Filament\Resources\EducacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEducacion extends EditRecord
{
    protected static string $resource = EducacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
