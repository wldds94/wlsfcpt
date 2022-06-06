<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlident
 */
namespace Wlninja\Api;

class Sanitizer {

	public function sanitizeArray( array $input, array $args )
	{
		$output = array();

		foreach ($args as $key => $value) {
			if( is_array( $value ) ) {
				$output[$key] = $this->sanitizeArray( $input[$key], $value );
			} elseif( array_key_exists( $key, $input ) ) $output[$key] = $this->$value( $input[$key] );
		}

		return $this->recursiveUnset( $output );
	}

	public function recursiveUnset( array $array = array() )
	{
		$output = array();

		foreach ($array as $key => $value) {
			if ( is_array($value) ) {
                $aux = $this->recursiveUnset( $value );
                if( count($aux) > 0 ) $output[$key] = $aux;                
			} else {
				if( ! empty( $value ) ) $output[$key] = $value;
			}
		}

		return $output;
	}

    public static function staticRecursiveUnset( array $array = array() )
    {
        return (new self)->recursiveUnset( $array );
    }

    /* ---------------------------------------------------- *
	*  -------------- SANITIZE CALLBACKS
	*  ---------------------------------------------------- */

	/**
	 * General sanitizazion
	 */

    /**
	 * Validate ID settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
    public function sanitizeId( $data )
    {
		$value = '';
        if( $data && strlen( $data ) > 0 && $data != '' ) {
			$newValue = str_replace( ',' , '-' , $data );
			$newValue2 = str_replace( '.' , '-' , $newValue );
			$value = urlencode( strtolower( str_replace( ' ' , '-' , $newValue2 ) ) );
		}
		return $value;
    }

	/**
	 * Validate TEXT settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
    public function sanitizeText( string $data = '' )
    {
		$value = '';
        if( $data && strlen( $data ) > 0 && $data != '' ) {
			$value = sanitize_text_field( $data );
		}
		return $value;
    }

    /**
	 * Validate URL settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeUrl( $data = '' ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$value = esc_url_raw( strip_tags( stripslashes( $data ) ) );
		}
		return $value;
	}

    /**
	 * Validate EXTRA-CLASS &&& EXTRA-ID settings field
	 * 
	 * @param  string   $data   Inputted value
	 * @return string           Validated value
	 */
	public function sanitizeClassId( $data = '' )
	{
		$classes = explode(" ", $data);
		$value = '';
		foreach ($classes as $index => $class ) {
			$value .= sanitize_text_field( sanitize_html_class( $class ) ) . ' ';
		}
		
		return rtrim( $value, ' ' );	
	}

    /**
	 * Validate COLOR settings field
	 * 
	 * @param  string   $data   Inputted value
	 * @return string           Validated value
	 */
	public function sanitizeHexColor( $data = '' )
	{
		$value = sanitize_hex_color( $data );
		return $value;	
	}

	/**
	 * Validate INTEGER settings field
	 * 
	 * @param  string  $data  Inputted value
	 * @return int            Validated value
	 */
	public function sanitizeInteger( $data = '' )
	{
		$value = absint( abs( intval( $data ) ) );
		return $value;	
	}

	/**
	 * Validate TEXTAREA settings field
	 * 
	 * @param  string  $data  Inputted value
	 * @return int            Validated value
	 */
	public function sanitizeTextarea( $data = '' )
	{
		return sanitize_textarea_field( $data );	
	}

	public function sanitizeTextareaCss( $data = '' )
	{
		return sanitize_textarea_field( htmlspecialchars( strip_tags($data), ENT_HTML5 | ENT_NOQUOTES | ENT_SUBSTITUTE, 'utf-8' ) );
	}

	
	public function sanitizeCheckbox( $data )
	{
		return isset( $data ) ? 1 : '';
	}

	/**
	 * Validate BOOLEAN settings field
	 * 
	 * @param  string $data Inputted value
	 * @return array        Validated value
	 */
	public function sanitizeBoolean( $data )
	{
		return isset( $data ) ? true : false;	
	}

	public function sanitizeBooleanArray( $data )
	{
		$output = array();

		foreach ($data as $key => $value) {
			$output[$key] = $this->sanitizeBoolean( $value );
		}
		
		return $output;
	}

}