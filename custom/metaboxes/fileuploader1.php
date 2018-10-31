<?php

    //Add Metabox
    add_action('add_meta_boxes', 'add_upload_file_metaboxes');

    function add_upload_file_metaboxes() {
        add_meta_box('swp_file_upload', 'Plan d\'études', 'swp_file_upload', 'programme', 'normal', 'default');
    }


    function swp_file_upload() {
        global $post;
        // Noncename needed to verify where the data originated
        echo '<input type="hidden" name="podcastmeta_noncename" id="podcastmeta_noncename" value="'.
        wp_create_nonce(plugin_basename(__FILE__)).
        '" />';
        global $wpdb;
        $strFile = get_post_meta($post -> ID, $key = 'podcast_file', true);
        $media_file = get_post_meta($post -> ID, $key = '_wp_attached_file', true);
        if (!empty($media_file)) {
            $strFile = $media_file;
        } ?>


        <script type = "text/javascript">

            // Uploading files
            var file_frame;
            jQuery('#upload_image_button').live('click', function(podcast) {
            podcast.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery(this).data('uploader_title'),
                button: {
                    text: jQuery(this).data('uploader_button_text'),
                },
                multiple: false // Set to true to allow multiple files to be selected
            });

            // When a file is selected, run a callback.
            file_frame.on('select', function(){
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();
                // Url of the file
                var url = attachment.url;

                var field = document.getElementById("podcast_file");

                field.value = url; //set which variable you want the field to have
            });

            // Finally, open the modal
            file_frame.open();
        });

        </script>



        <div>
            <table>
                <tr valign = "top">
                    <td>
                        <input 	type = "text" name = "podcast_file" id = "podcast_file" size = "70" value = "<?php echo $strFile; ?>" />
                        <input id = "upload_image_button" type = "button" value = "Upload">
                    </td> 
                </tr>
            </table> 
            
            <input 	type = "hidden" name = "img_txt_id" id = "img_txt_id" value = "" />
        </div>  
            
    <?php
        function admin_scripts() {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }

        function admin_styles() {
            wp_enqueue_style('thickbox');
        }
        add_action('admin_print_scripts', 'admin_scripts');
        add_action('admin_print_styles', 'admin_styles');
    }


    //Saving the file
    function save_podcasts_meta($post_id, $post) {
        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if(isset($_POST['podcastmeta_noncename'])){
            if (!wp_verify_nonce($_POST['podcastmeta_noncename'], plugin_basename(__FILE__))) {
                return $post -> ID;
            }
        }
            

        // Is the user allowed to edit the post?
        if (!current_user_can('edit_post', $post -> ID))
            return $post -> ID;
        // We need to find and save the data
        // We'll put it into an array to make it easier to loop though.
        if(isset($_POST['podcast_file'])){
            $podcasts_meta['podcast_file'] = $_POST['podcast_file'];


            
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
    add_action('save_post', 'save_podcasts_meta', 1, 2); // save the custom fields
?>