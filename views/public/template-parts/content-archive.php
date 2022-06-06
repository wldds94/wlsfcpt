<?php 
/**
 * HORIZONTAL CARD
 */
// $post_id = get_the_ID();
// // echo $post_id;
// $termProduct = getAllTermsBySfProduct( $post_id ); 
// // print_r($termProduct);
// $termProductSlug = getTermsSlug($termProduct->slug);
// // echo $termProductSlug;

// $all_terms = get_the_terms( $post, 'wlsfcpt_category' );
// print_r($all_terms);
$postProductID = $post->ID;
// echo $postProductID . '<br>';
$termProduct = getAllTermsBySfProduct( $post ); 
// echo '<pre>';
// print_r($post);
// print_r($termProduct); echo '<br>';
$termProductSlug = getTermsSlug($termProduct->slug);
// echo $termProductSlug . '<br>';
$termProductSlugCat = get_post_meta( get_the_ID(), 'wlsfcpt_cat_meta', true );
// echo $termProductSlugCat . '<br>';
?>
<?php $availableOnline = get_post_meta( get_the_ID(), 'wlsfcpt_islive', true ) ?: false; ?>
<!-- use wlsfcpt-single-card-archive in JS -->
<div class="wlsfcpt-single-card-archive item is-visible col-lg-4 col-md-6 col-sm-12" data-slug="<?php echo esc_attr( $termProductSlugCat ); ?>">
    <div class="wlsfcpt-single-card wlsfcpt-single-card-horizontal" data-slug="<?php echo esc_attr( $termProductSlugCat ); ?>">
        <div class="wlsf-single-product-container row">

            <?php if ($availableOnline) : ?><a class="wlsfproduct-single-link" href="<?php echo get_post_permalink(); ?>"><?php endif; ?>
            <div class="wlsfcpt-image-section wlsfcpt-<?php echo esc_attr( $termProductSlugCat ); ?>">
                <div class="product-name-container">
                    <?php // the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h3 class="entry-title">', '</h3></a>' ); ?>
                    <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
                </div>

                <div class="wlsf-product-image-container p-2">
                    <?php if( has_post_thumbnail() ) : ?>
                        <?php $featured_image = get_the_post_thumbnail_url( get_the_ID() ); ?>
                        <!-- <a class="standard-featured-link" href="<?php // esc_url( get_permalink() ); ?>"> -->
                        <!-- // Double Background Product / Shadoow -> View Archive scss
                        <div class="wl-anime-container">
                            <div id="wl-product-scene">
                                <div class="wl-product"></div>
                            </div>
                        </div> -->
                            <div class="standard-featured background-image">
                                <picture>
                                    <source
                                        srcset="<?php echo esc_url( $featured_image ); ?> 333w, <?php echo esc_url( $featured_image ); ?> 250w, <?php echo esc_url( $featured_image ); ?> 120w"
                                        sizes="(max-width: 333px) 100vw, 333px" type="image/webp"><img
                                        src="<?php echo esc_url( $featured_image ); ?>"
                                        class="img-fluid d-block mx-auto wp-post-image" alt="" loading="lazy"
                                        srcset="<?php echo esc_url( $featured_image ); ?> 333w, <?php echo esc_url( $featured_image ); ?> 250w, <?php echo esc_url( $featured_image ); ?> 120w"
                                        sizes="(max-width: 333px) 100vw, 333px" data-eio="p">
                                </picture>
                            </div>
                        <!-- </a> -->
                    <?php endif; ?>
                </div>

                <?php if (!$availableOnline) : ?>
                    <div class="extra-label-container p-2">
                        <span class="most-label text-uppercase p-2"><?php echo __( 'Coming Soon', 'wlsfcpt' ); ?></span>
                    </div>
                <?php else : ?>
                    <div class="aux-cta-container">
                        <div class="aux-cta-arrow">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    
                <?php endif; ?>
            </div> <!-- .wlsfcpt-image-section -->
            <?php if ($availableOnline) : ?></a><?php endif; ?>

            <div class="wlsfcpt-meta-info-section">
                <div class="single-information col-4 text-center p-2">
                    <div class="product-attribute-label text-uppercase text-semibold">
                        <div class="family-label-container">
                            <img src="<?php echo esc_url( WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_taste.png'); ?>" alt="" srcset="">
                        </div>
                    </div>
                    <div class="product-attribute-value">
                        <?php $taste = get_post_meta( get_the_ID(), 'wlsfcpt_taste', true ) ?: array();
                        $string = '';
                        foreach ($taste as $value) {
                            $string .= getTerpenicProfile( $value ) . ', ';
                        }
                        echo esc_html( substr( $string, 0, -2 ) ); ?>                                
                        <!-- Nocciolato, Terroso, Fruttato, Agrumato, Cheese, Esotico -->
                    </div>
                </div>

                <div class="single-information col-4 text-center p-2">
                    <div class="product-attribute-label text-uppercase text-semibold">
                        <div class="family-label-container">
                            <img src="<?php echo esc_url( WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayFarm_thc_level.png'); ?>" alt="" srcset="">
                        </div>
                    </div>
                    <div class="product-attribute-value">
                        <?php $thc_level = get_post_meta( get_the_ID(), 'wlsfcpt_thclevel', true ) ?: ''; ?>
                        <p class="text-content">
                            <?php echo esc_html( $thc_level ); ?>
                        </p>
                        <!-- Secondo legge vigente -->
                    </div>
                </div>

                <?php
                if ($termProductSlugCat == 'flowers') {
                    // echo 'Is Flowers';
                    $image_url = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_family.png';
                    $value_dynamic = get_post_meta( get_the_ID(), 'wlsfcpt_family', true ) ?: '';
                } else {
                    $image_url = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_cbd.png';
                    $value_dynamic = get_post_meta( get_the_ID(), 'wlsfcpt_cbdlevel', true ) ?: '';
                }
                // echo $value_dynamic . ', ' . $termProduct->slug;
                ?>
                <div class="single-information col-4 text-center p-2">
                    <div class="product-attribute-label text-uppercase text-semibold">
                        <div class="family-label-container">
                            <img src="<?php echo esc_url( $image_url ) ?>" alt="" srcset="">
                        </div>
                    </div>
                    <div class="product-attribute-value">
                        <?php $family = get_post_meta( get_the_ID(), 'wlsfcpt_family', true ) ?: ''; ?>
                        <p class="text-content">
                            <?php echo esc_html( $value_dynamic ); ?>
                        </p>
                        <p class="text-content">
                            <br>
                        </p>
                    </div>
                </div>
                <?php /*if ($termProduct->slug == 'flowers') : ?>
                    
                <?php else : ?>
                    <div class="single-information col-4 text-center p-2">
                        <div class="product-attribute-label text-uppercase text-semibold">
                            <div class="family-label-container">
                                <img src="<?php echo esc_url( ) ?>" alt="" srcset="">
                            </div>
                        </div>
                        <div class="product-attribute-value">
                            <?php $family = get_post_meta( get_the_ID(), 'wlsfcpt_family', true ) ?: ''; ?>
                            <?php echo esc_html( $family ); ?>
                        </div>
                    </div>
                <?php endif; */?>
                
            </div> <!-- .wlsfcpt-meta-info-section" -->

        </div> <!-- wlsf-single-product-container -->

    </div>
</div> <!-- .wlsfcpt-single-card-horizontal -->
