<?php

namespace App\Filament\Resources\NutricionResource\Pages;

use App\Filament\Resources\NutricionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNutricion extends EditRecord
{
    protected static string $resource = NutricionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
