<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 
// wp_head(); ?>
<?php // dd($post); ?>
<?php // echo $post->ID;
$postProductID = $post->ID;
echo $postProductID . '<br>';
$termProduct = getAllTermsBySfProduct( $post->ID ); 
// echo '<pre>';
// print_r($post);
print_r($termProduct); echo '<br>';
$termProductSlug = getTermsSlug($termProduct->slug);
echo $termProductSlug . '<br>';

$meta = get_post_meta($post->ID);
// print_r($meta);

/** --- HERO --- */
// Slider Images Hero
// print_r($meta['wlsfcpt_hero_slider']); 
$images_slider_hero_meta = get_post_meta($post->ID, 'wlsfcpt_hero_slider', 1); // isset($meta['wlsfcpt_hero_slider'][0]) ? $meta['wlsfcpt_hero_slider'][0] : array();
$images_slider_hero = false != $images_slider_hero_meta && '' != $images_slider_hero_meta ? $images_slider_hero_meta : array();
if( has_post_thumbnail() ) {
	$featured_image = get_the_post_thumbnail_url( $post->ID );
	array_unshift($images_slider_hero, $featured_image);
}
// print_r($images_slider_hero);

/** Caption / Cotntent */
$content = $post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);

/** CTA URL */
$cta_url = get_post_meta( $post->ID, 'wlsfcpt_url', true ) ?: '';
/** Image sative hero content */
if ($termProductSlug == 'flowers') { // echo 'Is Flowers';
	$image_url = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_family_black.png';
	$value_dynamic = get_post_meta( $post->ID, 'wlsfcpt_family', true ) ?: '';
} else {
	$image_url = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_cbd_black.png';
	$value_dynamic = get_post_meta( $post->ID, 'wlsfcpt_cbdlevel', true ) ?: '';
}
/** THC hero label values */
$thc_level = get_post_meta( $post->ID, 'wlsfcpt_thclevel', true ) ?: '';
$thc_level_image = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_thc_level_black.png';
/** Terpenic PRofile hero COntent */
$taste_image = WLSFCPT_PLUGIN_URL . 'dist/images/icons/sayfarm_taste_black.png';
$taste = get_post_meta( $post->ID, 'wlsfcpt_taste', true ) ?: array();

/** --- INTRO ITERATOR --- */
$intros = get_post_meta( $post->ID, 'wlsfcpt_repeat_intro', true ) ?: array();
// print_r($intros);
$first_intro = isset($intros[0]) ? $intros[0] : array();
unset($intros[0]);

