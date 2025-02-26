<?php

namespace ThemeTweaks\App\Common\Tweaks;

defined( 'ABSPATH' ) || exit;

class Tweaks {
	public ?Wp $wp = null;
	
	public ?Wc $wc = null;

	public function __construct() {
		$this->wp = new Wp();
		$this->wc = new Wc();
	}
}