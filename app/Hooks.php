<?php

declare(strict_types=1);

namespace SsThemeTweaks\App;

class Hooks
{
    public function __construct()
    {
        add_action('after_setup_theme', ['\SsThemeTweaks\App\Actions', 'after_setup_theme_callback']);

        add_action('init', ['\SsThemeTweaks\App\Actions', 'init_callback']);

        add_action('add_attachment', ['\SsThemeTweaks\App\Actions', 'add_attachment_callback']);

        add_filter(
            'intermediate_image_sizes',
            ['\SsThemeTweaks\App\Filters', 'intermediate_image_sizes_callback'],
            PHP_INT_MAX
        );

        add_filter('sanitize_file_name', ['\SsThemeTweaks\App\Filters', 'sanitize_file_name_callback']);

        add_filter(
            'ajax_query_attachments_args',
            ['SsThemeTweaks\App\Filters', 'ajax_query_attachments_args_callback']
        );

        /**
         * WooCommerce
         */
        add_filter('woocommerce_enqueue_styles', '__return_false');
        add_filter('woocommerce_get_image_size_gallery_thumbnail',
            ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_gallery_thumbnail_callback']);
        add_filter('woocommerce_get_image_size_thumbnail',
            ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_thumbnail_callback']);
        add_filter('woocommerce_get_image_size_single',
            ['\SsThemeTweaks\App\Woocommerce\Filters', 'wc_get_image_size_single_callback']);
        add_filter('woocommerce_prevent_admin_access', '__return_false', PHP_INT_MAX);
    }
}
