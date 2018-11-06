<?php
    /* Template Name: Teachers Page */
    get_header(); ?>

    <div class="page-title">
        <div class="container">
            <h2> <?php the_title(); ?> </h2>
        </div>
    </div>

	<!-- News section -->
	<div class="page-teachers">
        <div class="container">

            <!-- Page filter -->
            <div class="teachers-filter text-uppercase">
                <ul>
    <?php $letters = array('a','b','c','d','e','f',
    'g','h','i', 'j','k','l','m','n','o','p','q',
    'r','s','t','u','v','w','x','y','z'); ?>
                <?php foreach ($letters as $letter) : ?>
                    <li><a href="#"><?php echo $letter; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>

            <?php wp_reset_query(); ?>

            <div class="teachers-container">
                <div class="col-sm-12 col-xs-12 text-uppercase teachers-header">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-sm-3"></div>
                        <!-- Custom field 1 -->
                        <div class="col-sm-2">
                            Téléphone 1
                        </div>
                        <!-- Custom field 2 -->
                        <div class="col-sm-2">
                            Téléphone 2
                        </div>
                        <!-- Custom field 3 -->
                        <div class="col-sm-3">
                            Courriel
                        </div>
                        <!-- Custom field 3 -->
                        <div class="col-sm-2">
                            WWW
                        </div>
                    </div>
                </div>
                <div id="form_initial_container" class="hidden">
                    <?php echo do_shortcode('[formidable id=8]'); ?>
                </div>
                <?php
                    $args = array (
                        'post_type' => 'teacher',
                        'posts_per_page' => -1,
                        'orderby'=> 'title',
                        'order' => 'ASC'
                    );

                    $query = new WP_Query( $args );

                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                        ?>

                        <div class="item teachers-row char-<?php echo trim(strtolower( substr(get_the_title(), 0, 1))); ?> col-sm-12 col-xs-12">
                            <div class="row row-inner">
                                <div class="col-sm-3 col-xs-12 font-bold">
                                    <?php the_title(); ?>
                                    <a class="teacher-toggle pull-right" href="#"></a>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <?php echo get_custom_field("phone_1") ?>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <?php echo get_custom_field("phone_2") ?>
                                </div>
                                <div class="col-sm-3 col-xs-12 teacher-email">
                                    <?php echo get_custom_field("email_1") ?>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <?php echo get_custom_field("website_1") ?>
                                </div>
                            </div>
                            <div class="row contact-teacher">
                                <div class="col-sm-12 col-xs-12">
                                    <h4> <?php echo get_custom_field("description_1"); ?></h4>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-container">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } } ?>
            </div>
        </div>
    </div>


    <?php
        if(isset($_POST['item_name'])){
            ?>
                <script>
                    var submittedEmail = "<?php echo $_POST['item_name'];?>";
                </script>
            <?php
        }
    ?>


<?php get_footer(); ?>
