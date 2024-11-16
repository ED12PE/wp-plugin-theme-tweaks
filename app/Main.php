<?php

namespace ThemeTweaks\App;

defined( 'ABSPATH' ) || exit;

final class Main {
	public ?Common\Admin\Admin $admin = null;

	public ?Common\Tweaks\Tweaks $tweaks = null;

	public ?Common\Utils\Utils $utils = null;

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->load();
	}

	private function load() {
		$this->utils  = new Common\Utils\Utils();
		$this->admin  = new Common\Admin\Admin();
		$this->tweaks = new Common\Tweaks\Tweaks();
	}
}