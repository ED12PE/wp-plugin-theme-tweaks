<?php

declare(strict_types=1);

namespace SsThemeTweaks\App\Woocommerce;

class Filters
{
    /**
     * @return array
     */
    public static function wc_get_image_size_gallery_thumbnail_callback(): array
    {
        return [
            'width'  => get_option('thumbnail_size_w'),
            'height' => get_option('thumbnail_size_h'),
            'crop'   => 1,
        ];
    }

    /**
     * @return array
     */
    public static function wc_get_image_size_thumbnail_callback(): array
    {
        return [
            'width'  => get_option('medium_size_w'),
            'height' => get_option('medium_size_h'),
            'crop'   => 0,
        ];
    }

    /**
     * @return array
     */
    public static function wc_get_image_size_single_callback(): array
    {
        return [
            'width'  => get_option('large_size_w'),
            'height' => get_option('large_size_h'),
            'crop'   => 0,
        ];
    }
}
