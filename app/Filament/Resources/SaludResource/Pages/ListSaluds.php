<?php

namespace App\Filament\Resources\SaludResource\Pages;

use App\Filament\Resources\SaludResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaluds extends ListRecords
{
    protected static string $resource = SaludResource::class;

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
