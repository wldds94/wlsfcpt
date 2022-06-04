<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlident
 */
namespace Wlsfcpt\Base;

use Wlsfcpt\Base\BaseController;

class Enqueue extends BaseController
{
	/**
	 * Register the Wordpress core Hooks 
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function register() {
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueuePublic' ) );

		// Customize palettes
		// add_action('customize_controls_print_footer_scripts', array( $this, 'customizePaletteIris' ) );
	}

	/*public function customizePaletteIris() { 
	?>
		<script>
			jQuery(document).ready(function($){
				$.wp.wpColorPicker.prototype.options = {
					palettes: ['#d6c4a7', '#000000','#dd3333', '#dd9933','#eeee22', '#81d742', '#ff0000']
				};
			});
		</script>
	<?php
	}*/
	
	/**
	 * Enqueue All Default Admin scripts
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function enqueue() { 

		if( $this->isInAdminPages() ) {
			// wp_enqueue_script( 'jquery' );

			// wp_enqueue_script( 'media-upload' );
			// wp_enqueue_media();

			// // Bootstrap
			// wp_enqueue_style( 'wlident_bootstrap_style', $this->plugin_url . 'dist/library/css/bootstrap.min.css' );
			// wp_enqueue_script( 'wlident_bootstrap_script', $this->plugin_url . 'dist/library/js/bootstrap.min.js' );

            // // DataTables Dependency
			// wp_enqueue_style( 'wlninja_datatables_style', $this->plugin_url . 'dist/library/css/jquery.dataTables.min.css' );
			// wp_enqueue_script( 'wlninja_datatables_script', $this->plugin_url . 'dist/library/js/jquery.dataTables.min.js', array( 'jquery' ) );

            // // Font Awesome Dependencies
			// wp_enqueue_style( 'wlninja-load-fa-600', $this->plugin_url . 'dist/library/css/fontawesome.all.min.css' );
	
			// wp_enqueue_style( 'wlninja_style', $this->plugin_url . 'dist/css/style.css' );
			// wp_enqueue_script( 'wlninja_admin_script', $this->plugin_url . 'dist/js/admin.js', array( 'jquery' ) );	

			// // Localize the keys of the buttons for catch the error in "button_id" input of the form in admin-scripts - Don't touch
			// wp_localize_script( 'wlninja_admin_script', 'wlninja_admin_vars', array(
			// 	'author'      => 'Walter Laidelli',
			// 	'ajax_url'    => admin_url( 'admin-ajax.php' ),
            //     'wl_nonce'    => wp_create_nonce( 'wlank_validate_nonce' ) // wp_nonce_field( 'ajax-wlninja-nonce', 'wlninja_validate_button' )
			// ) );
		}
	}

	/**
	 * Enqueue All Default Public scripts
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function enqueuePublic()
	{
		global $post; // $post_type = get_post_type($post); $isArchive = is_archive(); // dd($post_type);

		if ( is_post_type_archive('sfproduct') || (is_single() && get_post_type($post) == 'sfproduct')) {
			wp_enqueue_script( 'jquery' );

			// Bootstrap
			wp_enqueue_style( 'wlninja_bootstrap_style_public', $this->plugin_url . 'dist/library/css/bootstrap.min.css' );
			wp_enqueue_script( 'wlninja_bootstrap_script_public', $this->plugin_url . 'dist/library/js/bootstrap.min.js' );

		}

		// Custom App Scripts
		wp_enqueue_style( 'wlsfcpt_style_public', $this->plugin_url . 'dist/css/style.css' );
		wp_enqueue_script( 'wlsfcpt_script_public', $this->plugin_url . 'dist/js/public.js' );
		
		// Font Awesome Dependencies
		wp_enqueue_style( 'wlninja-load-fa-600_public', $this->plugin_url . 'dist/library/css/fontawesome.all.min.css' );
		
	}

}