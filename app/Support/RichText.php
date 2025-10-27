<?php

namespace App\Support;

class RichText
{
    /**
     * Allowed HTML tags for rich text fields.
     */
    protected const ALLOWED_TAGS = '<p><br><strong><em><ul><ol><li>';

    /**
     * Sanitize a block of rich text HTML.
     */
    public static function sanitize(?string $content): ?string
    {
        if ($content === null) {
            return null;
        }

        $normalized = trim(str_replace(["\r\n", "\r"], "\n", $content));

        if ($normalized === '') {
            return null;
        }

        // Harmonize basic tags we want to support
        $normalized = str_ireplace(['<b>', '</b>', '<i>', '</i>'], ['<strong>', '</strong>', '<em>', '</em>'], $normalized);
        $normalized = preg_replace(['#<\s*div[^>]*>#i', '#</\s*div>#i'], ['<p>', '</p>'], $normalized);
        $normalized = preg_replace(['#<\s*span[^>]*>#i', '#</\s*span>#i'], ['', ''], $normalized);

        // Strip any disallowed tags and attributes
        $normalized = strip_tags($normalized, self::ALLOWED_TAGS);

        // Replace multiple non-breaking spaces with regular spaces
        $normalized = preg_replace('/\xc2\xa0+/', ' ', $normalized);
        $normalized = str_replace('&nbsp;', ' ', $normalized);

        // Remove empty paragraphs or list items
        $normalized = preg_replace('#<(p|li)>\s*</\1>#i', '', $normalized);

        // If no block-level tags remain, convert lines to paragraphs
        if (!preg_match('/<(p|ul|ol|li)\b/i', $normalized)) {
            $lines = array_filter(array_map('trim', explode('\n', $normalized)), static fn($line) => $line !== '');

            if (empty($lines)) {
                return null;
            }

            $normalized = implode('', array_map(static fn($line) => '<p>' . static::escapeText($line) . '</p>', $lines));

            return $normalized ?: null;
        }

        // Ensure lists and paragraphs are separated by line breaks for readability
        $normalized = preg_replace('#\n+#', '', $normalized);
        $normalized = preg_replace('#(<\/li>)(?=<li>)#', '$1', $normalized);

        return trim($normalized) ?: null;
    }

    /**
     * Prepare sanitized HTML for pre-filling the editor.
     */
    public static function forEditor(?string $content): string
    {
        return static::sanitize($content) ?? '';
    }

    /**
     * Escape plain text for HTML output inside sanitization pipeline.
     */
    protected static function escapeText(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
