
<div class="wlsfcpt-single-card wlsfcpt-single-card-horizontal item is-visible col-lg-4 col-md-6 col-sm-12" data-slug="<?php echo esc_attr( $termProduct->slug ); ?>">

<div class="wlsf-single-product-container row">

    <div class="wlsfcpt-image-section wlsfcpt-<?php echo esc_attr( $termProduct->slug ); ?>">
        <div class="product-name-container">
            <?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h3 class="entry-title">', '</h3></a>' ); ?>
        </div>

        <div class="wlsf-product-image-container p-2">
            <?php if( has_post_thumbnail() ) : ?>
                <?php $featured_image = get_the_post_thumbnail_url( get_the_ID() ); ?>
                <a class="standard-featured-link" href="<?php esc_url( get_permalink() ); ?>">
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
                </a>
            <?php endif; ?>
        </div>

        <?php $availableOnline = get_post_meta( get_the_ID(), 'wlsfcpt_islive', true ) ?: false; ?>
        <?php if (!$availableOnline) : ?>
            <div class="extra-label-container p-2">
                <span class="most-label text-uppercase p-2">PRESTO ONLINE</span>
            </div>
        <?php endif; ?>
    </div> <!-- .wlsfcpt-image-section -->

    <div class="wlsfcpt-meta-info-section">
        <div class="single-information col-4 text-center p-2">
            <div class="product-attribute-label text-uppercase text-semibold">
                <div class="family-label-container">
                    <img src="<?php echo esc_url( WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_taste.png'); ?>" alt="" srcset="">
                </div>
            </div>
            <div class="product-attribute-value">
                <?php $taste = get_post_meta( get_the_ID(), 'wlsfcpt_taste', true ) ?: '';
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
                    <img src="<?php echo esc_url( WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_cbd.png'); ?>" alt="" srcset="">
                </div>
            </div>
            <div class="product-attribute-value">
                <?php $thc_level = get_post_meta( get_the_ID(), 'wlsfcpt_thclevel', true ) ?: ''; ?>
                <?php echo esc_html( $thc_level ); ?>
                <!-- Secondo legge vigente -->
            </div>
        </div>

        <div class="single-information col-4 text-center p-2">
            <div class="product-attribute-label text-uppercase text-semibold">
                <div class="family-label-container">
                    <img src="<?php echo esc_url( WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_family.png'); ?>" alt="" srcset="">
                </div>
            </div>
            <div class="product-attribute-value">
                <?php $family = get_post_meta( get_the_ID(), 'wlsfcpt_family', true ) ?: ''; ?>
                <?php echo esc_html( $family ); ?>
            </div>
        </div>
    </div> <!-- .wlsfcpt-meta-info-section" -->

</div> <!-- wlsf-single-product-container -->

</div> <!-- .wlsfcpt-single-card-horizontal -->