<div class="search-container">
    <div class="container">
        <form action="<?php echo get_site_url(); ?>/search-results/" method="GET" >
            <div class="row text-uppercase font-bold">
                <div class="col-sm-4 col-xs-12">
                    <?php
                        $age_1 = 0;
                        $age_2 = 0;
                        if(isset($_GET['age'])){
                            $cat = $_GET['cat'];
                            $age_arr = explode('-', $_GET['age']);
                            $age_1 = $age_arr[0];
                            $age_2 = $age_arr[1];
                        }
                    ?>
                    <label for="#">J'AI</label>
                    <select name="age" id="s_">
                        <option value="4-7" <?php if($age_1 == 4){ echo "selected='select'"; } ?>>  ENTRE 4 ET 7 ANS</option>
                        <option value="7-25" <?php if($age_1 == 7){ echo "selected='select'"; } ?>>  ENTRE 7 ET 25 ANS</option>
                        <option value="25-70" <?php if($age_1 == 25){ echo "selected='select'"; } ?>>  +DE 25 ANS </option>
                    </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <label for="#">je recherche</label>
                    <?php
                        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                        $args = array(
                            'taxonomy'                 => 'programmes',
                            'orderby'                  => 'name',
                            'order'                    => 'ASC',
                        );

                        //$cats = get_categories( $args );
                        //$categories = get_categories('taxonomy=programmes');
                        $categories = get_categories($args);
                        $select = "<select name='cat' id='cat' class=''>";

                        foreach($categories as $category){
                            if($category->count > 0 && $category->slug != "theatre"){
                                if(isset($_GET['cat'])){
                                    if($category->term_id == $_GET['cat']){
                                        $select.= "<option value='".$category->term_id."' selected='select'>de la ".$category->name."</option>";
                                    }else{
                                        $select.= "<option value='".$category->term_id."'>de la ".$category->name."</option>";
                                    }


                                }else{
                                    if($category->term_id == 20){
                                        $select.= "<option value='".$category->term_id."' selected='select'>de la ".$category->name."</option>";
                                    }else{
                                        $select.= "<option value='".$category->term_id."'>de la ".$category->name."</option>";
                                    }
                                }
                            }
                            if($category->slug == "theatre"){
                                if(isset($_GET['cat'])){
                                    if($category->term_id == $_GET['cat']){
                                        $select.= "<option value='".$category->term_id."' selected='select'>du ".$category->name."</option>";
                                    }else{
                                        $select.= "<option value='".$category->term_id."'>du ".$category->name."</option>";
                                    }

                                }else{
                                    $select.= "<option value='".$category->term_id."'>du ".$category->name."</option>";
                                }

                            }
                        }
                        $select.= "</select>";
                        echo $select;
                    ?>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <label for="#">j’habite vers </label>
                    <select name="zone_id" id="s_">
                        <option value='-1'>indifférent</option>
                        <?php
                            $args = array(
                                'post_type' => 'zone',
                                'posts_per_page' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC'
                            );
                            $zones = new WP_Query( $args );
                            if ( $zones->have_posts() ) {
                                while ( $zones->have_posts() ) {
                                    $zones->the_post(); ?>
                                    <?php
                                        if(isset($_GET['zone_id'])){
                                            if($_GET['zone_id'] == -1){ ?>
                                                 <option value="<?php the_ID();?>"><?php the_title(); ?></option>
                                            <?php
                                            }elseif ($_GET['zone_id'] != -1) {
                                                if(get_the_ID() == $_GET['zone_id']){
                                                    ?>
                                                     <option value="<?php the_ID();?>" selected='select' ><?php the_title(); ?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php the_ID();?>" ><?php the_title(); ?></option>
                                                <?php
                                                }
                                            }
                                        }else{ ?>
                                             <option value="<?php the_ID();?>"  ><?php the_title(); ?></option>
                                        <?php }

                                    ?>
                                    <!-- <option value="<?php //the_ID();?>"><?php //the_title(); ?></option> -->
                                    <?php
                                } // end while have zones
                            }; // end if have zones
                            wp_reset_query();

                        ?>

                    </select>
                </div>
                <div class="col-sm-1 col-xs-12">
                    <button type="submit" class="">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icon-search_loop.svg">
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
