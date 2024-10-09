<?php

namespace ThemeTweaks\App\Common\Tweaks;

defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce Tweaks.
 */
class Wc {

    /**
     * Constructor.
     */
    public function __construct() {
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
        add_filter( 'woocommerce_get_image_size_gallery_thumbnail', [ $this, 'wcGetImageSizeGalleryThumbnailCallback' ] );
        add_filter( 'woocommerce_get_image_size_thumbnail', [ $this, 'wcGetImageSizeThumbnailCallback' ] );
        add_filter( 'woocommerce_get_image_size_single', [ $this, 'wcGetImageSizeSingleCallback' ] );
        add_filter( 'woocommerce_prevent_admin_access', '__return_false', PHP_INT_MAX);
    }

    /**
     * Gets the Images size for the gallery thumbnail
     * 
     * @return array {
     *   @type int $width  The width of the thumbnail.
     *   @type int $height The height of the thumbnail.
     *   @type int $crop   The crop setting for the thumbnail (1 for true).
     * }
     */
    public function wcGetImageSizeGalleryThumbnailCallback(): array {
        return [
            'width'  => get_option( 'thumbnail_size_w' ),
            'height' => get_option( 'thumbnail_size_h' ),
            'crop'   => 1,
        ];
    }

    /**
     * Gets the Images size for the thumbnail
     * 
     * @return array {
     *   @type int $width  The width of the thumbnail.
     *   @type int $height The height of the thumbnail.
     *   @type int $crop   The crop setting for the thumbnail (1 for true).
     * }
     */
    public function wcGetImageSizeThumbnailCallback(): array {
        return [
            'width'  => get_option( 'medium_size_w' ),
            'height' => get_option( 'medium_size_h' ),
            'crop'   => 0,
        ];
    }

    /**
     * Gets the Images size for the single image
     * 
     * @return array {
     *   @type int $width  The width of the thumbnail.
     *   @type int $height The height of the thumbnail.
     *   @type int $crop   The crop setting for the thumbnail (1 for true).
     * }
     */
    public function wcGetImageSizeSingleCallback(): array {
        return [
            'width'  => get_option( 'large_size_w' ),
            'height' => get_option( 'large_size_h' ),
            'crop'   => 0,
        ];
    }
}