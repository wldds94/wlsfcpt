<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 
// wp_head(); ?>


<div id="wlsfcpt-primary" class="content-area container-wrap wlsfcpt-primary-archive wl-set-JS">
    <main id="main" class="site-main" role="main">

        <?php $terms = getAllSfProductCategories(); // print_r($terms); ?>

        <div class="main-nav-archive-container">
            <div class="mobile-main-nav-archive-container">
                <a href="#" class="menu example9"><span></span></a>            
            </div>

            <ul class="nav nav-tabs">
                <li class="no-filter active" data-slug="">
                    <a class="wlank-nav-link" href="#" data-slug=""><span class="navbar-link-title" data-slug=""><?php echo __( 'View All', 'wlsfcpt' ); ?></span></a>
                </li>
                <?php foreach ($terms as $term) :  // print_r($term); 
                    $emptyClassCss = $term->count > 0 ? '' : ' disabled'; ?>
                    <li class="<?php echo esc_attr( getTermsSlug($term->slug) ); ?><?php echo esc_attr( $emptyClassCss ); ?>" data-slug="<?php echo esc_attr( $term->slug ); ?>" >
                        <a class="wlank-nav-link" href="#<?php echo esc_attr( getTermsSlug($term->slug) ); ?>" data-slug="<?php echo esc_attr( getTermsSlug($term->slug) ); ?>">
                            <span class="navbar-link-title" data-slug="<?php echo esc_attr( getTermsSlug($term->slug) ); ?>"><?php echo esc_html( $term->name ); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div> <!-- .nav-archive-container -->

        <div class="wlsfcpt-container">

            <?php
            $args = array(
                'post_type' => 'sfproduct',
                'showposts' => -1,
                'post_status' => array(                 //(string / array) - use post status. Retrieves posts by Post Status, default value i'publish'.         
                    'publish'
                ),
                'order' => 'ASC',
                'orderby' => 'post_title'

            );
            $query = new WP_Query( $args );
			if ( $query->have_posts() ) : ?>

					<!-- <header>
						<?php
							// the_archive_title( '<h1 class="page-title">', '</h1>' );
							// the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header> -->

                <div class="row wlsf-archive-row">
                    <?php
                    /* Start the Loop */
                    while ( $query->have_posts() ) :

                        $query->the_post();

                        require WLSFCPT_PLUGIN_PUBLIC_TMPL_PATH . 'template-parts/content-archive.php';
                        
                    // Fine del Loop
                    endwhile;
                    // Reimposto la Query
                    wp_reset_postdata();
                    ?>                        

                 </div>
            <?php
			else :

				require WLSFCPT_PLUGIN_PUBLIC_TMPL_PATH . 'template-parts/content-none.php';

			endif;
			?>

        </div> <!-- .container -->
    </main><!-- #main -->
</div><!-- #primary -->

<!-- <div class="test" style="padding: 30px">
    <a href="#" class="wlsfcpt-button">Richiedi disponibilità <i class="fa-solid fa-arrow-right"></i></a>
</div>
 -->

<?php get_footer(); ?>