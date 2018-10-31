<?php get_header(); ?>

	<?php // get_template_part( 'breadcrumbs' ); ?>

	<!--Hero-->
	<div 
		class="single-hero" 
		style="	background-color: #eee; 
				background-image: url('<?php echo get_template_directory_uri(); ?>/assets/blog_hero.jpg'); ?>';
				background-size: cover;">
	</div>

	<!--Title  -->
	<div class="page-title">
		<div class="container">
			<h1><span>NEWS</span></h1>
		</div>
	</div>

	<?php wp_reset_query(); ?>

	<div class="blog-container">  
		<!--Page/Post Content-->
		<?php 
			$args = array (
				// 'post_type'              => 'portfolio',
				'nopaging'               => false,
				'posts_per_page'         => '3',
				'order'                  => 'DESC'
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$category = get_the_category();
					$firstCategory = $category[0]->cat_name;
				?>
				<div class="post-row">
					<div class="container">
						<div class="row">
							<div class="col-sm-4 col-xs-12 post-thumbnail">
								<div class="holder">
									<img src="<?php  echo the_post_thumbnail_url('full'); ?>"/>
								</div>
							</div>
							<div class="col-sm-8 col-xs-12 post-information">
								<!--
									Not usable until next mission |B
									<?php 
										$categories = get_categories();
											foreach ($categories as $cat) {
											$category_link = get_category_link($cat->cat_ID);
										}
									?>
									<a href="<?php echo esc_url( $category_link ); ?>" title="Category Name"><h6> <?php echo $firstCategory ?> </h6></a>
									<h2> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </h2>
								-->
								<h5><?php echo get_the_date( 'd-m-Y' ); ?></h5>
								<h2>
									<a href="<?php the_permalink(); ?>"> 
									<?php the_title(); ?></a></h2>
								
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
					<?php
				}
			} else {
				// display when no posts found
			}
		?>
	</div>

<?php get_footer(); ?>
