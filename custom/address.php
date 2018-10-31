<?php
    /*! Custom post type */
    add_action('init', 'address_posttype');
    function address_posttype() 
    {
        $labels = array(
            'name' => _x('Adresses', 'address'),
            'singular_name' => _x('Adress', 'address'),
            'add_new' => _x('Ajouter', 'address'),
            'add_new_item' => __('Ajouter'),
            'edit_item' => __('Modifier Adress'),
            'new_item' => __('New Adress'),
            'view_item' => __('View Adress'),
            'search_items' => __('Search Adress'),
            'not_found' =>  __('No Adress found'),
            'not_found_in_trash' => __('No Adresses found in Trash'), 
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
            'menu_icon' => 'dashicons-location-alt',
            'supports' => array('title')
        ); 
        register_post_type('address',$args);

    } 
    // Create the meta box
    add_action("admin_init", "address_admin_init");
    function address_admin_init(){
        add_meta_box("location_meta", "Adresse informations", "address_details_meta", "address", "normal", "default");
    }
    // Display the boxes
    function address_details_meta() {
        $ret = '';
        $ret .= '<p style="margin-bottom:0;">
                    <label for="a_shortaddress"><strong> Adresse courte:</strong></label>
                    <br/>
                    <textarea style="width:50%" rows="4" type="text" size="70" placeholder="" id="a_shortaddress" name="a_shortaddress" value="">'.get_custom_field("a_shortaddress").'</textarea>
                    <p style="margin-top:0;">Suitable for text and HTML. May include <span style="background-color: #ccc;padding: 3px 5px;">HTML</span> tags.</p>
                </p>';
        // Long address
        $ret .= '<p style="margin-bottom:0;">
                    <label for="a_longaddress"><strong> Adresse complète:</strong></label>
                    <br/>
                    <textarea style="width:50%" rows="10" placeholder="" id="a_longaddress" name="a_longaddress" value="">'.get_custom_field("a_longaddress").'</textarea>
                    <p style="margin-top:0;">Suitable for text and HTML. May include <span style="background-color: #ccc;padding: 3px 5px;">HTML</span> tags.</p>
                </p>';
        echo $ret;
    }
    // Saving the changes
    add_action('save_post', 'save_address_details');
    function save_address_details(){
        global $post;
        
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if(get_post_type($post) != 'address')
            return;

        save_custom_field("a_shortaddress");
        save_custom_field("a_longaddress");
    }
?>