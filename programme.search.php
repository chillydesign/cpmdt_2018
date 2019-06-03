<div class="search-container">
    <form id="search_courses_form" action="<?php echo get_site_url(); ?>/search-results/" method="GET">
        <div class="container">
            <div class="row">

                <div class="col-sm-2">
                    <input placeholder="chercher un cours"  type="text" name="k" id="cours_search">
                </div>
                <div class="col-sm-3">
                    <a href="#" data-box="#age_box"  class="search_button" id="age_button">
                        <div class="search_heading">Âge</div>
                        <span id="age_summary" class="search_summary" data-default="Tous les âges">Tous les âges</span>



                        <?php if ( use_new_age_range()   ) : ?>
                            <div id="age_box" class="search_box">
                                 <label><input name="age" type="checkbox" class="search_check" value="entre-1-et-4-ans" data-field="age" data-label="ENTRE 1 ET 4 ANS" /><span>ENTRE 1 ET 4 ANS</span></label>
                                <label><input name="age" type="checkbox" class="search_check" value="entre-4-et-7-ans" data-field="age" data-label="ENTRE 4 ET 7 ANS" /><span>ENTRE 4 ET 7 ANS</span></label>
                                <label><input name="age" type="checkbox" class="search_check" value="entre-7-et-25-ans" data-field="age" data-label="ENTRE 7 ET 25 ANS" /><span>ENTRE 7 ET 25 ANS</span></label>
                                <label><input name="age" type="checkbox" class="search_check" value="de-25-ans" data-field="age" data-label="+DE 25 ANS" /><span>+DE 25 ANS</span></label>
                            </div>

                            <script>var use_new_age_range = true; </script>
                        <?php else : ?>
                        <div id="age_box" class="search_box">
                            <label><input name="age" type="checkbox" class="search_check" value="4" data-field="age" data-label="ENTRE 4 ET 7 ANS" /><span>ENTRE 4 ET 7 ANS</span></label>
                            <label><input name="age" type="checkbox" class="search_check" value="7" data-field="age" data-label="ENTRE 7 ET 25 ANS" /><span>ENTRE 7 ET 25 ANS</span></label>
                            <label><input name="age" type="checkbox" class="search_check" value="25" data-field="age" data-label="+DE 25 ANS" /><span>+DE 25 ANS</span></label>
                        </div>
                        <?php endif; ?>


                    </a>

                </div>
                <div class="col-sm-3">
                    <a href="#" data-box="#category_box"  class="search_button" id="category_button">

                        <div class="search_heading">Catégorie</div>
                        <span id="cat_summary"  class="search_summary" data-default="Toutes les catégories"> Toutes les catégories</span>

                        <div id="category_box" class="search_box">
                            <?php $terms = get_terms(array(
                                'taxonomy' => 'programmes',
                                'hide_empty' => true,
                                'exclude' => array(51) // exclude cat of cours47
                            ) ); ?>
                            <?php foreach ($terms as $term)  : ?>
                                <label><input name="category" type="checkbox" class="search_check" value="<?php echo $term->term_id; ?>" data-label="<?php echo $term->name; ?>" data-field="category" /> <span><?php echo $term->name; ?> </span>  </label>
                            <?php endforeach; ?>

                        </div>

                    </a>
                </div>
                <div class="col-sm-3">

                    <a href="#" data-box="#location_box" class="search_button"  id="location_button">
                        <div class="search_heading">Lieu</div>
                        <span id="location_summary" class="search_summary" data-default="Tous les lieux"> Tous les lieux </span>
                        <div id="location_box" class="search_box">


                            <?php $zones = get_posts(array('post_type'  => 'zone',  'orderby'=> 'post_title' , 'order' =>'ASC' , 'posts_per_page' => -1  ) );  ?>
                            <?php foreach ($zones as $zone)  : ?>
                                <label><input name="loc" type="checkbox" class="search_check" value="<?php echo $zone->ID; ?>" data-label="<?php echo $zone->post_title; ?>"  data-field="location" /> <span><?php echo $zone->post_title; ?></span>   </label>
                            <?php endforeach; ?>

                        </div>
                    </a>
                </div>
                <div class="col-sm-1 ">
                    <button type="submit" class="">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icon-search_loop.svg">
                    </button>
                </div>


            </div>



            <!-- <a href="#" id="reset_course_form">réinitialiser</a> -->


        </div>

    </form>
</div>
