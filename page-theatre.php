<?php
    /* Template Name: Theatre page template */
    get_header(); ?>

	<!-- Search bar -->
    <?php get_template_part('programme.search'); ?>
	<!-- Page title -->
    <div class="page-title background-theatre">
        <div class="container">
            <h2>THÉÂTRE</h2>
        </div>
	</div>

    <!-- Content container -->
	<div class="page-programs dance container">
        <div class="row">
		<?php
            $count = 0;
			$args = array (
                'post_type' => 'programme',
                'post_status' => 'any',
                'post_parent'    => '0',
                'posts_per_page'         => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'programmes',
                        'field' => 'slug',
                        'terms' => 'theatre'
                    ),
                )
            );

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
				?>

                <div class="col-sm-4 col-xs-12 ">
                    <div class="program">
                    <div class="program-inner"
                    style="
                        background-image: url('<? echo the_post_thumbnail_url('full'); ?>');
                        background-size: cover;
                        background-repeat: no-repeat;
                    ">

                        <h4> <?php the_title(); ?> </h4>
                        <!-- Children posts -->
                        <?php
                            $childrenArgs = array(
                                'post_parent' => get_the_id(),
                                'post_type' => 'programme',
                                'numberposts' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC'
                            );
                        ?>
                        <?php
                            $the_query = new WP_Query( $childrenArgs );
                            // The Loop
                            if ( $the_query->have_posts() ) :
                            ?>
                            <div class="program-children theatre">
                                <ul>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                            ?>
                                <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
                            <?php
                            endwhile;
                            ?>
                                </ul>
                            </div>
                            <?php else:?>
                                <a class="fullsizelink" href="<?php the_permalink(); ?>"></a>
                            <?php
                            endif;
                        ?>
                    </div>
                </div>
            </div>
            <?php $count++;  echo ($count % 3 == 0) ? '</div><!--END OF ROW --><div class="row">' : '';   ?>



				<?php } } else {
				// display when no posts found
			}
        ?>
        </div>
	</div>
<?php get_footer(); ?>
