<?php

namespace ThemeTweaks\App\Common\Tweaks;


class Wc {

    public function __construct() {
        add_filter('woocommerce_enqueue_styles', '__return_false');
        add_filter('woocommerce_get_image_size_gallery_thumbnail', [ $this, 'wcGetImageSizeGalleryThumbnailCallback']);
        add_filter('woocommerce_get_image_size_thumbnail', [ $this, 'wcGetImageSizeThumbnailCallback']);
        add_filter('woocommerce_get_image_size_single', [ $this, 'wcGetImageSizeSingleCallback']);
        add_filter('woocommerce_prevent_admin_access', '__return_false', PHP_INT_MAX);
    }

    public function wcGetImageSizeGalleryThumbnailCallback(): array {
        return [
            'width'  => get_option('thumbnail_size_w'),
            'height' => get_option('thumbnail_size_h'),
            'crop'   => 1,
        ];
    }

    public function wcGetImageSizeThumbnailCallback(): array {
        return [
            'width'  => get_option('medium_size_w'),
            'height' => get_option('medium_size_h'),
            'crop'   => 0,
        ];
    }

    public function wcGetImageSizeSingleCallback(): array {
        return [
            'width'  => get_option('large_size_w'),
            'height' => get_option('large_size_h'),
            'crop'   => 0,
        ];
    }

}