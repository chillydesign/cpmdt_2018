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
                    <li><a href="#">a</a></li>
                    <li><a href="#">b</a></li>
                    <li><a href="#">c</a></li>
                    <li><a href="#">d</a></li>
                    <li><a href="#">e</a></li>
                    <li><a href="#">f</a></li>
                    <li><a href="#">g</a></li>
                    <li><a href="#">h</a></li>
                    <li><a href="#">i</a></li>
                    <li><a href="#">j</a></li>
                    <li><a href="#">k</a></li>
                    <li><a href="#">l</a></li>
                    <li><a href="#">m</a></li>
                    <li><a href="#">n</a></li>
                    <li><a href="#">o</a></li>
                    <li><a href="#">p</a></li>
                    <li><a href="#">q</a></li>
                    <li><a href="#">r</a></li>
                    <li><a href="#">s</a></li>
                    <li><a href="#">t</a></li>
                    <li><a href="#">u</a></li>
                    <li><a href="#">v</a></li>
                    <li><a href="#">w</a></li>
                    <li><a href="#">x</a></li>
                    <li><a href="#">y</a></li>
                    <li><a href="#">z</a></li>
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

<script>


    function filterTeachers(){
        jQuery('.teachers-filter a').click(function(event){
            event.preventDefault();
            event.stopPropagation();
            // Store value
            $value = jQuery(this).html().trim();
            // Hide other rows
            jQuery('.visible').removeClass('visible');
            jQuery('.char-'+$value).addClass('visible');
        })
    }


    jQuery(document).ready(function(){
        filterTeachers();
        // First item on the teachers filter click
        jQuery('.teachers-filter ul li:first-of-type a').click();

        $class = jQuery('.frm_message');
        if(submittedEmail){
            // Palidhje
            $submittedRow = jQuery('.teachers-row:contains('+submittedEmail.trim()+')');
            jQuery('#frm_form_8_container').appendTo($submittedRow.find('.form-container'));
            var teacherChar = $submittedRow.attr('class').split('char-')[1].charAt(0);

            jQuery('.visible').removeClass('visible');
            jQuery('.char-'+teacherChar).addClass('visible ');
            $submittedRow.addClass('toggled submitted-row');
            $submittedRow.find('.contact-teacher').slideDown();
        }
    })
</script>