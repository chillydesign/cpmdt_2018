	<?php get_header(); ?>
	
	<!-- Slider Container -->
	<div class="front-slider">
		<?php echo do_shortcode('[rev_slider alias="homepage"]'); ?>

		<!-- Search bar -->
		<?php get_template_part('programme.search'); ?> 
		
	</div>
	
	<!-- News section -->
	<div class="front-posts">
		<div class="container">

			<h1>ACTUALITÉS</h1>

			<div class="row" style="margin-top: 60px">
			<?php 
				$args = array (
					'nopaging'               => false,
					'posts_per_page'         => '4'
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					$i = 1;
					while ( $query->have_posts() ) {
						$query->the_post();

						$category = get_the_category();
						$categoryName = $category[0]->cat_name;
						$categorySlug = $category[0]->slug;
					?>

						<div class="col-sm-6 col-xs-12 item">
							<?php 
								$categories = get_categories();
									foreach ($categories as $cat) {
									$category_link = get_category_link($cat->cat_ID);
								}
							?>
							<div class="item-thumbnail">
								<img src="<?php  echo the_post_thumbnail_url('full'); ?>"/>
							</div>
							<div class="item-date">
								<h5><?php echo get_the_date( '<b>d</b> F' ); ?></h5>
							</div>
							<div class="item-information">
								<!-- <a href="<?php echo esc_url( $category_link ); ?>" title="Category Name"></a> -->
								<h6 class="color-<?php echo $categorySlug ?>" > <?php echo $categoryName ?> </h6>
								<h3> <?php the_title(); ?> </h3>
								<p><?php echo get_custom_field("post_excerptCF"); ?></p>

								<a class="button button-default" href="<?php the_permalink(); ?>"> en savoir plus</a>
							</div>
						</div>
						<?php
						if($i%2==0){
							echo '</div><!--/.row in loop--><div class="row" style="margin-top: 60px">';
						}
						$i++;
					}
				} else {
					// display when no posts found
				}
			?>
			</div>
		</div>
	</div>


	<?php wp_reset_query() ?>

	<!-- News section -->
	<div class="page-agenda">
		<h1>AGENDA</h1>

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
			<a class="button button-default" href="/agenda">découvrir tout l’agenda</a>
		</div>
	</div>

	<!-- Content -->
	<div class="container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>
			
		<?php endwhile; else: ?>

			<h1>No posts found!</h1>

		<?php endif; ?>
	</div>
<?php get_footer(); ?>