/** Masonry */
$masonry_meta = get_post_meta( $post->ID, 'wlsfcpt_masonry', true ) ?: array();
// print_r($intros);
// print_r($masonry_meta);
$masonry_letter = array();
foreach ($masonry_meta as $key => $value) {
	array_push($masonry_letter, $value);
}
// echo '</pre>';
?>
<div id="wlsfcpt-primary" class="content-area container-wrap wlsfcpt-primary-archive wl-set-JS">
    <main id="main" class="site-main" role="main">
		<div id="wlsfcpt_page">


			<div class="section wl-product" data-slug="<?php echo esc_attr( $termProductSlug ); ?>">

				<div class="row product-main-content">

					<div class="col-6 wl-slider-product">
						<div id="wl-slider-wrapper" data-slider="wlsfcpt-product">


							<div id="image-slider">
								
								<ul>
									<?php
									$counter_hero = 0; 
									foreach ($images_slider_hero as $key => $value) : ?>
										<li class="<?php echo $counter_hero > 0 ? '' : 'active-img'; ?>">
											<picture>
												<img
													src="<?php echo esc_url( $value ); ?>"
													class="img-fluid d-block mx-auto wp-post-image" alt="" loading="lazy"
													srcset="<?php echo esc_url( $value ); ?> 333w, <?php echo esc_url( $value ); ?> 250w, <?php echo esc_url( $value ); ?> 120w"
													sizes="(max-width: 333px) 100vw, 333px" data-eio="p" />
											</picture>
										</li>
									<?php $counter_hero++;
									endforeach; ?>
								</ul>
						
							</div> <!-- #image-slider -->
						
						
						</div> <!-- #wl-slider-wrapper -->
					</div> <!-- .wl-slider-product -->

					<div class="col-6 wl-product-content">

						<?php the_title( '<h2 class="entry-title text-center">', '</h2>' ); ?><!-- <h2 class="entry-title text-center">Sweet Berry</h2> -->

						<div class="mobile-hidden wrapper-desktop">
							<div class="wl-product-subtitle text-center">
								<?php echo $content; ?>
							</div>

			
							<div class="meta-container mobile-hidden">
								<div class="single-meta">
									<span class="wl-icon">
										<img src="<?php echo esc_url( $image_url ) ?>" alt="" srcset="">
									</span>
									<span class="wl-text"><?php echo esc_html( $value_dynamic ); ?></span>
								</div>
			
								<div class="single-meta">
									<span class="wl-icon">
										<img src="<?php echo esc_url( $thc_level_image ) ?>" alt="" srcset="">
									</span>
									<span class="wl-text"><?php echo esc_html( $thc_level ); ?></span>
								</div>

								<div class="single-meta">
									<span class="wl-icon">
										<img src="<?php echo esc_url( $taste_image ) ?>" alt="" srcset="">
									</span>
									<span class="wl-text">
									<?php 
									$string = '';
									foreach ($taste as $value) {
										$string .= getTerpenicProfile( $value ) . ', ';
									}
									echo esc_html( substr( $string, 0, -2 ) ); ?>
									</span>
								</div>
							</div>
						</div>
						
					</div> <!-- .wl-product-content -->
				</div> <!-- .product-main-content -->
				
				<div class="row wl-product-content">
					<!-- <div class="col col-sm-3 col-md-4"></div> -->
					<div class="mobile-meta-container">
						<div class="meta-container d-none">
							
							<div class="single-meta col col-sm-12 col-md-6 col-xl-4">
								<span class="wl-icon">
									<img src="<?php echo esc_url( $image_url ) ?>" alt="" srcset="">
								</span>
								<span class="wl-text"><?php echo esc_html( $value_dynamic ); ?></span>
							</div>
				
							<div class="single-meta col col-sm-12 col-md-6 col-xl-4">
								<span class="wl-icon">
									<img src="<?php echo esc_url( $thc_level_image ) ?>" alt="" srcset="">
								</span>
								<span class="wl-text"><?php echo esc_html( $thc_level ); ?></span>
							</div>
				
							<div class="single-meta col col-sm-12 col-md-6 col-xl-4">
								<span class="wl-icon">
										<img src="<?php echo esc_url( $taste_image ) ?>" alt="" srcset="">
									</span>
									<span class="wl-text">
									<?php 
									$string = '';
									foreach ($taste as $value) {
										$string .= getTerpenicProfile( $value ) . ', ';
									}
									echo esc_html( substr( $string, 0, -2 ) ); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<?php if ($cta_url != '') : ?>
					<!-- <div class="sayfarm-btn-link">
						<a href="#contacts-table" title="Richiedi preventivo gratuito" class="sayfarm-cta-link wlsf-black text-uppercase d-inline-block">
							Richiedi disponibilità <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div> -->
					<div class="cta-product-container">
						<a href="<?php echo esc_url( $cta_url ); ?>"><!-- <span class="mobile-hidden"> --><?php echo __( 'Contattaci subito', '' ); ?><!-- </span> --><i class="fa-solid fa-phone"></i></a>
					</div>
				<?php endif; ?>
				
			</div> <!-- .section.wl-product -->

			<div id="thumbnail-wrapper">

				<div id="thumbnail" data-slider="wlsfcpt-product">
					<ul>
					<?php
						$counter_hero = 0; 
						foreach ($images_slider_hero as $key => $value) : ?>
							<li class="<?php echo $counter_hero > 0 ? '' : 'active'; ?>">
								<img src="<?php echo esc_url( $value ); ?>" alt="" />
							</li>
						<?php $counter_hero++;
						endforeach; ?>
					</ul>
				</div> <!-- #thumbnail -->

			</div><!-- #thumbnail-wrapper -->
			<?php if (count($first_intro) > 0) : ?>
			<div class="sfproduct-intro-description text-center">
				<h4 class="title"><?php echo esc_html( isset($first_intro['title']) ? $first_intro['title'] : '' ); ?></h4>
				<p class="desc-content">
					<?php echo isset($first_intro['description']) ? $first_intro['description'] : ''; ?>
				</p>
			</div> <!-- .sfproduct-intro-description -->
			<?php endif; ?>

		</div><!-- #wlsfcpt_page -->

		<?php if (count($masonry_letter) > 0) : ?>
		<div class="wlsfproduct-grid-gallery">
			<div class="wlsfprduct-masonry-grid-container">
				<?php $counter_letter = 0; ?>
				<?php foreach ( range('a', 'z') as $letter) : ?>
					<?php if (isset($masonry_letter[$counter_letter])) : ?>
						<div class="box<?php echo esc_attr( ' ' . $letter ); ?>">
							<img src="<?php echo esc_url( $masonry_letter[$counter_letter] ); ?>" alt="">
						</div>
					<?php endif; ?>
					<?php $counter_letter++; ?>
				<?php endforeach; ?>
				<!-- <div class="box a"><img src="https://images.unsplash.com/photo-1559962200-ba8b28568ba8?ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=358&amp;q=80" alt=""></div>
				<div class="box b"><img src="https://images.unsplash.com/photo-1550856015-de3a3956c67d?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=750&amp;q=80" alt=""></div>
				<div class="box c"><img src="https://images.unsplash.com/photo-1559888828-551abffa1019?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=750&amp;q=80" alt=""></div>
				<div class="box d"><img src="https://images.unsplash.com/photo-1559925811-cf920c962023?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1534&amp;q=80" alt=""></div>
				<div class="box e"><img src="https://images.unsplash.com/photo-1559912553-fc5637d88768?ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=435&amp;q=80" alt=""></div>
				<div class="box f"><img src="https://images.unsplash.com/photo-1559626627-cb31b201e27f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=497&amp;q=80" alt=""></div> -->
			</div>
		</div> <!-- .wlsfproduct-grid-gallery -->
		<?php endif; ?>

		<?php foreach ($intros as $key => $value) : ?>
			<div class="sfproduct-after-description text-center">
				<h4 class="title"><?php echo esc_html( isset($value['title']) ? $value['title'] : '' ); ?></h4>
				<p class="desc-content">
					<?php echo isset($value['description']) ? $value['description'] : ''; ?>
				</p>
			</div> <!-- .sfproduct-after-description -->
		<?php endforeach; ?>

		<?php
		/** Best Deals Carousel Product */
		$args = array(
			'post_type' => 'sfproduct',
			'showposts' => 10,
			'post_status' => array(                 //(string / array) - use post status. Retrieves posts by Post Status, default value i'publish'.         
				'publish'
			),
			'order' => 'ASC',
			'orderby' => 'post_title',
			'tax_query' => array(
				array(
					'taxonomy' => 'wlsfcpt_booking',
					'field'    => 'slug',
					'terms'    => 'best-deals',
				),
			)
		);
		$query = new WP_Query( $args ); 
		?>
		<?php if ( $query->have_posts() ) : ?>

		<!-- Slider main container -->
		<div class="swiper-container">
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">

				<?php // Start the loop 
				while ( $query->have_posts() ) : 
					$query->the_post(); 
					if ($postProductID == get_the_ID())
						continue;
					$url_image_best_carousel = get_post_meta( $post->ID, 'wlsfcpt_bestdeal_image', true ) ?: ''; ?>
					<div class="swiper-slide" style="font-size:15px; background-image: url('<?php echo esc_url( $url_image_best_carousel != '' ? $url_image_best_carousel : get_the_post_thumbnail_url( get_the_ID() ) ); ?>');">
						<h4><a href="<?php echo get_post_permalink( $post->ID ); ?>"><?php echo esc_html( $post->post_title ); ?></a></h4>
					</div>
				<?php // Fine del Loop // $counter_post_product++;
				endwhile;
				wp_reset_postdata();
				?>
			</div> <!-- .swiper-wrapper -->
			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>

			<!-- If we need scrollbar -->
			<!-- <div class="swiper-scrollbar"></div> -->
		</div>

		<?php endif; ?>



	</main><!-- #main -->
</div>

<?php get_footer(); ?>
