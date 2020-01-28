<?php
    /*! Custom post type */
    add_action('init', 'agenda_posttype');
    function agenda_posttype()
    {
        $labels = array(
            'name' => _x('Événements', 'agenda'),
            'singular_name' => _x('événement', 'agenda'),
            'add_new' => _x('Ajouter', 'agenda'),
            'add_new_item' => __('Ajouter'),
            'edit_item' => __('Modifier évenement'),
            'new_item' => __('Nouveau évenement'),
            'view_item' => __('Voir évenement'),
            'search_items' => __('Rechercher évenement'),
            'not_found' =>  __('Aucun résultat'),
            'not_found_in_trash' => __('Aucun résultat'),
            'parent_item_colon' => ''
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'map_meta_cap' => true,

            'menu_position' => null,
            'menu_icon' => 'dashicons-calendar',
            'supports' => array('title', 'editor', 'thumbnail')
        );
        register_post_type('agenda',$args);

    } // Finished custom-post-type AGENDA ///////////

    // Agenda CATEGORIES
    register_taxonomy( "agenda-category",
        array( 	"agenda" ),
        array( 	"hierarchical" => true,
                "labels" => array('name'=>"Catégories",'add_new_item'=>"Nouveau"),
                "singular_label" => __( "Field" ),
                'query_var' => true,
                "rewrite" => array( 'slug' => 'a-categories', 'with_front' => false)
            )
    );

    // Agenda PROGRAMME
    register_taxonomy( "agenda-program",
        array( 	"agenda" ),
        array( 	"hierarchical" => true,
                "labels" => array('name'=>"Programme",'add_new_item'=>"Nouveau"),
                "singular_label" => __( "Field" ),
                "rewrite" => array( 'slug' => 'agenda-programme', 'with_front' => false)
            )
    ); // Agenda TYPE
    register_taxonomy( "agenda-type",
        array( 	"agenda" ),
        array( 	"hierarchical" => true,
                "labels" => array('name'=>"Type",'add_new_item'=>"Nouveau"),
                "singular_label" => __( "Field" ),
                "rewrite" => array( 'slug' => 'agenda-type', 'with_front' => false)
            )
    );
    // Create the meta box
    add_action("admin_init", "agenda_admin_init");
    function agenda_admin_init(){
        add_meta_box("location_meta", "Événements informations", "agenda_details_meta", "agenda", "normal", "default");
    }

    //get addresses from DB
    function get_addresses(){
        global $wpdb;
        $sql = "SELECT * FROM wp_posts WHERE post_type = 'address' AND post_status = 'publish' ORDER BY post_title ASC";
        $result = $wpdb->get_results($sql, OBJECT);

        return $result;
    }

    // Display the boxes
    function agenda_details_meta() {
        $ret = '<p><label><strong>Inscription à l\'événement?</strong> </label>';
        if (get_custom_field('is_required') == "YES"){
            $ret .= '</br><label for="yes"><input type="radio" value="YES" id="yes" name="is_required" checked>Yes</label>
                    <label for="no"><input name="is_required" id="no" type="radio" value="NO">No</label><p>';
        }else{
            $ret .= '</br><label for="yes"><input type="radio" value="YES" id="yes" name="is_required">Yes</label></p>
                    <p><label for="no"><input name="is_required" id="no" type="radio" value="NO" checked>No</label></p>';
        }
        // Amount of registrations allowed
        $ret .= '<p>
                    <label for="a_amount"><strong>Places pour l\'événement:</strong> </label>
                    <br/>
                    <input style="width:50%" type="number" size="70" placeholder="" id="a_amount" name="a_amount" value="'.get_custom_field("a_amount").'" />
                </p>';
        // Date of the agenda
        // $ret .= '<p>
        //             <label for="a_date"><strong> Date de l\'événement:</strong></label>
        //             <br/>
        //             <input style="width:50%" type="text" size="70" placeholder="" id="a_date" name="a_date" value="'.get_custom_field("a_date").'" />
        //         </p>';
        $ret .= '<p>';
        $ret .= "<label for='address'><strong>  Date de l'événement:  </strong></label><br />";
        if(get_custom_field("a_date") != null){
            $ret .=  '<input type="text" name="a_date_show" value="'.  date('d-m-Y', strtotime(get_custom_field("a_date"))).'">';
            $ret .= '<input type="hidden" id="a_date" name="a_date" value="'.get_custom_field("a_date").'">';
        }else{
            $ret .=  '<input type="text" name="a_date_show" value="'.  date('d-m-Y').'">';
            $ret .= '<input type="hidden" id="a_date" name="a_date" value="'.date('Ymd').'">';
        }


        $ret .= '</p>';
        $ret .= '<script>jQuery(document).ready(function(){jQuery( "input[name=\'a_date_show\']" ).datepicker({ dateFormat: \'dd-mm-yy\', numberOfMonths: 1,onSelect: function () {
                var str=this.value;
                var res = str.split("-");
                var str = res[2]+res[1]+res[0];
                jQuery("#a_date").val(str);
            } }); jQuery( "#ui-datepicker-div" ).hide();});</script>';

        // Time of the agenda
        $ret .= '<p>
                    <label for="a_time"><strong> Heure de l\'événement:</strong></label>
                    <br/>
                    <input style="width:50%" type="text" size="70" placeholder="" id="a_time" name="a_time" value="'.get_custom_field("a_time").'" />
                </p>';

        //Address
        $addresses = get_addresses();
        $ret .= '<p style="margin-bottom:0;">';
        $ret .= '<label for="address"><strong> Lieu de l\'événement:</strong> </label><br />';
        $ret .= '<select name="address_id" id="address" >';
        foreach($addresses as $address){
            if(get_custom_field("address_id") == $address->ID){
                $ret .= '<option value="'.$address->ID.'" selected>'.$address->post_title.'</option>';
            }else{
                $ret .= '<option value="'.$address->ID.'">'.$address->post_title.'</option>';
            }
        }
        $ret .= '</select>';
        $ret .= '</p>';
        //Archive date
        $ret .= '<p>';
        $ret .= '<label for="address"><strong> Date de fin:</strong></label><br />';
        if(get_custom_field("archive_date") != null){
            $ret .=  '<input type="text" name="archive_date_show" value="'. date("d-m-Y", strtotime(get_custom_field("archive_date"))).'">';
            $ret .= '<input type="hidden" name="archive_date" id="archive_date" value="'.get_custom_field("archive_date").'">  ';
        }else{
            $ret .=  '<input type="text" name="archive_date_show" value="'. date("d-m-Y").'">';
            $ret .= '<input type="hidden" name="archive_date" id="archive_date" value="'.date("Ymd").'">  ';
        }

        //$ret .= '<input type="hidden" name="archive_date" id="archive_date" value="'.get_custom_field("archive_date").'">  ';
        $ret .= '</p>';
        $ret .= '<script>jQuery(document).ready(function(){jQuery( "input[name=\'archive_date_show\']" ).datepicker({ dateFormat: \'dd-mm-yy\', numberOfMonths: 1, onSelect: function () {
            var str=this.value;
            var res = str.split("-");
            var str = res[2]+res[1]+res[0];
            jQuery("#archive_date").val(str);
        } }); jQuery( "#ui-datepicker-div" ).hide();});</script>';

        echo $ret;
    }
    // Saving the changes
    add_action('save_post', 'save_agenda_details');
    function save_agenda_details(){
        global $post;

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if(get_post_type($post) != 'agenda')
            return;

        save_custom_field("a_amount");
        save_custom_field("is_required");
        save_custom_field("a_date");
        save_custom_field("a_time");
        save_custom_field("address_id");
        save_custom_field("archive_date");
    }

    add_filter('manage_event_posts_columns', 'bs_event_table_head');
    function bs_event_table_head( $defaults ) {
        $defaults['a_date']  = "Date de l'événement:";
        $defaults['archive_date']    = 'Date de fin:';

        return $defaults;
    }

    add_action( 'manage_event_posts_custom_column', 'bs_event_table_content', 10, 2 );

    function bs_event_table_content( $column_name, $post_id ) {
        if ($column_name == 'a_date') {
        $event_date = get_post_meta( $post_id, '_bs_meta_event_date', true );
          echo  date( _x( 'F d, Y', 'Event date format', 'textdomain' ), strtotime( $a_date ) );
        }

        if ($column_name == 'archive_date') {
        $event_date = get_post_meta( $post_id, '_bs_meta_event_date', true );
          echo  date( _x( 'F d, Y', 'Event date format', 'textdomain' ), strtotime( $a_date ) );
        }


    }

    /*
     * Add columns to agenda post list
     */
     function add_acf_columns ( $columns ) {
       // return array_merge ( $columns, array (
       //   'a_date' => __ ( 'Starts' ),
       //   'archive_date'   => __ ( 'Ends' )
       // ) );
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title' ),
            'a_date' => __( "Date de l'événement " ),
            'archive_date' => __( "Date de fin" ),
            'date' => __( 'Date' )
        );
     }
     add_filter ( 'manage_agenda_posts_columns', 'add_acf_columns' );

      /*
     * Add columns to agenda post list
     */
      function exhibition_custom_column ( $column, $post_id ) {
       switch ( $column ) {
         case 'a_date':
           echo date('d/m/Y', strtotime(get_post_meta ( $post_id, 'a_date', true )));
           break;
         case 'archive_date':
            echo date('d/m/Y', strtotime(get_post_meta ( $post_id, 'archive_date', true )));
           //echo get_post_meta ( $post_id, 'archive_date', true );
           break;
       }
     }
     add_action ( 'manage_agenda_posts_custom_column', 'exhibition_custom_column', 10, 2 );
     //Columns ordering
     add_filter( 'manage_edit-agenda_sortable_columns', 'bs_event_table_sorting' );
        function bs_event_table_sorting( $columns ) {
          $columns['a_date'] = 'a_date';
          $columns['archive_date'] = 'archive_date';
          return $columns;
        }

        add_filter( 'request', 'bs_event_date_column_orderby' );
        function bs_event_date_column_orderby( $vars ) {
            if ( isset( $vars['orderby'] ) && 'a_date' == $vars['orderby'] ) {
                $vars = array_merge( $vars, array(
                    'meta_key' => 'a_date',
                    'orderby' => 'meta_value'
                ) );
            }
            //var_dump($vars);
            return $vars;
        }

        add_filter( 'request', 'bs_ticket_status_column_orderby' );
        function bs_ticket_status_column_orderby( $vars ) {
            if ( isset( $vars['orderby'] ) && 'archive_date' == $vars['orderby'] ) {
                $vars = array_merge( $vars, array(
                    'meta_key' => 'archive_date',
                    'orderby' => 'meta_value'
                ) );
            }

            return $vars;
        }


        //Filter on dashboard for agenda

    //    add_action( 'restrict_manage_posts', 'filter_events_by_taxonomies' , 10, 2);

        function filter_events_by_taxonomies( $post_type, $which ) {
        // Apply this only on a specific post type
        if ( 'agenda' !== $post_type )
            return;

        // A list of taxonomy slugs to filter by
        $taxonomies = array('type', 'a_date', 'archive_date' );

        foreach ( $taxonomies as $taxonomy_slug ) {
            if($taxonomy_slug == 'a_date'){
                ?>
                <select name="type_search">
                    <option value="1">Date de l'événement</option>
                    <option value="2">Date de fin</option>
                </select>
        <?php
            }
            if($taxonomy_slug == 'a_date'){
                //echo "Date de l'événement ";

                $a_date = ( isset($_GET['a_date']) ) ? $_GET['a_date'] : '';
                $archive_date = ( isset($_GET['archive_date']) ) ? $_GET['archive_date'] : '';

                echo "<input type='text' name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'value=". $a_date ."> ";
                echo '<script>jQuery(document).ready(function(){jQuery( "input[name=\'a_date\']" ).datepicker({ dateFormat: \'dd-mm-yy\', numberOfMonths: 1 }); jQuery( "#ui-datepicker-div" ).hide();});</script>';
            }
            if($taxonomy_slug == 'archive_date'){
                echo " - ";
                echo "<input type='text' name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform' value=". $archive_date ."> ";
                echo '<script>jQuery(document).ready(function(){jQuery( "input[name=\'archive_date\']" ).datepicker({ dateFormat: \'dd-mm-yy\', numberOfMonths: 1 }); jQuery( "#ui-datepicker-div" ).hide();});</script>';
            }
            echo "<style> #filter-by-date{ display:none;}</style>";
        }

    }

    //
    // add_action( 'pre_get_posts', 'wpse_189824_date_meta_query' );
    function wpse_189824_date_meta_query( $wp_query ) {
        global $pagenow;
        if ( is_admin() && $wp_query->get( 'post_type' ) === 'agenda' && 'edit.php' == $pagenow && isset( $_GET['a_date'] )) {
                $a_date = $_GET['a_date'];
                $archive_date = $_GET['archive_date'];
                if(!empty($a_date) && !empty($archive_date)){
                    //if ( ! $meta_query = $wp_query->get( 'meta_query' ) ) // Keep meta query if there currently is one
                    //$meta_query = array();
                    $start = date('Ymd', strtotime($_GET['a_date']));
                    $end = date('Ymd', strtotime($_GET['archive_date']));

                    if($_GET['type_search'] == 1){
                        $meta_query =  array(
                            array(
                                'key' => 'a_date',
                                'value' => $start, // perhaps "true" instead?
                                'compare' => '>'
                            ),
                            array(
                                'key' => 'a_date',
                                'value' => $end, // perhaps "true" instead?
                                'compare' => '<'
                            )
                        );
                    }
                    if($_GET['type_search'] == 2){
                        $meta_query =  array(
                            array(
                                'key' => 'archive_date',
                                'value' => $start, // perhaps "true" instead?
                                'compare' => '>'
                            ),
                            array(
                                'key' => 'archive_date',
                                'value' => $end, // perhaps "true" instead?
                                'compare' => '<'
                            )
                        );
                    }
                    $wp_query->set( 'meta_query', $meta_query );
            }
        }
    }

    //Remove limit to taxonomy of agenda
    add_action('pre_get_posts', 'change_tax_num_of_posts' );
    function change_tax_num_of_posts( $query ) {
        if ( ! $query->is_main_query() ){
            return $query;
        }
        if (is_tax('agenda-category') && is_main_query()) {
            $query->set('posts_per_page', '-1');
            $query->set('orderby', 'meta_value');
            $query->set('meta_key', "a_date");
            $query->set('order', 'ASC');
        }
    }




    // add_action( 'manage_posts_extra_tablenav', 'add_download_link_agenda'  );
    // function add_download_link_agenda($which){
    //     if ( is_post_type_archive('agenda') ) {

    //         $download_link = get_home_url() . '/api/v1/?agenda';
    //         echo '<div class="alignleft actions"><a style="margin:0" title="Télécharger" class="action button-primary button" href="'. $download_link . '"> <span style="position:relative;top:4px" class="dashicons dashicons-download"></span>Télécharger</a></div>';
              
    //     }

    // }




?>
