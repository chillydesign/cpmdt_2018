<?php get_header(); ?>


<div class="search-title">
    <div class="container">

        <h1> Résultat de la recherche pour "<?php the_search_query(); ?>"</h1>
    </div>
</div>

<div class="container search-query">


    <?php if ( have_posts() ) : ?>
        <div class="row">
            <?php $count = 0; ?>
            <?php  while ( have_posts() ) : the_post(); ?>

                <?php

                $post_id = get_the_ID();
                // dont show pages with children
                $args = array(
                    'post_parent' => get_the_ID(),
                    'post_type'   => 'any',
                    'numberposts' => -1,
                    'post_status' => 'any'
                );
                $hasChildren = get_children($args);
                if( count($hasChildren) <= 0) : ?>
                    <div class=" col-sm-3">
                        <?php $image =  ( has_post_thumbnail()) ?  thumbnail_of_post_url( $post_id, 'small' ) : ''; ?>
                        <a  href="<?php the_permalink(); ?>" class="search-item" style="background-image:url(<?php echo $image; ?>)" >
                            <h4><?php the_title(); ?></h4>
                        </a>
                    </div>

                    <?php $count++; ?>
                    <?php endif; ?>


                    <?php echo ($count % 4 == 0) ? '</div><!--END OF ROW --><div class="row">' : '';  ?>
                <?php endwhile; ?>
                    </div> <!-- END ROW -->

                    <div class="pagination">
                        <span class="older_posts"><?php previous_posts_link( 'Older posts' ); ?></span>
                        <span class="newer_posts"><?php next_posts_link( 'Newer posts' ); ?></span>
                    </div>




        <?php else: ?>
            <h1>
                AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...
            </h1>

        <?php endif; ?>

    </div>

    <?php get_footer(); ?>
