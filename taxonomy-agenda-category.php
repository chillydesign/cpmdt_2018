<?php get_header(); ?>


    <div class="search-title">
        <div class="container">
            <h1 style="text-transform: uppercase;">agenda/<?php echo $GLOBALS['wp_query']->query['agenda-category'];  ?><?php the_search_query(); ?></h1>
        </div>
    </div>
    <div class="page-agenda">
        <div class="container">
            <a href="/archive-agenda/" class="archives-link pull-right button button-default">voir les archives</a>
        </div>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
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

            <?php 
                $date = date('Ymd');
                //echo get_custom_field('a_date'). " - ". $date;
                if(get_custom_field('a_date') >= $date){
            ?>
            <div class="agenda-item <?php echo $programSlug; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-xs-12 agenda-item-column">
                            <b><?php //echo get_custom_field('a_date'); ?></b>
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


                                        <a target="_blank" href="http://twitter.com/home/?status=<?php the_permalink() ?>"> 
                                            <i class="fa fa-twitter"></i> 
                                        </a>

                                </div>
                                <a class="button button-default pull-right" href="<?php the_permalink(); ?>"> lire la suite</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        <?php } ?>
        <?php endwhile; else: ?>

            <div class="search">
                <h1> <!--Aucun élément a été trouvé  --> Aucun résultat trouvé. </h1>
            </div>

        <?php endif; ?>
    </div>

<?php get_footer(); ?>