<?php

namespace App\Filament\Resources\NutricionResource\Pages;

use App\Filament\Resources\NutricionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNutricions extends ListRecords
{
    protected static string $resource = NutricionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }
    protected function getCreatedRedirectUrl(): string
    {
        return route('filament.admin.pages.dashboard');
    }   
}
