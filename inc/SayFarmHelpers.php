<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package Wlank
 */

if ( ! function_exists( 'getTerpenicProfile' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function getTerpenicProfile( $profile ) {
		$profiles = getAllTerpenicProfile();

		return isset($profiles[$profile]) ? $profiles[$profile] : '';
	}
}

if ( ! function_exists( 'getAllTerpenicProfile' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function getAllTerpenicProfile() {

		return array(
			'cheese' => __( 'Cheese', 'wlsfcpt' ),
			'exotic'   => __( 'Exotic', 'wlsfcpt' ),
			'hazelmut'  => __( 'Noisette', 'wlsfcpt' ),
			'earthy' => __( 'Earthy', 'wlsfcpt' ),
			'agrumato' => __( 'Citrusy', 'wlsfcpt' ),
			'fruity' => __( 'Fruity', 'wlsfcpt' ),
			'na' => '-'
			// 'cheese' => __( 'Cheese', 'wlsfcpt' ),
			// 'exotic'   => __( 'Esotico', 'wlsfcpt' ),
			// 'hazelmut'  => __( 'Nocciolato', 'wlsfcpt' ),
			// 'earthy' => __( 'Terroso', 'wlsfcpt' ),
			// 'agrumato' => __( 'Agrumato', 'wlsfcpt' ),
			// 'fruity' => __( 'Fruttato', 'wlsfcpt' ),
			// 'na' => __( 'Non Disponibile', 'wlsfcpt' )
		);
	}
}

if ( ! function_exists( 'getSlideShortcodeString' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function getSlideShortcodeString() {

		$string = '';
		$id = isset( $_GET['post'] ) ? absint( sanitize_text_field ( $_GET['post'] ) ) : '';
		if ($id != '') {
			$string .= '[wlsfcpt_slide_single post_id="' . esc_attr($id) . '"]';
		}
		return $string;
	}
}

if ( ! function_exists( 'getAllSfProductCategories' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function getAllSfProductCategories() {

		$terms = get_terms( array(
			'taxonomy' => 'wlsfcpt_category',
			'hide_empty' => false,
		) );

		return $terms;
	}
}

if ( ! function_exists( 'getAllTermsBySfProduct' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function getAllTermsBySfProduct( $post ) {
		return get_the_terms( $post, 'wlsfcpt_category' )[0];
		// return count($terms > 0) ? $terms[0] : '';
	}
}


if ( ! function_exists( 'getTermsSlug' ) ) {
	/**
	 * string $termProduct
	 *
	 * @return string
	 */
	function getTermsSlug( $termProduct ) {
		$expl = explode('-', $termProduct);
		if (count($expl) > 1) {
			$termProductSlug = '';
			for ($i=0; $i < count($expl) - 1; $i++) { 
				$termProductSlug .= $expl[$i];
			}
			return $termProductSlug;
		}
		return $termProduct;		
	}
}