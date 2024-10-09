<?php

namespace ThemeTweaks\App\Common\Tweaks;

defined( 'ABSPATH' ) || exit;

class Wp {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'afterSetupThemeCallback' ] );
		add_action( 'init', [ $this, 'initCallback' ] );
		add_action( 'add_attachment', [ $this, 'addAttachmentCallback' ] );

		add_filter( 'intermediate_image_sizes', [ $this, 'intermediateImageSizesCallback' ], 9999 );
		add_filter( 'sanitize_file_name', [ $this, 'sanitizeFileNameCallback' ] );
		add_filter( 'ajax_query_attachments_args', [ $this, 'ajaxQueryAttachmentsArgsCallback' ] );
	}

	public function afterSetupThemeCallback(): void {
		add_post_type_support( 'page', 'excerpt' );
	}

	public function initCallback(): void {
		remove_image_size( '1536x1536' );
		remove_image_size( '2048x2048' );

		unregister_taxonomy_for_object_type( 'post_tag', 'post' );
	}

	/**
	 * Fires once an attachment has been added.
	 *
	 * @param  int $post_id Attachment ID.
	 */
	public function addAttachmentCallback( int $post_id ): void {
		if ( ! wp_attachment_is_image( $post_id ) ) {
			return;
		}

		$att_obj        = get_post( $post_id );
		$att_parent_id  = $att_obj->post_parent;
		$att_parent_obj = get_post( $att_parent_id );

		if ( empty( $att_parent_obj ) ) {
			return;
		}

		$att_parent_title = $att_parent_obj->post_title;

		if ( empty( $att_parent_title ) ) {
			return;
		}

		update_post_meta( $post_id, '_wp_attachment_image_alt', $att_parent_title );

		wp_update_post( array(
			'ID'         => $post_id,
			'post_title' => $att_parent_title,
			// 'post_excerpt' => $att_title, // Set image Caption (Excerpt)
			// 'post_content' => $att_title, // Set image Description (Content)
		) );
	}

	/**
	 * @param  array $image_sizes
	 * @return array
	 */
	public function intermediateImageSizesCallback( array $image_sizes ): array {
		$bad_sizes = array(
			array_search( 'medium_large', $image_sizes ) // Returns the key which contains the 'medium_large' value.
		);

		foreach ( $bad_sizes as $size_key ) {
			if ( $size_key === false ) {
				continue;
			}

			unset( $image_sizes[ $size_key ] );
		}

		return $image_sizes;
	}

	/**
	 * Rename file name after upload.
	 *
	 * @param  string $filename Sanitized filename.
	 * @return string
	 */
	public function sanitizeFileNameCallback( string $filename ): string {
		$info    = pathinfo( $filename );
		$ext     = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
		$name    = basename( $filename, $ext );
		$post_id = $_REQUEST['post_id'] ?? $_REQUEST['post'] ?? 0;

		if ( $post_id ) {
			$post_obj = get_post( $post_id );

			if ( $post_obj instanceof \WP_Post ) {
				$post_slug = sanitize_title( sanitize_html_class( $post_obj->post_title ) );
			}
		}

		if ( ! empty( $post_slug ) && $post_slug != sanitize_title( __( 'Auto Draft' ) ) ) {
			// File name will be the same as the post slug.
			$filename = $post_slug;
		} else {
			// File name will be the same as the image file name, but sanitized.
			$filename = sanitize_html_class( sanitize_title( $name ) );
		}

		$filename .= wp_unique_id( time() );
		$filename .= $ext;

		return $filename;
	}

	/**
	 * Filters the arguments passed to WP_Query during an Ajax call for querying attachments.
	 *
	 * @param  array $query An array of query variables.
	 * @return array
	 */
	public function ajaxQueryAttachmentsArgsCallback( array $query ): array {
		if ( empty( $_POST['post_id'] ) ) {
			return $query;
		}

		$query['post_parent__in'] = array( $_POST['post_id'] );

		return $query;
	}
}