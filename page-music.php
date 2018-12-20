<?php /* Template Name: Music page template */ get_header(); ?>

<!-- Search bar -->
<?php get_template_part('programme.search'); ?>

    <!-- Page title -->
    <div class="page-title background-music">
        <div class="container">
            <h2>MUSIQUE</h2>
        </div>
    </div>


<script>
    var course_category = '20'; // id of music category
</script>
<?php get_template_part( 'coursesearch' ); ?>

<?php get_footer(); ?>
