<?php

namespace ThemeTweaks\App\Common\Utils;

trait Assets {
	public function loadAsset( string $entryName ) {
		$filterHot = fn( $entry ) => strpos( $entry['url'], 'hot-update' ) === false;
		$manifest  = $this->getManifest();

		$entrypoints = array_filter( $manifest, fn( $value, $key ) => $key === $entryName, ARRAY_FILTER_USE_BOTH );
		foreach ( $entrypoints as $item ) {
			$jsEntries  = $this->entrypoint( 'js', $item );
			$cssEntries = $this->entrypoint( 'css', $item );

			foreach ( array_filter( $jsEntries, $filterHot ) as $entry ) {
				wp_enqueue_script( $entry['handle'], $entry['url'], $entry['deps'], THEME_TWEAKS_VERSION, true );
			}

			foreach ( array_filter( $cssEntries, $filterHot ) as $entry ) {
				wp_enqueue_style( $entry['handle'], $entry['url'], [], THEME_TWEAKS_VERSION );
			}
		}
	}

	private function getManifest() {
		$path = THEME_TWEAKS_PATH . 'dist/entrypoints.json';

		return json_decode( file_get_contents( $path ), true );
	}

	private function entrypoint( string $type, array $entrypoint ) {
		$modules = $entrypoint[ $type ] ?? [];
		$handles = [];

		return array_map(
			function ( $module, $index ) use ( $type, &$handles ) {
				$handles[ $index ] = THEME_TWEAKS_SLUG . ".{$module}.{$index}";
				$handle            = $handles[ $index ];
				$url               = THEME_TWEAKS_ASSETS . $module;
				$deps[]            = $handles[ $index - 1 ] ?? false;

				return [
					'handle' => $handle,
					'url'    => $url,
					'deps'   => array_filter( $deps ),
				];
			},
			$modules,
			array_keys( $modules )
		);
	}
}