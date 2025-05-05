<?php

namespace App\Filament\Resources\EducacionResource\Pages;

use App\Filament\Resources\EducacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEducacions extends ListRecords
{
    protected static string $resource = EducacionResource::class;

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
