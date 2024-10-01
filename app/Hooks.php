<?php

declare(strict_types=1);

namespace SsThemeTweaks\App;

class Hooks
{
    public function __construct()
    {
        /**
         * WooCommerce
         */
        add_filter('woocommerce_enqueue_styles', '__return_false');
        add_filter('woocommerce_get_image_size_gallery_thumbnail', ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_gallery_thumbnail_callback']);
        add_filter('woocommerce_get_image_size_thumbnail', ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_thumbnail_callback']);
        add_filter('woocommerce_get_image_size_single', ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_single_callback']);
        add_filter('woocommerce_prevent_admin_access', '__return_false', PHP_INT_MAX);
    }
}