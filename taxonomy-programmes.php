<?php get_header(); ?>

	<!-- Page title -->
    <div class="page-title">
        <div class="container">
            <h2> <?php //the_title(); ?> &nbsp; </h2>
        </div>
	</div>

    <!-- Content container -->
	<div class="page-programmes container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
            <?php // Get terms for "Program" Taxonomy
            $programs = get_the_terms( $post->ID , 'programmes' );
            // Loop over each item since it's an array
            if ( $programs != null ){
            foreach( $programs as $program ) {
                // Save the value to an variable, and continue life
                $programName = $program->name;
                $programSlug = $program->slug;

                // Get rid of the other data stored in the object, since it's not needed
                unset($program);
            } } ?>		


            <div class="<?php echo $programSlug; ?>">
                <?php echo $programName ?>

                    <img src="<?php  echo the_post_thumbnail_url('full'); ?>"/>
                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                    <h5>
                        <?php 
                            $post_type = get_post_type( $post->ID );
                            echo $post_type;
                        ?> 
                    </h5>

            </div>	

        <?php endwhile; else: ?>

            <div class="search">
                <h1> <!--Aucun élément a été trouvé  --> Nothing found. </h1>
            </div>

        <?php endif; ?>
	</div>

<?php get_footer(); ?>