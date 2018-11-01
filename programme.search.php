
<form id="search_courses_form" action="<?php echo get_site_url(); ?>/search-results/" method="GET">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">

                <input placeholder="chercher un cours"  type="text" name="k" id="cours_search">
            </div>
            <div class="col-sm-3">


                <a href="#" data-box="#category_box"  class="search_button" id="category_button">
                    Catégorie


                    <div id="category_box" class="search_box">
                        <?php $terms = get_terms( 'programmes'); ?>
                        <?php foreach ($terms as $term)  : ?>
                            <label><input type="checkbox" class="search_check" value="<?php echo $term->term_id; ?>" data-field="category" /> <?php echo $term->name; ?>   </label>
                        <?php endforeach; ?>

                    </div>

                </a>
            </div>
            <div class="col-sm-3">

                <a href="#" data-box="#location_box" class="search_button"  id="location_button">
                    Lieu
                    <div id="location_box" class="search_box">


                        <?php $zones = get_posts(array('post_type'  => 'zone',  'orderby'=> 'post_title' , 'order' =>'ASC' , 'posts_per_page' => -1  ) );  ?>
                        <?php foreach ($zones as $zone)  : ?>
                            <label><input type="checkbox" class="search_check" value="<?php echo $zone->ID; ?>" data-field="location" /> <?php echo $zone->post_title; ?>   </label>
                        <?php endforeach; ?>

                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="#" data-box="#age_box"  class="search_button" id="age_button">
                    Age

                    <div id="age_box" class="search_box">

                        <label><input type="checkbox" class="search_check" value="4" data-field="age" />ENTRE 4 ET 7 ANS</label>
                        <label><input type="checkbox" class="search_check" value="7" data-field="age" />ENTRE 7 ET 25 ANS</label>
                        <label><input type="checkbox" class="search_check" value="25" data-field="age" />+DE 25 ANS</label>

                    </div>
                </a>

            </div>
        </div>



        <a href="#" id="reset_course_form">réinitialiser</a>







    </div>

</form>
