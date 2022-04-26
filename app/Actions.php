<?php

namespace SsThemeTweaks\App;

class Actions
{
    public static function init_callback()
    {
        remove_image_size('1536x1536');
        remove_image_size('2048x2048');
    }

    /**
     * Fires once an attachment has been added.
     *
     * @param  int  $post_id  Attachment ID.
     */
    public static function add_attachment_callback(int $post_id)
    {
        if ( ! wp_attachment_is_image($post_id)) {
            return;
        }

        $att_obj        = get_post($post_id);
        $att_parent_id  = $att_obj->post_parent;
        $att_parent_obj = get_post($att_parent_id);

        if (empty($att_parent_obj)) {
            return;
        }

        $att_parent_title = $att_parent_obj->post_title;

        if (empty($att_parent_title)) {
            return;
        }

        update_post_meta($post_id, '_wp_attachment_image_alt', $att_parent_title);

        wp_update_post(array(
            'ID'         => $post_id,
            'post_title' => $att_parent_title,
            // 'post_excerpt' => $att_title, // Set image Caption (Excerpt)
            // 'post_content' => $att_title, // Set image Description (Content)
        ));
    }
}