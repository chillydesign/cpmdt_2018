<?php $tdu = get_template_directory_uri(); ?>

<footer class="col-xs-12 col-sm-12">

    <!--Logo Display  -->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-xs-12">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php endif; ?>
                <hr>
                <?php echo do_shortcode('[mc4wp_form id="494"]'); ?>
                <ul class="share-buttons">
                    <li><a target="_blank" href="https://www.facebook.com/conservatoirepopulaire.ch"><i class="fa fa-facebook"></i></a></li>
                    <li><a target="_blank" href="https://www.instagram.com/conservatoirepopulaire/"><i class="fa fa-instagram"></i></a></li>
                    <?php
                    // $insta = get_theme_mod( 'er-insta' );
                    // if($insta){
                    // 	$result = '<li><a href="'.$insta.'"><i class="fa fa-instagram"></i></a></li>';
                    // 	echo $result;
                    // }
                    ?>
                    <li><a target="_blank" href="https://www.youtube.com/channel/UCsz_j1Ve382sFk3Pmo97Vlw"><i class="fa fa-youtube"></i></a></li>
                </ul>
                <p>Le Conservatoire populaire de musique, danse et théâtre, école accréditée par le département de l'instruction publique, de la formation et de la jeunesse, bénéficie du soutien de la République et canton de Genève.</p>


            </div>
            <div class="col-sm-4 col-xs-12">
                <img src="<?php echo $tdu; ?>/assets/footer-image_03.png" alt="">

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php endif; ?>
                <p style="margin-bottom:0;">IBAN : CH73 0900 0000 1200 5505 3</p>
                <p>BIC : POFICHBEXXX</p>
                <hr>
                <img style="height:40px;margin-right:10px;" src="<?php echo $tdu; ?>/assets/footer-image_01.png" alt="">
                <img style="height:40px;" src="<?php echo $tdu; ?>/assets/footer-image_02.png" alt="">
            </div>


            <div class="col-sm-4 col-xs-12">
                <?php $locations_url =  get_site_url() . '/centres-denseignement/'; ?>
                <h4><a href="<?php echo $locations_url; ?>">les centres d’enseignements</a></h4>
                <?php $centers = get_posts(array(  'orderby'=> 'post_title' , 'order' =>'ASC' , 'post_type' => 'location' , 'posts_per_page' => -1)); ?>
                <select name="locations" class="locations_dropdown" style="margin-bottom: 20px">
                    <?php foreach ($centers as $center) : ?>
                        <option value="<?php echo $center->guid; ?>"><?php echo $center->post_title; ?></option>
                    <?php endforeach; ?>
                </select>

                <a href="<?php echo $locations_url; ?>" style="display: block">
                    <img style="width:100%;height:auto;" src="<?php echo $tdu; ?>/assets/actus2insc2019.jpg" alt="les centres d’enseignements" />
                </a>

            </div>





        </div>
    </div>
</footer>

<!-- Scripts -->
<?php wp_footer(); ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc9birEXZTWqHOAUTHvX59jm-MxESi048"></script>


<script>
jQuery('.program').on("touchstart", function (e) {
    'use strict'; //satisfy code inspectors
    var link = jQuery(this); //preselect the link
    if (link.hasClass('hover')) {
        return true;
    }
    else {
        link.addClass('hover');
        jQuery('.program').not(this).removeClass('hover');
        e.preventDefault();
        return false; //extra, and to make sure the function has consistent return points
    }
});
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130508676-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-130508676-2');
</script>



</body>
</html>
