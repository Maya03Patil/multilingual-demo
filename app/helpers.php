<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

if (!function_exists('t')) {
    /**
     * The Magic Universal Translator.
     */
    function t($string) {
        if (empty($string)) return $string;

        $locale = app()->getLocale() ?? 'en';
        if ($locale === 'en') return $string;

        $cacheKey = "translation_{$locale}_" . md5($string);
        
        return Cache::rememberForever($cacheKey, function () use ($string, $locale) {
            try {
                // Using the most stable backend-ready machine AI hook
                return GoogleTranslate::trans($string, $locale, 'en');
            } catch (\Exception $e) {
                return $string;
            }
        });
    }
}

/**
 * Universal Mock-Database Persistence Logic
 * Using this for the demo because your SQL driver is missing.
 * In a real project, this would be an Eloquent model.
 */
if (!function_exists('get_mock_products')) {
    function get_mock_products() {
        $products = Session::get('demo_products', [
            (object) [
                'id' => 1,
                'name' => 'Premium Wireless Headphones',
                'description' => 'Experience noise-cancelling 3D sound with 40 hours of battery life.',
                'price' => 299.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=400'
            ],
            (object) [
                'id' => 2,
                'name' => 'Organic Coffee Beans',
                'description' => 'Freshly roasted dark blend coffee directly from Colombian farms.',
                'price' => 19.99,
                'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=400'
            ]
        ]);

        // Ensure everything is an object (prevents "Attempt to read property on array" errors)
        return array_map(function($p) { return (object) $p; }, $products);
    }
}
