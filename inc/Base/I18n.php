<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlident
 */
namespace Wlsfcpt\Base;

use Wlsfcpt\Base\BaseController;

class I18n extends BaseController
{
	/**
	 * Register the Wordpress core Hooks 
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function register() {
		/** PLUGIN TEXT DOMAIN */
        add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

        add_filter( 'load_textdomain_mofile', array( $this, 'my_plugin_load_my_own_textdomain' ), 10, 2 );
	}

    public function my_plugin_load_my_own_textdomain( $mofile, $domain ) {
        if ( 'wlsfcpt' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
            $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
            $mofile = WP_PLUGIN_DIR . '/wlsfcpt/languages/' . $domain . '-' . $locale . '.mo';
        }
        return $mofile;
    }

    /**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wlsfcpt',
			false,
			$this->plugin . '/languages/'
		);

	}
}