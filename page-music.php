<?php
/* Template Name: Music page template */
get_header(); ?>



<!-- Search bar -->
<?php get_template_part('programme.search'); ?>

<!-- Page title -->
<div class="page-title background-music">
  <div class="container">
    <h2>MUSIQUE</h2>
  </div>
</div>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <div class="intro"><div class="container"><?php the_content(); ?></div></div>
<?php endwhile; endif; ?>


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
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'meta_query' => array(
        'relation' => 'OR',
        array(
          'key' => 'hide_in_search',
          'value' => 0,
          'compare' => '=',
          'type' => 'NUMERIC'
        ),
        array(
          'key' => 'hide_in_search',
          'value' => 0,
          'compare' => 'NOT EXISTS'
        )
      ),
      'tax_query' => array(
        array(
          'taxonomy' => 'programmes',
          'field' => 'slug',
          'terms' => 'music'
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
            <div class="program-inner music"
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
              'posts_per_page' => -1,
              'order' => 'ASC',
              'orderby' => 'menu_order'

            );
            ?>
            <?php
            $the_query = new WP_Query( $childrenArgs );
            // The Loop
            $menu = [];
            $menu2 = [];
            if ( $the_query->have_posts() ) :
              while($the_query->have_posts() ) : $the_query->the_post();
              if(ctype_alpha(get_the_title()[0])){
                $menu[] = [get_the_permalink() => get_the_title()];
              }else{
                $menu2[] = [get_the_permalink() => get_the_title()];
              }
            endwhile;
            ?>
            <!-- <span class="before-music"></span> -->
            <div class="program-children ">
              <ul>
                <!-- <?php //var_dump($menu2); ?> -->
                <?php
                foreach ($menu as $data) {
                  foreach ($data as $key => $value) {
                    echo '<li><a href='.$key.'>'.$value.'</a></li>';
                  }

                }
                foreach ($menu2 as $data2) {
                  foreach ($data2 as $key => $value) {
                    echo '<li><a href='.$key.'>'.$value.'</a></li>';
                  }

                }
                ?>

              </ul>
            </div>
          <?php else:?>
            <a class="fullsizelink" href="<?php the_permalink(); ?>"></a>
            <?php
          endif;
          ?>
          <div class="program_overlay"></div>
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
