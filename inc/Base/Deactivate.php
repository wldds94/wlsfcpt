<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlsfcpt
 */
namespace Wlsfcpt\Base;

use Wlsfcpt\Core\Capability;

class Deactivate 
{
    /**
	 * Called by Deactivation Hook
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function deactivate() {
		flush_rewrite_rules();

		// Remove option - Only stage dev
		delete_option( 'wlsfcpt_version' );
	}
}