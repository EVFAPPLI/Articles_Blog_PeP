<?php

namespace App\Filament\Resources\AiPostResource\Pages;

use App\Filament\Resources\AiPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAiPosts extends ListRecords
{
    protected static string $resource = AiPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
