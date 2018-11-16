<?php get_header(); ?>

	<?php // get_template_part( 'breadcrumbs' ); ?>

	<!--Title  -->
	<div class="page-title">
		<div class="container">
			<h1>AGENDA / <span><?php the_title() ?></span></h1>
		</div>
	</div>

	<div class="single-agenda">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

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

            <div class="container <?php echo $programSlug; ?>">
                <div class="row">
                    <div class="col-sm-3 col-xs-12 event-timeable">
                        <ul>
                            <li style="text-transform: capitalize;">
                                <!-- <?php  //get_custom_field('a_date'); ?> -->
                                <?php  $dd = date('Y-m-d', strtotime(get_custom_field('a_date'))); ?>
                                <?php echo utf8_encode(strftime("%A %d %B %Y", strtotime( $dd ) )); ?>
                            </li>
                            <li>
                                <?php echo get_custom_field('a_time');; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-7 col-xs-12 event-content">
								<h5><b> <?php echo $programName ?></b> //
								  		<?php echo $typesName ?></h5>

								<h4> <?php the_title(); ?> </h4>
                                <?php the_content(); ?>
								<div class="buttons">
									<div class="share-buttons pull-left">
										<small>JE PARTAGE</small>
                                        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink() ?>"><i class="fa fa-facebook"></i> </a>
                                        <!-- <a target="_blank" href="http://twitter.com/home/?status=<?php the_permalink() ?>"> <i class="fa fa-twitter"></i> </a> -->
									</div>
								</div>
                            </div>
                            <div class="col-sm-5 col-xs-12 event-address">
                                <?php $address = get_address($post->ID);
                                    echo $address['long_address']; ?>
                            </div>
                        </div>
                        <div class="row forms-container">
                            <div class="col-sm-12 col-xs-12">
                                <?php $agenda_id = get_the_ID();
                                    // $count_persons = get_agenda_count('107', $agenda_id, '70');
                                    $count_persons = count_people_at_event(  $agenda_id  );
                                    $places_left = get_custom_field("a_amount") - $count_persons;
                                    ?>
                                <?php if (get_custom_field('is_required') == "YES"){?>
                                    <div class="row text-uppercase">
                                        <div class="col-sm-6 col-xs-12"><h3>je m’inscris à cet événement</h3></div>
                                        <div class="col-sm-6 col-xs-12"><b class="pull-right">
                                        <?php
                                        if($places_left > 0){
                                            echo 'PLACES DISPONIBLES: ' . $places_left . ' personnes';
                                        }
                                        else{
                                            echo 'Aucune place disponible';
                                        }
                                        ?> </b></div>
                                    </div>
                                    <br>
                                        <?php
                                        if($places_left > 0){
                                            get_template_part('booking-form');
                                        //    echo do_shortcode('[formidable id=10]');
                                        }
                                        ?> </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endwhile; else: ?>

            <h1>Nuk gjenden postime!</h1>
            <p>Ju lutem qe te rishikoni adresen tuaj.</p>

        <?php endif; ?>
	</div>
<script>
    //hide all items
    jQuery('.agenda-item-2, .agenda-item-3, .agenda-item-4, .agenda-item-5').hide();

    //show items based in number selected on dropdown
    jQuery('#field_6a1p1').change(function(){
        jQuery('.agenda-item-2, .agenda-item-3, .agenda-item-4, .agenda-item-5').hide();
        var value = jQuery('#field_6a1p1').val();
        for(var i=2;i<=value;i++){
            jQuery('.agenda-item-'+i).show();
        }

        //set empty value to not shown inputs
        for(var j=5;j>value;j--){
            jQuery('.agenda-item-'+j+' input').val('');
        }
    });

    // Post ID
    var ID = '<?php echo the_ID(); ?>';
    var post_title = '<?php echo the_title(); ?>';
    // Change value of the hidden input
    jQuery(document).ready(function(){
        jQuery('#field_postid').val(ID);
        jQuery('#field_title').val(post_title);
    });

</script>
<?php get_footer(); ?>
