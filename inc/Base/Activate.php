<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlsfcpt
 */
namespace Wlsfcpt\Base;

use Wlsfcpt\Base\BaseController;
use Wlsfcpt\Core\Capability;

class Activate extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->default = array();

        $this->activateOption = get_option( 'wlsfcpt_version' );
    }

    /**
	 * Called by Activation Hook
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function activate() {
		flush_rewrite_rules();

        if( $this->activateOption != $this->version ) {
            
            update_option( 'wlsfcpt_version', $this->version );

        }
	}
}