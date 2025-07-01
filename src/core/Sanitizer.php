<?php

namespace YourNamespace\Core;

class Sanitizer
{
    public static function sanitizeString($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeEmail($input)
    {
        return filter_var(trim($input), FILTER_SANITIZE_EMAIL);
    }
}
