<?php

		// Create the meta box
		add_action("admin_init", "defpsot_metainit");
		function defpsot_metainit(){
		  add_meta_box("defpost_meta", "Extrait Article ", "post_meta", "post", "normal", "default");
		}
		// Display the boxes
		function post_meta() {
			 $ret = '<p>
						<label for="post_excerptCF">Extrait:</label><br/>
						<textarea style="width: 50%;" rows="5" size="70" placeholder="" id="post_excerptCF" name="post_excerptCF">'.get_custom_field("post_excerptCF").'</textarea>	
					</p>';
		    echo $ret;
		}

		// Save the changes
		add_action('save_post', 'save_post_meta');
		function save_post_meta(){
		   	global $post;
		 
		   	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		      	return;

		   	// if(get_post_type($post) != 'post')
		    //   	return;
		 
		   	save_custom_field("post_excerptCF");
		}

?>