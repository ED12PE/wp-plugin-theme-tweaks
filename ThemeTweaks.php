<?php

/**
 * Plugin Name:  SS - Theme Tweaks
 * Description:  Modifies native WordPress behavior focusing on better performance, security and long-term site management.
 * Version:      1.0.0
 * Author:       Filipe Seabra
 * Author URI:   https://filipeseabra.me
 * License:      GPLv3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:  wpss-theme-tweaks
 */

namespace SsThemeTweaks;

use SsThemeTweaks\App\Hooks;

class ThemeTweaks
{
    private static ?ThemeTweaks $instance = null;

    protected function __construct()
    {
        require __DIR__.'/vendor/autoload.php';

        new Hooks();
    }

    /**
     * Hooked into `plugins_loaded` action hook.
     *
     * @return  ThemeTweaks  Class instance.
     */
    public static function getInstance(): ?ThemeTweaks
    {
        if ( ! (self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

add_action('plugins_loaded', ['SsThemeTweaks\ThemeTweaks', 'getInstance']);