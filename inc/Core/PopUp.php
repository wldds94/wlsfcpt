<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlsfcpt\Core;

use Inc\Api\SettingsApi;
use Wlsfcpt\Base\BaseController;

class PopUp extends BaseController
{
	public function register()
	{
        add_action('wp_body_open', array( $this, 'add_html_popup' ) );
        // add_action('wp_body', array( $this, 'add_html_popup' ) );
        // add_action( 'init', array( $this, 'setup_cpt' ) );

        // // Filter Archive Page Template for sfproduct CPT
        // add_filter( 'archive_template', array( $this, 'wlsfcpt_archive_template' ) ) ;

        // // Filter the single_template for sfproduct CPT
        // add_filter('single_template', array( $this, 'wlsfcpt_singlepost_template' ) );

		// // Try CMB2
		// add_action( 'cmb2_admin_init', array( $this, 'cmb2_extra_metaboxes' ) );

		// // Slide Shortcode
		// add_shortcode( 'wlsfcpt_slide_single', array( $this, 'wlsfcpt_shortcode_slide_single' ) );
	}

	/**
	 * CORE
	 */
    public function add_html_popup()
    { ?>
        <div id="wlsf-popup-container">
            <div id="popup-overlay"></div>
            
            <div class="btm-sticky">
                <div class='sticky-ads-close'>
                    <svg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'><path d='M278.6 256l68.2-68.2c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-68.2-68.2c-6.2-6.2-16.4-6.2-22.6 0-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3l68.2 68.2-68.2 68.2c-3.1 3.1-4.7 7.2-4.7 11.3 0 4.1 1.6 8.2 4.7 11.3 6.2 6.2 16.4 6.2 22.6 0l68.2-68.2 68.2 68.2c6.2 6.2 16.4 6.2 22.6 0 6.2-6.2 6.2-16.4 0-22.6L278.6 256z' /></svg>
                </div>
                <a class="btm-cta-link" href="https://sayfarm.it/sfproduct/afghan-gold">
                    <!-- <div class="badge">
                        <div class="badge-sale orange">Discount</div>
                    </div> -->
                    
                    <div class="popup-container">
                        
                        <div class="pull-left">
                        <img src="https://sayfarm.it/wp-content/uploads/2022/04/Logo_SayFarm_negative_2022.png" class="responsive big">
                        <!-- <img src="https://sayfarm.it/wp-content/uploads/2022/04/Logo_SayFarm_negative_2022.png" class="responsive small"> -->
                        </div>
                        
                    <div class="pull-center">
                        <h3>PROMO</h3>
                        <p>Sconto del 50% sul nostro prodotto Rolex <span class="link"><i class="fa-solid fa-arrow-right-long"></i></span></p>
                    </div>
                        
                    <div class="pull-right">
                        <img src="https://sayfarm.it/wp-content/uploads/2022/03/export_600px_merged_0038_-bubble-gum-002.png"  class="responsive">
                    </div>

                    </div>
                        
                    <!-- <div class="price">
                        <p><span class="i-rupee"></span> 3.5 Cr onwards</p>
                    </div> -->
                    
                </a>
            </div>
        </div>
      <?php  
    }
	
}