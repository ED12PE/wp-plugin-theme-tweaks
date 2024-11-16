<?php

namespace ThemeTweaks\App\Common\Admin;

defined( 'ABSPATH' ) || exit;

class Admin {
	/**
	 * The page slug for the sidebar.
	 *
	 * @var string
	 */
	protected $pageSlug = 'theme-tweaks';

	/**
	 * Sidebar menu name.
	 *
	 * @var string
	 */
	public $menuName = 'Theme Tweaks';

	/**
	 * An array of pages for the admin.
	 *
	 * @var array
	 */
	protected $pages = [];

	/**
	 * The current page we are enqueuing.
	 *
	 * @var string
	 */
	protected $currentPage;

	/**
	 * An array of asset slugs to use.
	 *
	 * @var array
	 */
	protected $assetSlugs = [
		'pages' => 'src/vue/pages/{page}/main.js'
	];

	/**
	 * Construct method.
	 */
	public function __construct() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( wp_doing_ajax() || wp_doing_cron() ) {
			return;
		}

		add_action( 'sanitize_comment_cookies', [ $this, 'init' ], 20 );
	}

	/**
	 * Initialize the admin.
	 *
	 * @return void
	 */
	public function init() {
		if ( is_admin() ) {
			// Add the menu to the sidebar.
			add_action( 'admin_menu', [ $this, 'addMenu' ] );
			add_action( 'admin_footer', [ $this, 'addModalPortal' ] );
		}

		$this->loadTextDomain();
		$this->setPages();
	}

	/**
	 * Sets our menu pages.
	 * It is important this runs after loading the text domain.
	 *
	 * @return void
	 */
	protected function setPages() {
		$this->pages = [
			$this->pageSlug => [
				'parent'              => 'options-general.php',
				'menu_title'          => esc_html__( 'Theme Tweaks', 'text-domain' ),
				'capability'          => '',
				'hide_admin_bar_menu' => false
			],
		];
	}

	/**
	 * Get the required capability for given admin page.
	 *
	 * @param  string $pageSlug The slug of the page.
	 * @return string           The required capability.
	 */
	public function getPageRequiredCapability( $pageSlug ) { // phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return apply_filters( 'manage_options', 'manage_options' );
	}

	/**
	 * Add the menu inside of WordPress.
	 *
	 * @return void
	 */
	public function addMenu() {
		foreach ( $this->pages as $slug => $page ) {
			$hook = add_submenu_page(
				$page['parent'],
				! empty( $page['page_title'] ) ? $page['page_title'] : $page['menu_title'],
				$page['menu_title'],
				$this->getPageRequiredCapability( $slug ),
				$slug,
				[ $this, 'page' ]
			);

			add_action( "load-$hook", [ $this, 'hooks' ] );
		}

		if ( ! current_user_can( $this->getPageRequiredCapability( $this->pageSlug ) ) ) {
			remove_submenu_page( $this->pageSlug, $this->pageSlug );
		}
	}

	/**
	 * Output the HTML for the page.
	 *
	 * @return void
	 */
	public function page() {
		echo '<div id="' . THEME_TWEAKS_SLUG . '-app"></div>';
	}

	/**
	 * Hooks for loading our pages.
	 *
	 * @return void
	 */
	public function hooks() {
		$currentScreen = themeTweaks()->utils->getCurrentScreen();

		global $admin_page_hooks;

		if ( ! is_object( $currentScreen ) || empty( $currentScreen->id ) || empty( $admin_page_hooks ) ) {
			return;
		}

		$pages = [
			'settings'
		];

		foreach ( $pages as $page ) {
			$this->currentPage = $page;
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAssets' ] );
//			add_action( 'admin_enqueue_scripts', [ aioseo()->filters, 'dequeueThirdPartyAssets' ], 99999 );
//			add_action( 'admin_enqueue_scripts', [ aioseo()->filters, 'dequeueThirdPartyAssetsEarly' ], 0 );

			break;
		}
	}

	/**
	 * Checks whether the current page is an AIOSEO menu page.
	 *
	 * @return bool Whether the current page is an AIOSEO menu page.
	 */
	public function isAioseoScreen() {
		$currentScreen = aioseo()->helpers->getCurrentScreen();
		if ( empty( $currentScreen->id ) ) {
			return false;
		}

		$adminPages = array_keys( $this->pages );
		$adminPages = array_map( function ( $slug ) {
			if ( 'aioseo' === $slug ) {
				return 'toplevel_page_aioseo';
			}

			return 'all-in-one-seo_page_' . $slug;
		}, $adminPages );

		return in_array( $currentScreen->id, $adminPages, true );
	}

	/**
	 * Enqueue admin assets for the current page.
	 *
	 * @return void
	 */
	public function enqueueAssets() {
		$page = str_replace( '{page}', $this->currentPage, $this->assetSlugs['pages'] );

//		var_dump( $page );
//		exit;
//		if ( $hook_suffix !== 'settings_page_' . wpManutencao()->settings->page ) {
//			return;
//		}

		themeTweaks()->utils->loadAsset( 'app' );
		themeTweaks()->utils->loadAsset( 'dashboard' );
	}

	/**
	 * Get the first available page item for the current user.
	 *
	 * @return bool|string The page slug.
	 */
	public function getFirstAvailablePageSlug() {
		foreach ( $this->pages as $slug => $page ) {
			// Ignore other pages.
			if ( $this->pageSlug !== $page['parent'] ) {
				continue;
			}

			if ( current_user_can( $this->getPageRequiredCapability( $slug ) ) ) {
				return $slug;
			}
		}

		return false;
	}

	/**
	 * Loads the plugin text domain.
	 *
	 * @return void
	 */
	public function loadTextDomain() {
//		aioseo()->helpers->loadTextDomain( 'text-domain' );
	}

	/**
	 * Add the div for the modal portal.
	 *
	 * @return void
	 */
	public function addModalPortal() {
		echo '<div id="theme-tweaks-modal-portal"></div>';
	}
}