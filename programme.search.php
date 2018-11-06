<div class="search-container">
    <form id="search_courses_form" action="<?php echo get_site_url(); ?>/search-results/" method="GET">
        <div class="container">
            <div class="row">

                <div class="col-sm-2">
                    <input placeholder="chercher un cours"  type="text" name="k" id="cours_search">
                </div>
                <div class="col-sm-3">
                    <a href="#" data-box="#age_box"  class="search_button" id="age_button">
                        <div class="search_heading">Age</div>
                        <span id="age_summary" class="search_summary" data-default="all ages">all ages</span>

                        <div id="age_box" class="search_box">
                            <label><input name="age" type="checkbox" class="search_check" value="4" data-field="age" data-label="ENTRE 4 ET 7 ANS" />ENTRE 4 ET 7 ANS</label>
                            <label><input name="age" type="checkbox" class="search_check" value="7" data-field="age" data-label="ENTRE 7 ET 25 ANS" />ENTRE 7 ET 25 ANS</label>
                            <label><input name="age" type="checkbox" class="search_check" value="25" data-field="age" data-label="+DE 25 ANS" />+DE 25 ANS</label>
                        </div>
                    </a>

                </div>
                <div class="col-sm-3">
                    <a href="#" data-box="#category_box"  class="search_button" id="category_button">

                        <div class="search_heading">Catégorie</div>
                        <span id="cat_summary"  class="search_summary" data-default="all categories"> all categories</span>

                        <div id="category_box" class="search_box">
                            <?php $terms = get_terms( 'programmes'); ?>
                            <?php foreach ($terms as $term)  : ?>
                                <label><input name="category" type="checkbox" class="search_check" value="<?php echo $term->term_id; ?>" data-label="<?php echo $term->name; ?>" data-field="category" /> <?php echo $term->name; ?>   </label>
                            <?php endforeach; ?>

                        </div>

                    </a>
                </div>
                <div class="col-sm-3">

                    <a href="#" data-box="#location_box" class="search_button"  id="location_button">
                        <div class="search_heading">Lieu</div>
                        <span id="location_summary" class="search_summary" data-default="all locations"> all locations </span>
                        <div id="location_box" class="search_box">


                            <?php $zones = get_posts(array('post_type'  => 'zone',  'orderby'=> 'post_title' , 'order' =>'ASC' , 'posts_per_page' => -1  ) );  ?>
                            <?php foreach ($zones as $zone)  : ?>
                                <label><input name="loc" type="checkbox" class="search_check" value="<?php echo $zone->ID; ?>" data-label="<?php echo $zone->post_title; ?>"  data-field="location" /> <?php echo $zone->post_title; ?>   </label>
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



            <a href="#" id="reset_course_form">réinitialiser</a>


        </div>

    </form>
</div>
