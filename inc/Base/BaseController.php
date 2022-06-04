<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlsfcpt
 */
namespace Wlsfcpt\Base;

class BaseController
{
	public $version;

	public $style_ver;

	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public $valid_pages;

	public function __construct() {

		$this->version = WLSFCPT_VERSION;
		$this->style_ver = str_replace( ".", "", $this->version );
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/wlsfcpt.php';

		$this->valid_pages = array();

    }

	/**
	 * Check is isset an option with your key
	 * @since    1.0.0
	 * 
	 * @param    string   $key
	 * @param    string   $option_name
	 * @return   bool
	 */
	public function activated( string $key, string $option_name = 'wlsfcpt_plugin' )
	{
		$option = get_option( $option_name );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}

	/**
	 * Check is the request on WP backend contain $this->valid_pages
	 * @since    1.0.0
	 * 
	 * @return   bool
	 */
	public function isInAdminPages()
	{
		$page = isset( $_REQUEST[ 'page' ] ) ? sanitize_title( $_REQUEST[ 'page' ] ) : ''; // Recupero la richiesta della pagina
		return in_array( $page, $this->valid_pages ) ? true : false;

	}

}
