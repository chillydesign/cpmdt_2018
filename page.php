<?php get_header(); ?>


<!-- Page title -->
<div class="page-title">
	<div class="container">
		<?php $parent_title = get_the_title($post->post_parent); ?>
		<?php
		if (is_page() && $post->post_parent) {
			echo "<h2>" . $parent_title . " / ";
			the_title() . "</h2>";
		} else {
			echo "<h2>" .  $parent_title . " </h2>";
		}
		?>

	</div>
</div>

<!--Content-->
<div class="container page-default">
	<div class="row">
		<!--Page/Post Content-->
		<div class="col-sm-12 col-xs-12 default-content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php the_content(); ?>

				<?php endwhile;
			else : ?>


				<p>AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...</p>

			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>