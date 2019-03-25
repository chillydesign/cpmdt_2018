<?php get_header(); ?>


<div class="search-title">
    <div class="container">

        <h1> Résultat de la recherche pour "<?php the_search_query(); ?>"</h1>
    </div>
</div>

<div class="container search-query">


    <div class="row">
        <div class="col-sm-9">

            <?php if ( have_posts() ) : ?>
                <div class="row">

                    <?php $count = 0; ?>
                    <?php  while ( have_posts() ) : the_post(); ?>

                        <?php


                        $post_id = get_the_ID();
                        ?>

                        <!-- <?php echo $post_id; ?>     -->
                        
                        <?php
                        // dont show pages with children
                        $args = array(
                            'post_parent' => get_the_ID(),
                            'post_type'   => 'any',
                            'numberposts' => -1,
                            'post_status' => 'any'
                        );
                        $hasChildren = get_children($args);
                        if( count($hasChildren) <= 0) : ?>
                        <div class=" col-sm-4">
                            <?php $image =  ( has_post_thumbnail()) ?  thumbnail_of_post_url( $post_id, 'small' ) : ''; ?>
                            <a  href="<?php the_permalink(); ?>" class="search-item" style="background-image:url(<?php echo $image; ?>)" >
                                <h4><?php the_title(); ?></h4>


                            </a>
                        </div>

                        <?php $count++; ?>
                        <?php echo ($count % 3 == 0) ? '</div><!--END OF ROW --><div class="row">' : '';  ?>
                    <?php endif; ?>


                    <?php endwhile; ?>
                </div> <!-- END ROW -->







            <?php else: ?>
                <h1>
                    AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...
                </h1>

            <?php endif; ?>
        </div><!--  END COL SM 9 -->
        <div class="col-sm-3">

            <? // SEPARATE EVENTS INTO OWN COL //
            $today = 	 new DateTime('today');
            $today_string = $today->format('Y-m-d');
             $args = array(
                'post_type' => 'agenda' ,
                'paged' => get_query_var( 'paged' ),
                'orderby' => 'a_date',
                'order'=> 'ASC',
                's' => get_query_var('s'),
                'meta_query' =>	array(

                    array(
                        'key'     => 'a_date',
                        'value'   =>  $today_string,
                        'compare' => '>=',
                        'type'    =>  'date'
                    ),

                )
            );
            $events = new WP_Query( $args); ?>
            <?php if ( $events->have_posts() ) : ?>

                <?php	while ( $events->have_posts())  : ?>
                <?php $events->the_post(); ?>
                <a href="<?php echo get_the_permalink(); ?>" class="small-search-item search-item">
                    <h4><?php the_title(); ?></h4>

                        <?php $a_date = get_field('a_date');  ?>
                        <?php if ($a_date): ?>
                            <?php $nice_date = date( 'd \<\s\p\a\n\> M \<\/\s\p\a\n\>'  ,strtotime($a_date)); ?>
                            <span class="date_container">
                                <?php echo $nice_date; ?>
                            </span>
                        <?php endif; ?>

                </a>

            <?php endwhile;  ?>
            <?php endif; ?>
            <?php wp_reset_query() ?>
        </div><!--  END COL SM 3 -->
    </div>


                    <!-- pagination -->
                    <div class="pagination">
                        <?php html5wp_pagination(); ?>
                    </div>
                    <!-- /pagination -->

</div>

<?php get_footer(); ?>
