<?php

namespace SsThemeTweaks\App;

class Hooks
{
    public function __construct()
    {
        add_action('init', ['\SsThemeTweaks\App\Actions', 'init_callback']);
        add_action('add_attachment', ['\SsThemeTweaks\App\Actions', 'add_attachment_callback']);

        add_filter(
            'intermediate_image_sizes',
            ['\SsThemeTweaks\App\Filters', 'intermediate_image_sizes_callback'],
            PHP_INT_MAX
        );
        add_filter('sanitize_file_name', ['\SsThemeTweaks\App\Filters', 'sanitize_file_name_callback']);
    }
}