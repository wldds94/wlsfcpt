
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header text-center">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
		?>
				<div class="entry-meta">
					<?php
					Wlank\Core\Tags::posted_on();
					?>
				</div><!-- .entry-meta -->
		<?php
			endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if( has_post_thumbnail() ) : ?>
			<?php $featured_image = get_the_post_thumbnail_url( get_the_ID() ); ?>
			<a class="standard-featured-link" href="<?php esc_url( get_permalink() ); ?>">
				<div class="standard-featured background-image" style="background-image: url(<?php echo esc_url( $featured_image ); ?>);"></div>
			</a>
		<?php endif; ?>

		<?php if( is_archive() ) : ?>

			<div class="entry-excerpt">
				<?php the_excerpt(); ?>
			</div><!-- .entry-excerpt -->

			<div class="button-container text-center">
				<a href="<?php the_permalink(); ?>" class="btn btn-wlank"><?php _e( 'Read More' ); ?></a>
			</div>

		<?php else : ?>

			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. */
							__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'Wlank' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Wlank' ),
						'after'  => '</div>',
					)
				);
			?>

		<?php endif; ?>

	</div><!-- .entry-content -->


	<footer class="entry-footer entry-meta">
		<?php // Wlank\Core\Tags::entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
