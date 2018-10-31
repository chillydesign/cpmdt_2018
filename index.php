<?php get_header(); ?>


	<div class="search-title">
		<div class="container">
			<!-- <h1> Affichage de <?php echo $GLOBALS['wp_query']->post_count; ?> résultat(s) pour <?php the_search_query(); ?></h1> -->
			<h1> Résultat de la recherche pour "<?php the_search_query(); ?>"</h1>
		</div>
	</div>
	
	<div class="container search-query">
		<div class="row">

			<?php add_filter( 'the_title', 'max_title_length'); ?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php  
					$args = array(
						'post_parent' => get_the_ID(),
						'post_type'   => 'any', 
						'numberposts' => -1,
						'post_status' => 'any' 
					);
					$hasChildren = get_children($args);

					if( count($hasChildren) > 1){
					} else{ ?>
						<div class="search-item col-sm-12 col-xs-12">
                            <?php if( has_post_thumbnail() ){ ?>
								<div class="image-holder ngat">
									<img src="<?php  echo the_post_thumbnail_url('full'); ?>"/>
                        </div> <?php } ?>
                            <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
						</div>
						<?php 
					}
				?>

			<?php endwhile; else: ?>

				<div class="container not-found">
					<div class="col-sm-4 col-xs-12 no-margin no-padding">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/search-left.jpg" alt="">
					</div>
					<div class="col-sm-8 col-xs-12 no-margin no-padding">
						<h1>
							<p>AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...</p>
						</h1>
						
						<img src="<?php echo get_template_directory_uri(); ?>/assets/search-leftdown.jpg" alt="">
					</div>
				</div>

			<?php endif; ?>
		</div>
	</div>

<?php get_footer(); ?>


