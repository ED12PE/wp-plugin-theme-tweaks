<?php

namespace ThemeTweaks\App;

final class Main {
	public ?Common\Tweaks\Tweaks $tweaks = null;

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->load();
	}

	private function load() {
		$this->tweaks = new Common\Tweaks\Tweaks();
	}
}