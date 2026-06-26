<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Override the getAttribute method to handle translations automatically.
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->translatable ?? [])) {
            $json = is_string($value) ? json_decode($value, true) : $value;
            if (is_array($json)) {
                $locale = app()->getLocale();
                return $json[$locale] ?? $json['en'] ?? $value;
            }
        }

        return $value;
    }
}
