<?php

namespace Wotz\FilamentMailTemplates\Facades;

use Illuminate\Support\Facades\Facade;

class MailTemplateFallbacks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wotz\FilamentMailTemplates\MailTemplateFallbacks::class;
    }
}
