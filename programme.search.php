
<form method="" action="">
    <input placeholder="chercher un cours"  type="text" name="k" id="cours_search">

    <a href="#" data-box="#category_box"  class="search_button" id="category_button">Age</a>
    <a href="#" data-box="#category_box"  class="search_button" id="category_button">Catégorie</a>
    <a href="#" data-box="#location_box" class="search_button"  id="location_button">Lieu</a>


    <a href="#" id="reset_course_form">réinitialiser</a>

    <div id="age_box" class="search_box">

        <label><input type="checkbox" class="search_check" value="4" data-field="age" />ENTRE 4 ET 7 ANS</label>
        <label><input type="checkbox" class="search_check" value="7" data-field="age" />ENTRE 7 ET 25 ANS</label>
        <label><input type="checkbox" class="search_check" value="25" data-field="age" />+DE 25 ANS</label>

    </div>



    <div id="category_box" class="search_box">
        <?php $terms = get_terms( 'programmes'); ?>
        <?php foreach ($terms as $term)  : ?>
            <label><input type="checkbox" class="search_check" value="<?php echo $term->term_id; ?>" data-field="category" /> <?php echo $term->name; ?>   </label>
        <?php endforeach; ?>

    </div>

    <div id="location_box" class="search_box">


        <?php $zones = get_posts(array('post_type'  => 'zone',  'orderby'=> 'post_title' , 'order' =>'ASC' , 'posts_per_page' => -1  ) );  ?>
        <?php foreach ($zones as $zone)  : ?>
            <label><input type="checkbox" class="search_check" value="<?php echo $zone->ID; ?>" data-field="location" /> <?php echo $zone->post_title; ?>   </label>
        <?php endforeach; ?>

    </div>



</form>
