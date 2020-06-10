	<?php get_header(); ?>

	<!-- Slider Container -->
	<div class="front-slider">
		<?php // echo do_shortcode('[rev_slider alias="homepage"]'); ?>
        <?php get_template_part('frontpageslider'); ?>

        <!-- Search bar -->
		<?php get_template_part('programme.search'); ?>


	</div>

	<?php get_template_part('introduction'); ?>
	<?php get_template_part('services'); ?>

	<!-- News section -->
	<div class="front-posts">
		<div class="container">

			<h2>ACTUALITÉS</h2>

			<div  style="margin-top: 60px">
			<?php
            $home_page_news = get_field('news');
				if ( $home_page_news) : ?>
                    <div class="row">
					<?php foreach ( $home_page_news as $news_item) :
                        $post = $news_item['post'];
                        $status = $post->post_status;
                        if ($status == 'publish') :
                        $excerpt = get_field('post_excerptcf', $post->ID);
						$category = get_the_category( $post->ID );
						$categoryName = $category[0]->cat_name;
						$categorySlug = $category[0]->slug;
                        $image = thumbnail_of_post_url( $post->ID, 'medium');
					?>
					<div class="col-md-4 col-sm-3">
						<div class=" item">

							<div class="item-thumbnail">
								<img src="<?php  echo $image; ?>"/>
							</div>
							<div class="item-date">
								<h5><?php echo get_the_date( '<b>d</b> F', $post->ID ); ?></h5>
							</div>
							<div class="item-information">

								<h6 class="color-<?php echo $categorySlug ?>" > <?php echo $categoryName ?> </h6>
								<h3> <?php echo $post->post_title; ?> </h3>
								<p><?php echo $excerpt; ?></p>

								<a class="button button-default" href="<?php echo get_permalink($post->ID); ?>"> en savoir plus</a>
							</div>
						</div>
						</div>
                    <?php endif;  # if published ?>
                    <?php endforeach; ?>
									</div> <!-- END OF news -->
				<?php  endif; ?>
			</div>


		</div>
	</div>


	<?php wp_reset_query() ?>

	<!-- News section -->
	<div class="page-agenda">
		<h2>AGENDA</h2>

		<ul class="agenda-categories text-center">
			<!-- Exclude "Archives" or whatever category on the 'exclude' -->
			<?php $wcatTerms = get_terms('agenda-category', array('hide_empty' => 0, 'parent' =>0, 'exclude' => '23'));
			foreach($wcatTerms as $wcatTerm) :
			?>
				<li>
					<a class="button button-default" href="<?php echo get_term_link( $wcatTerm->slug, $wcatTerm->taxonomy ); ?>"><?php echo $wcatTerm->name; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>


		<?php
			$args = array (
				'post_type' => 'agenda',
				'posts_per_page' => '3',
				'meta_query'     => array(
			        array(
			            'key' => 'archive_date',
			            'value' => date('Ymd'),
			            'compare' => '>'
			        ),
			    ),
			    'meta_key' => 'a_date', //setting the meta_key which will be used to order
        		'orderby' => 'meta_value', //if the meta_key (population) is numeric use meta_value_num instead
        		'order' => 'ASC' //setting order direction
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$address = get_address($post->ID);
				?>


				<?php // Get terms for "Program" Taxonomy
				$programs = get_the_terms( $post->ID , 'agenda-program' );
				// Loop over each item since it's an array
				if ( $programs != null ){
				foreach( $programs as $program ) {
					// Save the value to an variable, and continue life
					$programName = $program->name;
					$programSlug = $program->slug;

					// Get rid of the other data stored in the object, since it's not needed
					unset($program);
				} } ?>

				<?php // Get terms for "Type" Taxonomy
				$types = get_the_terms( $post->ID , 'agenda-type' );
				// Loop over each item since it's an array
				if ( $types != null ){
				foreach( $types as $type ) {
					// Save the value to an variable, and continue life
					$typesName = $type->name;
					// Get rid of the other data stored in the object, since it's not needed
					unset($type);
				} } ?>

				<div class="agenda-item <?php echo $programSlug; ?>">
					<div class="container">
						<div class="row">
							<div class="col-sm-2 col-xs-12 agenda-item-column">
								<!-- <b><?php //echo get_custom_field('a_date'); ?></b>  -->
								<!-- <b><?php //echo date('l d F Y', strtotime(get_custom_field('a_date'))); ?></b> -->
								<?php  $dd = date('Y-m-d', strtotime(get_custom_field('a_date'))); ?>
								<b style="text-transform: capitalize;"> <?php echo utf8_encode(strftime("%A %d %B %Y", strtotime( $dd ) )); ?> </b>
							</div>
							<div class="col-sm-1 col-xs-12 agenda-item-column">
								<?php echo get_custom_field('a_time') ?>
							</div>
							<div class="col-sm-2 col-xs-12 agenda-item-column">
								<?php echo $address['short_address']; ?>
							</div>
							<div class="col-sm-7 col-xs-12 agenda-information agenda-item-column">
								<h5><b> <?php echo $programName ?></b> //
								  		<?php echo $typesName ?></h5>

								<h4> <?php the_title(); ?> </h4>
								<?php the_excerpt(); ?>

								<div class="buttons">
									<div class="share-buttons pull-left hidden">
										<small>JE PARTAGE</small>
											<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink() ?>">
												<i class="fa fa-facebook"></i>
											</a>


											<!-- <a target="_blank" href="http://twitter.com/home/?status=<?php the_permalink() ?>">
												<i class="fa fa-twitter"></i>
											</a> -->

									</div>
									<a class="button button-default pull-right" href="<?php the_permalink(); ?>"> lire la suite</a>
								</div>
							</div>
						</div>
					</div>
				</div>



				<?php } } else {
				// display when no posts found
			}
		?>
		<div class="text-center discover-more">
			<a class="button button-default" href="<?php echo get_site_url(); ?>/agenda">découvrir tout l’agenda</a>
		</div>
	</div>

	<!-- Content -->
	<div class="container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; else: ?>

			<h2>No posts found!</h2>

		<?php endif; ?>
	</div>
<?php get_footer(); ?>
