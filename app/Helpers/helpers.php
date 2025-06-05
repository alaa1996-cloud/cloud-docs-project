<?php

if (!function_exists('highlightKeyword')) {
    function highlightKeyword($text, $keyword) {
        if (!$keyword) return e($text);
        $escapedKeyword = preg_quote($keyword, '/');
        $escapedText = e($text);
        return preg_replace("/($escapedKeyword)/i", '<mark>$1</mark>', $escapedText);
    }
}
