<?php

namespace Wotz\FilamentMailTemplates\Facades;

use Illuminate\Support\Facades\Facade;

class MailTemplateCollection extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wotz\FilamentMailTemplates\MailTemplateCollection::class;
    }
}
