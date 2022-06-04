<?php

namespace SsThemeTweaks\App;

use WP_Post;

class Filters
{
    /**
     * @param  array  $image_sizes
     *
     * @return array
     */
    public static function intermediate_image_sizes_callback(array $image_sizes): array
    {
        $bad_sizes = array(
            array_search('medium_large', $image_sizes) // Returns the key which contains the 'medium_large' value.
        );

        foreach ($bad_sizes as $size_key) {
            if ($size_key === false) {
                continue;
            }

            unset($image_sizes[$size_key]);
        }

        return $image_sizes;
    }

    /**
     * Rename file name after upload.
     *
     * @param  string  $filename  Sanitized filename.
     *
     * @return string
     */
    public static function sanitize_file_name_callback(string $filename): string
    {
        $info    = pathinfo($filename);
        $ext     = empty($info['extension']) ? '' : '.'.$info['extension'];
        $name    = basename($filename, $ext);
        $post_id = $_REQUEST['post_id'] ?? $_REQUEST['post'] ?? 0;

        if ($post_id) {
            $post_obj = get_post($post_id);

            if ($post_obj instanceof WP_Post) {
                $post_slug = sanitize_title(sanitize_html_class($post_obj->post_title));
            }
        }

        if ( ! empty($post_slug) && $post_slug != sanitize_title(__('Auto Draft'))) {
            // File name will be the same as the post slug.
            $filename = $post_slug;
        } else {
            // File name will be the same as the image file name, but sanitized.
            $filename = sanitize_html_class(sanitize_title($name));
        }

        $filename .= wp_unique_id(time());
        $filename .= $ext;

        return $filename;
    }

    /**
     * Filters the arguments passed to WP_Query during an Ajax call for querying attachments.
     *
     * @param  array  $query  An array of query variables.
     *
     * @return  array
     */
    public static function ajax_query_attachments_args_callback(array $query): array
    {
        if (empty($_POST['post_id'])) {
            return $query;
        }

        $query['post_parent__in'] = array($_POST['post_id']);

        return $query;
    }
}