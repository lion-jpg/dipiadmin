<?php

namespace App\Filament\Resources\ProteccionResource\Pages;

use App\Filament\Resources\ProteccionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProteccions extends ListRecords
{
    protected static string $resource = ProteccionResource::class;

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
