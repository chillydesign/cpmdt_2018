<?php /* Template Name: Theatre page template */ get_header(); ?>



	<!-- Search bar -->
    <?php get_template_part('programme.search'); ?>
	<!-- Page title -->
    <div class="page-title background-theatre">
        <div class="container">
            <h2>THÉÂTRE</h2>
        </div>
	</div>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="intro"><div class="container"><?php the_content(); ?></div></div>
  <?php endwhile; endif; ?>
  
    <script>
        var course_category = '21'; // id of theatre category
    </script>
<?php get_template_part( 'coursesearch' ); ?>

<?php get_footer(); ?>
