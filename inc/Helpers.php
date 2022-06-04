<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package Wlank
 */

if ( ! function_exists( 'dd' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function dd() {
		echo '<pre>';
		array_map( function( $x ) {
			var_dump( $x );
		}, func_get_args() );
		echo '</pre>';
		die;
	}
}

if ( ! function_exists( 'starts_with' ) ) {
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	function starts_with($haystack, $needles)
	{
		foreach ((array) $needles as $needle) {
			if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
				return true;
			}
		}
		return false;
	}
}

if (! function_exists('mix')) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param  string  $path
	 * @param  string  $manifestDirectory
	 * @return \Illuminate\Support\HtmlString
	 *
	 * @throws \Exception
	 */
	function mix($path, $manifestDirectory = '')
	{
		if (! $manifestDirectory) {
			//Setup path for standard AWPS-Folder-Structure
			$manifestDirectory = "assets/dist/";
		}
		static $manifest;

		if ( starts_with($path, '/')) $path = ltrim( $path, '/' );

		if ($manifestDirectory && ! starts_with($manifestDirectory, '/')) {
			$manifestDirectory = "/{$manifestDirectory}";
		}
		$rootDir = dirname(__FILE__, 2);
		$publicPath = $manifestDirectory . $path;
		$checked_path = $rootDir . $publicPath;
		
		if (file_exists( $checked_path )) {
			return WLANK_THEME_URL . $publicPath;
		} 

		if (! $manifest) {
			$manifestPath =  $rootDir . $manifestDirectory . 'mix-manifest.json';
			if (! file_exists($manifestPath)) {
				throw new Exception('The Mix manifest does not exist.');
			}
			$manifest = json_decode(file_get_contents($manifestPath), true);
		}

		if (starts_with($manifest[$path], '/')) {
			$manifest[$path] = ltrim($manifest[$path], '/');
		}

		$path = $manifestDirectory . $manifest[$path];

		return get_template_directory_uri() . $path;
	}
}

if ( ! function_exists('assets') ) {
	/**
	 * Easily point to the assets dist folder.
	 *
	 * @param  string  $path
	 */
	function assets($path)
	{
		if (! $path) {
			return;
		}

		echo get_template_directory_uri() . '/assets/dist/' . $path;
	}
}

if ( ! function_exists('svg') ) {
	/**
	 * Easily point to the assets dist folder.
	 *
	 * @param  string  $path
	 */
	function svg($path)
	{
		if (! $path) {
			return;
		}

		echo get_template_part('assets/dist/svg/inline', $path . '.svg');
	}
}

if ( ! function_exists('wlankPrintTitleInput') ) {
	/**
	 * Utils for print the label with description of input.
	 *
	 * @param  string  $label
	 * @param  string  $description
	 */
	function wlankPrintTitleInput( string $label, string $description = '' )
    { 
		return html_entity_decode( esc_html( $label ) . ( $description != '' ? ':<span class="descr-light"> ' . esc_html( $description ) . '</span>' : '' ) );
    }
}

if ( ! function_exists('wlankPrintSubTitleInput') ) {
	/**
	 * Utils for print the SUB - label with description of input.
	 *
	 * @param  string  $label
	 * @param  string  $description
	 */
	function wlankPrintSubTitleInput( string $title, string $description = '', string $link = '', string $text_link = '' )
    { 
		echo '<span class="key-description">' .  esc_html($title) . ( $description != '' ? ' - <span class="opacity">' . esc_html( $description ) . ' </span>' : '' ) .
			( $link != '' ? '<a href="' . esc_url($link) . '">' . esc_html($text_link) . '</a>' : '' ) . '</span>';
		// return esc_html( $label ) . ( $description != '' ? '<br><span class="descr-light">' . esc_html( $description ) . '</span>' : '' );
    }
}

if ( ! function_exists('wlankPrintCssSubTitleInput') ) {
	/**
	 * Utils for print the SUB - label with description of input with CSS w3C link.
	 *
	 * @param  string  $label
	 */
	function wlankPrintCssSubTitleInput( string $title )
    { 
		echo '<span class="key-description">' .  esc_html($title) . ' <span class="opacity">Use CSS units value </span><a href="https://www.w3schools.com/cssref/css_units.asp" target="blank">[?]</a></span>';
    }
}

if ( ! function_exists('wlankPrintCssFontSubTitleInput') ) {
	/**
	 * Utils for print the SUB - label with description of input with CSS w3C link.
	 *
	 * @param  string  $label
	 */
	function wlankPrintCssFontSubTitleInput( string $title )
    { 
		echo '<span class="key-description">' .  esc_html($title) . ' <span class="opacity">See more on </span><a href="https://fonts.google.com/" target="blank">Google Fonts</a></span>';
    }
}

if ( ! function_exists('wlankPrintFontAweSubTitleInput') ) {
	/**
	 * Utils for print the SUB - label with description of input with CSS w3C link.
	 *
	 * @param  string  $label
	 */
	function wlankPrintFontAweSubTitleInput( string $title )
    { 
		echo '<span class="key-description">' .  esc_html($title) . ' <span class="opacity">See more on </span><a href="https://fontawesome.com/v6.0/icons" target="blank">Font Awesome</a></span>';
    }
}

/**
 * Date Printer
 */
if ( ! function_exists( 'myhuman_mysql_date' ) ) {
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	function myhuman_mysql_date($string)
	{
		$date = \DateTime::createFromFormat('Y-m-d', $string);

        return $date->format('d-m-Y');

	}
}

/**
 * Real ID
 */
if ( ! function_exists( 'uniqidReal' ) ) {
	/**
	 * Generate a Uniue ID.
	 *
	 * @param  int  $lenght
	 * @return string
	 */
	function uniqidReal($lenght = 13) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}
}