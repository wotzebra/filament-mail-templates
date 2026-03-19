<?php

namespace Wotz\FilamentMailTemplates\Facades;

class MailTemplateCollection extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wotz\FilamentMailTemplates\MailTemplateCollection::class;
    }
}
