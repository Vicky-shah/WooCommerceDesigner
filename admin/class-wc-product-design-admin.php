<?php

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {

    exit; 

}

if ( !class_exists( 'Ak_Woo_Product_Design_Admin' ) ) {



	class Ak_Woo_Product_Design_Admin {



		public function __construct() {



			

			add_action( 'admin_enqueue_scripts', array( $this, 'akpd_admin_scripts' ) );

			//Custom meta boxes.

			add_action( 'save_post', array($this, 'akpd_meta_box_save' ));

			add_action( 'save_post_ak_wc_prodcut', array($this, 'ak_wc_prodcut_save_meta' ));

			add_action( 'save_post_ak_wc_prodcut_design', array($this, 'ak_wc_prodcut_design_save_meta' ));

			add_action( 'admin_menu', array( $this, 'akpd_custom_menu_admin' ) );



		}



		public function ak_wc_prodcut_design_save_meta( $post_id ){





			if ( empty( get_post_meta( $post_id, 'product_id', true ) )  && isset( $_POST['post_title']  ) ) {



				$post_args = array(

			        'post_title' => sanitize_text_field( $_POST['post_title'] ) ,

			        'post_type' => 'product',

			        'post_status' => 'publish',

			        'post_parent' => $post_id,

			    );



		    	$new_post_id = wp_insert_post( $post_args );
				$attach_id = get_post_thumbnail_id( $post_id );
				set_post_thumbnail( $new_post_id, $attach_id );


				update_post_meta($post_id,'product_id', $new_post_id );

				wp_update_post(array('ID' => $post_id , 'post_parent' => $new_post_id ));

			}

		}



		public function akpd_admin_scripts() {



			wp_enqueue_style( 'akpd-adminc', plugins_url( '/assest/css/akpd-admin.css', __FILE__ ), false, '1.0' );

			wp_enqueue_style( 'akpd-adminc1', plugins_url( '/assest/css/ka-sr-admin-styling.css', __FILE__ ), false, '1.0' );

			wp_enqueue_script( 'ak_admin_js', plugins_url( 'assest/js/akpd-admin.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );

			

			wp_enqueue_style( 'akpd_upload_files_sty', 'https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap', false, '1.0', false );

			$akpd_admin_data = array(

				'admin_url'  => admin_url('admin-ajax.php'),

				'nonce' => wp_create_nonce('akpd-ajax-nonce'),



			);

			wp_localize_script( 'ak_admin_js', 'akpd_admin_php_vars', $akpd_admin_data );

			wp_enqueue_style('thickbox');

			wp_enqueue_script('thickbox');

			wp_enqueue_script('media-upload');

			wp_enqueue_media();

		}





		public function akpd_meta_box_save( $post_id) {
			
	
				$flag = false;
				$args     = array( 'post_type' => 'product', 'posts_per_page' => -1 );
                $products = get_posts( $args ); 
				foreach($products as $product){
				   if(	wp_get_post_parent_id( $product->ID )==$post_id){
					  $attached_product = $product->ID;
					   $flag = true;
				   }
				}

		if($flag){
        $thumb_id =     get_post_thumbnail_id( $post_id );
    	set_post_thumbnail( $attached_product, $thumb_id );
		update_post_meta($attached_product, '_regular_price',$_POST['designs_list'][0]["price"]);
		update_post_meta($attached_product, '_price',$_POST['designs_list'][0]["price"]);

				}
			
			if ( isset( $_POST['featured_image'] ) ) {

				$featured_image =  sanitize_text_field($_POST['featured_image']) ;

				update_post_meta( $post_id, 'featured_image', $featured_image  );
				

			} 


			if ( isset( $_POST['colorPicker'] ) ) {

				$colorPicker =  sanitize_text_field($_POST['colorPicker']) ;

				update_post_meta( $post_id, 'colorPicker', $colorPicker  );

			} 



			

			if ( isset( $_POST['main_heading_size'] ) ) {



				$main_heading_size =  sanitize_text_field($_POST['main_heading_size']) ;



				update_post_meta( $post_id, 'main_heading_size', $main_heading_size  );



			} 

			

			if ( isset( $_POST['main_heading_color'] ) ) {



				$main_heading_color =  sanitize_text_field($_POST['main_heading_color']) ;



				update_post_meta( $post_id, 'main_heading_color', $main_heading_color  );



			} 



			if ( isset( $_POST['sub_heading_size'] ) ) {



				$sub_heading_size =  sanitize_text_field($_POST['sub_heading_size']) ;


				update_post_meta( $post_id, 'sub_heading_size', $sub_heading_size  );



			} 



			if ( isset( $_POST['sub_heading_color'] ) ) {



				$sub_heading_color =  sanitize_text_field($_POST['sub_heading_color']) ;



				update_post_meta( $post_id, 'sub_heading_color', $sub_heading_color  );



			} 



			if ( isset( $_POST['ak_description_text'] ) ) {



				$ak_description_text =  sanitize_text_field($_POST['ak_description_text']) ;



				update_post_meta( $post_id, 'ak_description_text', $ak_description_text  );



			} else {



				update_post_meta( $post_id, 'ak_description_text', "" );

			}



			if ( isset( $_POST['ak_description_text_font'] ) ) {



				$ak_description_text_font =  sanitize_text_field($_POST['ak_description_text_font']) ;



				update_post_meta( $post_id, 'ak_description_text_font', $ak_description_text_font  );



			} else {



				update_post_meta( $post_id, 'ak_description_text_font', "" );

			}

			

			if ( isset( $_POST['ak_colors_to_show'] ) ) {



				$ak_colors_to_show =  sanitize_text_field($_POST['ak_colors_to_show']) ;



				update_post_meta( $post_id, 'ak_colors_to_show', $ak_colors_to_show  );



			} else {



				update_post_meta( $post_id, 'ak_colors_to_show', "" );

			}

			if ( isset( $_POST['colors_list'] ) ) {
				update_post_meta( $post_id, 'colors_list', $_POST['colors_list']  );
			} else {
				update_post_meta( $post_id, 'colors_list', "" );
			}

			if ( isset( $_POST['frames_list'] ) ) {
				update_post_meta( $post_id, 'frames_list', $_POST['frames_list']  );
			} else {
				update_post_meta( $post_id, 'frames_list', "" );
			}

			if ( isset( $_POST['designs_list'] ) ) {
				update_post_meta( $post_id, 'designs_list', $_POST['designs_list']  );
			} else {
				update_post_meta( $post_id, 'designs_list', "" );
			}

			if ( isset( $_POST['artworks_list'] ) ) {
				update_post_meta( $post_id, 'artworks_list', $_POST['artworks_list']  );
			} else {
				update_post_meta( $post_id, 'artworks_list', "" );
			}






			// if our current user can't edit this post, return

			if ( !current_user_can( 'edit_posts' ) ) {

				return;

			}

			$ak_enable_design_background_color = get_post_meta($post_id, 'ak_enable_design_background_color', true);

			



			if ( isset( $_POST['afwhp_rule_type'] ) ) {

				update_post_meta( intval($post_id), 'ak_enable_design_background_color', $ak_enable_design_background_color );

			}



			

	}



		public function ak_wc_prodcut_save_meta( $post_id)

		{

			$old_data = ( array ) get_post_meta( $post_id, 'field_ids_array', true );



			$filed_ids_array 		= array_filter( $old_data );



			if (is_array( $filed_ids_array )) {

				foreach ($filed_ids_array as $current_filed_id ){

					if ( empty( $current_filed_id  ) ){

						continue;

					}

					

					if(isset($_POST['featured_image_'.$current_filed_id])){

						update_post_meta($current_filed_id, 'featured_image_'.$current_filed_id, sanitize_text_field($_POST['featured_image_'.$current_filed_id]) );

					}else {

						update_post_meta($current_filed_id, 'featured_image_'.$current_filed_id, '' );

					}

			$old_options_array = (array) get_post_meta( $current_filed_id,'option_added_post_ids_array', true );

				

				foreach ( $old_options_array as $current_option_id){

					if (empty($current_option_id)) {

						continue;

					}

					if(isset($_POST['image_'.$current_option_id])){

						update_post_meta($current_option_id, 'image_'.$current_option_id, sanitize_text_field($_POST['image_'.$current_option_id]) );

					}

					else {

						update_post_meta($current_option_id, 'image_'.$current_option_id, sanitize_text_field($_POST['image_'.$current_option_id]) );

					}

					if(isset($_POST['frame_'.$current_option_id])){

						update_post_meta($current_option_id, 'frame_'.$current_option_id, sanitize_text_field($_POST['frame_'.$current_option_id]) );

					}

					

					if(isset($_POST['price_'.$current_option_id])){

						update_post_meta($current_option_id, 'price_'.$current_option_id, sanitize_text_field($_POST['price_'.$current_option_id]) );

					}

						

					if(isset($_POST['color_name_'.$current_option_id])){

						update_post_meta($current_option_id, 'color_name_'.$current_option_id, sanitize_text_field($_POST['color_name_'.$current_option_id]) );

					}

						

				}

			}



		}



			remove_action('save_post_ak_wc_prodcut', array( $this, 'abc' ));

			$af_rule_as_prod = get_post_meta($post_id, 'af_rule_as_prod', true);

			$af_if_Prod_exist = wc_get_product( $af_rule_as_prod );

							

			if ( empty($af_rule_as_prod) && isset($_POST['post_title'])) {

				$title = sanitize_text_field($_POST['post_title']);

				$new_post_data = array('post_title'=>  $title ,'post_type'=>'product', 'post_status'=>'publish' , 'post_parent'=>$post_id);

				 $new_post_id = wp_insert_post($new_post_data);

				 update_post_meta($post_id, 'af_rule_as_prod' , 'yes');

				 wp_update_post(array('ID' => $post_id , 'post_parent' => $new_post_id ));

			} 

		}



		public function akpd_custom_menu_admin() {



			add_submenu_page( 'woocommerce', 'Product Design', 'Product Design', 'manage_options', 'edit.php?post_type=ak_wc_prodcut', '' );



			

		}



	}



	new Ak_Woo_Product_Design_Admin();



}

