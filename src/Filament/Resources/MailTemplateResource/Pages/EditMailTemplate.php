<?php

namespace Wotz\FilamentMailTemplates\Filament\Resources\MailTemplateResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Wotz\FilamentMailTemplates\Filament\Resources\MailTemplateResource;

class EditMailTemplate extends EditRecord
{
    protected static string $resource = MailTemplateResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
