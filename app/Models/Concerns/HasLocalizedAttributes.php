<?php

namespace App\Models\Concerns;

trait HasLocalizedAttributes
{
    protected function getLocalizedValue(string $attribute): mixed
    {
        $locale = app()->getLocale();
        $localizedAttribute = "{$attribute}_{$locale}";

        if ($locale !== config('app.fallback_locale') && isset($this->{$localizedAttribute}) && filled($this->{$localizedAttribute})) {
            return $this->{$localizedAttribute};
        }

        return $this->{$attribute};
    }
}
