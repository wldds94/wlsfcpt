<?php
// normalize attribute keys, lowercase
$atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
// override default attributes with user attributes
$sc_atts = shortcode_atts(
    array(
        'post_id' => 1,
    ),
    $atts
);

$post = get_post( $sc_atts['post_id'] );

$termProduct = getAllTermsBySfProduct( $post->ID ); 
// print_r($post);
$termProductSlug = getTermsSlug($termProduct->slug);
?>

<div class="wl-slider-content row h-100" data-codice="156" data-slug="<?php echo esc_attr( $termProductSlug ); ?>">

    <div class="col-6">
        <div class="row h-100">
            <div class="col-12 col-sm-6 col-md-4 col-xx">
                <div class="spacer-40 spacer-sm-0"></div>
                <div class="birra-nome text-white"><?php echo __( 'Flowers', 'wlsfcpt' ); ?></div>
            </div>
            <div class="col-12 col-sm-9 offset-sm-3 col-md-8 offset-md-0 col-xx-auto align-self-center">
                
                <?php if( has_post_thumbnail( $post->ID ) ) : ?>
                    <?php $featured_image = get_the_post_thumbnail_url( $post->ID ); ?>
                    <img src="<?php echo esc_url( $featured_image ); ?>" class="img-fluid wp-post-image" alt="" loading="lazy" data-eio="p">
                <?php endif; ?>
                
                                                    
                <div class="spacer-40 spacer-sm-0"></div>
            </div>
        </div>
    </div>

    <div class="col-5 align-self-center">
        <div class="slider_title title_container"><?php echo esc_html( $post->post_title ); ?><!-- Critical --></div>
        <div class="spacer-0 spacer-sm-50"></div>
        <div class="spacer-10"></div>
        <div class="row">
            <div class="col-12 col-md-auto">
                <div class="btn">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'sfproduct' ) ); ?>" 
                        title="Archivio prodotti Sayfarm" class="text-uppercase d-inline-block"><?php echo __( 'Discover our products', 'wlsfcpt' ); ?></a>
                </div>
            </div>
        </div>
        <div class="spacer-80 d-none d-sm-block"></div>
    </div>

</div>