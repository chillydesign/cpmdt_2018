<?php get_header(); ?>

	<?php // get_template_part( 'breadcrumbs' ); ?>

	<!--Title  -->
	<div class="page-title">
		<div class="container">
			<h1><span><?php the_title(); ?></span></h1>
		</div>
	</div>
	
	<div class="blog-container">  
		<!--Post Content-->
		<div class="single-post">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<?php the_content(); ?>
						</div>
					</div>
				</div>

			<?php endwhile; else: ?>

				<h1>Aucun article trouvé</h1>

			<?php endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
