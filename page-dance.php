<?php /* Template Name: Dance page template */ get_header(); ?>

	<!-- Search bar -->
    <?php get_template_part('programme.search'); ?>
    <!-- Page Title -->
    <div class="page-title background-dance">
        <div class="container">
            <h2>DANSE</h2>
        </div>
	</div>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="intro"><div class="container"><?php the_content(); ?></div></div>
  <?php endwhile; endif; ?>
  
    <script>
        var course_category = '19'; // id of danse category
    </script>
    <?php get_template_part( 'coursesearch' ); ?>

<?php get_footer(); ?>
