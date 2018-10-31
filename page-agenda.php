<?php
    /* Template Name: Agenda Page */ 
    get_header(); ?>
    <div class="page-title">
        <div class="container">
            <h2> <?php the_title(); ?></h2>
        </div>
    </div>

	<!-- News section -->
	<div class="page-agenda">

		<div class="container">
			<a href="/archive-agenda/" class="archives-link pull-right button button-default">voir les archives</a>
		</div>

		<?php 
			// $args = array (
			// 	'post_type' => 'agenda',
			// 	'posts_per_page' => -1
			// );
			$args = array (
				'meta_query'     => array(
			        array(
			            'key' => 'archive_date',
			            'value' => date('Ymd'),
			            'compare' => '>='
			        )
			    ),
				'post_type' => 'agenda',
				'posts_per_page' => -1,
				'meta_key' => 'a_date', //setting the meta_key which will be used to order
        		'orderby' => 'meta_value', //if the meta_key (population) is numeric use meta_value_num instead
        		'order' => 'ASC', //setting order direction
			    
			);
			$query = new WP_Query( $args );
//echo "Last SQL-Query: {$query->request}";
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
								<?php  $dd = date('Y-m-d', strtotime(get_custom_field('a_date'))); ?>
								<b style="text-transform: capitalize;"> <?php echo utf8_encode(strftime("%A %d %B %Y", strtotime( $dd ) )); ?> </b>
							</div>
							<div class="col-sm-1 col-xs-12 agenda-item-column">
								<?php echo get_custom_field('a_time'); ?> 
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
    </div>

<?php get_footer(); ?>