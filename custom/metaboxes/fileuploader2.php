<?php

    //Add Metabox
    add_action('add_meta_boxes', 'add_upload_file_metaboxes2');

    function add_upload_file_metaboxes2() {
        add_meta_box('swp_file_upload2', 'PDF de la fiche', 'swp_file_upload2', 'programme', 'normal', 'default');
    }


    function swp_file_upload2() {
        global $post;
        // Noncename needed to verify where the data originated
        echo '<input type="hidden" name="podcastmeta_noncename2" id="podcastmeta_noncename2" value="'.
        wp_create_nonce(plugin_basename(__FILE__)).
        '" />';
        global $wpdb;
        $strFile2 = get_post_meta($post -> ID, $key = 'podcast_file2', true);
        $media_file = get_post_meta($post -> ID, $key = '_wp_attached_file', true);
        if (!empty($media_file)) {
            $strFile2 = $media_file;
        } ?>


        <script type = "text/javascript">

            // Uploading files
            var file_frame2;
            jQuery('#upload_image_button2').live('click', function(podcast2) {
            console.log('first touch3');
            podcast2.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame2) {
                file_frame2.open();
                return;
            }

            // Create the media frame.
            file_frame2 = wp.media.frames.file_frame2 = wp.media({
                title: jQuery(this).data('uploader_title2'),
                button: {
                    text: jQuery(this).data('uploader_button_text2'),
                },
                multiple: false // Set to true to allow multiple files to be selected
            });

            // When a file is selected, run a callback.
            file_frame2.on('select', function(){
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame2.state().get('selection').first().toJSON();
                // Url of the file
                var url = attachment.url;

                var field = document.getElementById("podcast_file2");

                field.value = url; //set which variable you want the field to have
            });

            // Finally, open the modal
            file_frame2.open();
        });

        </script>



        <div>
            <table>
                <tr valign = "top">
                    <td>
                        <input 	type="text" name = "podcast_file2" id = "podcast_file2" size = "70" value = "<?php echo $strFile2; ?>" />
                        <input id="upload_image_button2" type = "button" value = "Upload">
                    </td> 
                </tr>
            </table> 
            
            <input 	type="hidden" name = "img_txt_id2" id = "img_txt_id2" value = "" />
        </div>  
            
    <?php
        function admin_scripts2() {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }

        function admin_styles2() {
            wp_enqueue_style('thickbox');
        }
        add_action('admin_print_scripts', 'admin_scripts2');
        add_action('admin_print_styles', 'admin_styles2');
    }


    //Saving the file
    function save_podcasts_meta2($post_id, $post) {
        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if(isset($_POST['podcastmeta_noncename2'])){
            if (!wp_verify_nonce($_POST['podcastmeta_noncename2'], plugin_basename(__FILE__))) {
                return $post -> ID;
            }
        }
            

        // Is the user allowed to edit the post?
        if (!current_user_can('edit_post', $post -> ID))
            return $post -> ID;
        // We need to find and save the data
        // We'll put it into an array to make it easier to loop though.
        if(isset($_POST['podcast_file2'])){
            $podcasts_meta['podcast_file2'] = $_POST['podcast_file2'];
            // Add values of $podcasts_meta as custom fields

            foreach($podcasts_meta as $key => $value) {

                $value = implode(',', (array) $value);
                if (get_post_meta($post -> ID, $key, FALSE)) { // If the custom field already has a value it will update
                    update_post_meta($post -> ID, $key, $value);
                } else { // If the custom field doesn't have a value it will add
                    add_post_meta($post -> ID, $key, $value);
                }
                if (!$value) delete_post_meta($post -> ID, $key); // Delete if blank value
            }
        }
        
    }
    add_action('save_post', 'save_podcasts_meta2', 1, 2); // save the custom fields
?>