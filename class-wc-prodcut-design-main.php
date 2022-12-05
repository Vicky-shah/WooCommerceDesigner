<?php

/*

 * Plugin Name:       Wc Product Design

 * Description:       Create the poster accordingly.

 * Version:           1.0.0

 * Author:            Waqas Shah

 * Developed By:      Waqas Shah

 * Author URI:        www.waqasshahh.com  

 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt

 * Domain Path:       /languages

 * Text Domain:       ak_prodcut_design

 *

 * @package wc-product-design  

*/  



// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {

    exit;

}



if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {



    function akpd_admin_notice() {



        

        // Deactivate the plugin

        deactivate_plugins(__FILE__);



        $akpd_woo_check = '<div id="message" class="error">

            <p><strong>Hide Price and Add to Cart Button plugin is inactive.</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> must be active for this plugin to work. Please install &amp; activate WooCommerce »</p></div>';

        echo wp_kses($akpd_woo_check);



    }

    add_action('admin_notices', 'akpd_admin_notice');

}



if (!class_exists('Ak_Wc_Product_Design_Main') ) {



    class Ak_Wc_Product_Design_Main {



        public function __construct() {  



            $this->akpd_global_constants_vars();

            

            add_action('wp_loaded', array( $this, 'afwhp_init' ));

            add_action( 'init', array($this, 'akpd_custom_post_type' ));

            add_action('add_meta_boxes', array( $this, 'ak_wc_product_metabox' ));

            //add_action('wp_ajax_ka_gw_delete_pic_of_gift_wrapper', array($this , "ka_gw_delete_pic_of_gift_wrapper"));

            //add_action('wp_ajax_wc_add_field_on_current_post', array($this , "wc_add_field_on_current_post"));

            //add_action('wp_ajax_ak_posters_to_show', array($this , "ak_posters_to_show"));

            //add_action('wp_ajax_nopriv_ak_posters_to_show', array($this,'ak_posters_to_show'));

        



            add_action( 'admin_enqueue_scripts', array( $this, 'akpd_admin_scripts' ) );

            add_action('wp_ajax_ak_frame_to_show', array($this , "ak_frame_to_show"));



            if (is_admin() ) {

                include_once AKPD_PLUGIN_DIR . 'admin/class-wc-product-design-admin.php';

            } else {

                include_once AKPD_PLUGIN_DIR . 'front/class-wc-prodcut-design-front.php';

            }



            



        }

        public function akpd_admin_scripts() {

            wp_enqueue_style( 'ka_gw_upload_files_sty', 'https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap', false, '1.0', false );

            wp_enqueue_style( 'akpd-mainc1', plugins_url( '/ak-wc-main-styling.css', __FILE__ ), false, '1.0' );

            wp_enqueue_style( 'ak_product_font_aw_main', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, '1.0', false );

        }


        public function ak_posters_to_show()

        {

            
            if(isset($_POST['post_id'])){

                $current_filed_id = sanitize_text_field($_POST['post_id']);

                ob_start();

                include AKPD_PLUGIN_DIR . 'front/ajax/selected-image-response.php'; 

                $final_data             = ob_get_clean();



                wp_send_json(

                    array('updated_file' =>  $final_data ),

                );

            }

            

        }



        public function ak_frame_to_show(){





        }



        public function wc_add_field_on_current_post(){

            if ( isset( $_POST['current_post_id'] ) && 'add_filed' == sanitize_text_field( $_POST['add_or_delete'] ) ) {



                $main_post_id        = sanitize_text_field( $_POST['current_post_id'] );



                $post_type_aurguments   = array(

                    'post_type'     => 'depend_on_main_post',

                );



                $new_post_id            = wp_insert_post( $post_type_aurguments );

                $old_data               = ( array ) get_post_meta( $main_post_id, 'field_ids_array', true );

                $old_data[$new_post_id] = $new_post_id;



                update_post_meta( $main_post_id, 'field_ids_array',  $old_data);



                ob_start();



                include AKPD_PLUGIN_DIR . 'includes/metaboxes/class_wc_ak_first_metabox_setting.php'; 



                $final_data             = ob_get_clean();



                wp_send_json(

                    array('updated_file' =>  $final_data ),

                );

            }





            if ( isset( $_POST['current_post_id'] ) && isset( $_POST['delete_post_id'] ) && 'delete_field' == sanitize_text_field( $_POST['add_or_delete'] ) ) {



                $main_post_id        = sanitize_text_field( $_POST['current_post_id'] );

                $delete_post_id        = sanitize_text_field( $_POST['delete_post_id'] );



                $old_data               = ( array ) get_post_meta( $main_post_id, 'field_ids_array', true );

                unset( $old_data[$delete_post_id] );

                wp_delete_post( $delete_post_id );

                update_post_meta( $main_post_id, 'field_ids_array',  $old_data);



                ob_start();



                include AKPD_PLUGIN_DIR . 'includes/metaboxes/class_wc_ak_first_metabox_setting.php'; 



                $final_data             = ob_get_clean();



                wp_send_json(

                    array('updated_file' =>  $final_data ),

                );

            }



            if ( isset( $_POST['current_post_id'] ) && 'add_option' == sanitize_text_field( $_POST['add_or_delete'] ) && isset($_POST['current_filed_id'] ) ) {



                $main_post_id        = sanitize_text_field( $_POST['current_post_id'] );

                $current_filed_id    = sanitize_text_field( $_POST['current_filed_id'] );



                $post_type_aurguments   = array(

                    'post_type'     => 'post_for_images',

                );



                $new_post_id            = wp_insert_post( $post_type_aurguments );

                $old_data               = ( array ) get_post_meta( $current_filed_id, 'option_added_post_ids_array', true );

                $old_data[$new_post_id] = $new_post_id;



                update_post_meta( $current_filed_id, 'option_added_post_ids_array',  $old_data);



                ob_start();



                include AKPD_PLUGIN_DIR . 'includes/metaboxes/class_wc_ak_first_metabox_setting.php'; 



                $final_data             = ob_get_clean();



                wp_send_json(

                    array('updated_file' =>  $final_data ),

                );

            }



             if ( isset( $_POST['current_post_id'] ) && isset( $_POST['current_filed_id'] ) && 'delete_option' == sanitize_text_field( $_POST['add_or_delete'] )  && isset($_POST['remove_option_id'] ) ) {





                $main_post_id        = sanitize_text_field( $_POST['current_post_id'] );

                $current_filed_id        = sanitize_text_field( $_POST['current_filed_id'] );

                $remove_option_id        = sanitize_text_field( $_POST['remove_option_id'] );



                $old_data               = ( array ) get_post_meta( $current_filed_id, 'option_added_post_ids_array', true );



                unset( $old_data[$remove_option_id] );

                wp_delete_post( $remove_option_id );

                update_post_meta( $current_filed_id, 'option_added_post_ids_array',  $old_data);

                ob_start();



                include AKPD_PLUGIN_DIR . 'includes/metaboxes/class_wc_ak_first_metabox_setting.php'; 



                $final_data             = ob_get_clean();



                wp_send_json(

                    array('updated_file' =>  $final_data ),

                );

            }





        }



        public function ka_gw_delete_pic_of_gift_wrapper() {

            if (isset($_POST['rule_id']) && !empty($_POST['index_id']) ) {

                $rule_id = sanitize_text_field($_POST['rule_id']);

                 $index_id = sanitize_text_field($_POST['index_id']);

                $image = (array) get_post_meta( $rule_id, 'afwcbm_image_upload', true );

                unset($image[$index_id]);

                update_post_meta( $rule_id, 'afwcbm_image_upload', $image );

            }

        } 



        public function ka_gw_delete_pic_of_frame() {

            if (isset($_POST['rule_id']) && !empty($_POST['index_id']) ) {

                $rule_id = sanitize_text_field($_POST['rule_id']);

                 $index_id = sanitize_text_field($_POST['index_id']);

                $image = (array) get_post_meta( $rule_id, 'afwcbm_frame_upload', true );

                unset($image[$index_id]);

                update_post_meta( $rule_id, 'afwcbm_frame_upload', $image );

                }

        } 





        public function akpd_global_constants_vars() {



            if (!defined('AKPD_URL') ) {

                define('AKPD_URL', plugin_dir_url(__FILE__));

            }



            if (!defined('AKPD_BASENAME') ) {

                define('AKPD_BASENAME', plugin_basename(__FILE__));

            }



            if (! defined('AKPD_PLUGIN_DIR') ) {

                define('AKPD_PLUGIN_DIR', plugin_dir_path(__FILE__));

            }

        }



        public function afwhp_init() {

            if (function_exists('load_plugin_textdomain') ) {

                load_plugin_textdomain('ak_prodcut_design', false, dirname(plugin_basename(__FILE__)) . '/languages/');

            }

        }



        public function akpd_custom_post_type() {



            $labels = array(

                'name'                => 'Product Design',

                'singular_name'       => 'Product Design',

                'add_new'             => 'Add New Product',

                'add_new_item'        => 'Add New Product', 'ak_prodcut_design',

                'edit_item'           => 'Edit Product',

                'new_item'            => 'New Product',

                'view_item'           => 'View Product',

                'search_items'        => 'Search Product',

                'exclude_from_search' => true,

                'not_found'           => 'No Product found',

                'not_found_in_trash'  => 'No Product found in trash',

                'parent_item_colon'   => '',

                'all_items'           => 'All Products',

                'menu_name'           => 'Product Design',

            );



            $args = array(

                'labels' => $labels,

                'menu_icon'  => '',

                'public' => false,

                'publicly_queryable' => true,

                'show_ui' => true,

                'show_in_menu' => false,

                'query_var' => true,

                'rewrite' => true,

                'capability_type' => 'post', 

                'has_archive' => true,

                'hierarchical' => false,

                'menu_position' => 40,

                'rewrite' => array('slug' => 'ak_wc_prodcut', 'with_front'=>false ),

                'supports' => array('title', 'page-attributes', 'thumbnail')

            );



            register_post_type( 'ak_wc_prodcut', $args );



             $labels = array(

                'name'                => '',

                'singular_name'       => '',

                'add_new'             => '',

                'add_new_item'        => 'Add New Product', 'ak_prodcut_design',

                'edit_item'           => 'Edit Product',

                'new_item'            => 'New Product',

                'view_item'           => 'View Product',

                'search_items'        => 'Search Product',

                'exclude_from_search' => true,

                'not_found'           => 'No Product found',

                'not_found_in_trash'  => 'No Product found in trash',

                'parent_item_colon'   => '',

                'all_items'           => 'All Products',

                'menu_name'           => 'Product Design',

            );



            $args = array(

                'labels' => $labels,

                'menu_icon'  => '',

                'public' => false,

                'publicly_queryable' => true,

                'show_ui' => true,

                'show_in_menu' => false,

                'query_var' => true,

                'rewrite' => true,

                'capability_type' => 'post', 

                'has_archive' => true,

                'hierarchical' => false,

                'menu_position' => 40,

                'rewrite' => array('slug' => 'depend_on_main_post', 'with_front'=>false ),

                'supports' => array('title', 'page-attributes', 'thumbnail')

            );



            register_post_type( 'depend_on_main_post', $args );



            $args = array(

                'labels' => $labels,

                'menu_icon'  => '',

                'public' => false,

                'publicly_queryable' => true,

                'show_ui' => true,

                'show_in_menu' => false,

                'query_var' => true,

                'rewrite' => true,

                'capability_stype' => 'post', 

                'has_archive' => true,

                'hierarchical' => false,

                'menu_position' => 40,

                'rewrite' => array('slug' => 'post_for_images', 'with_front'=>false ),

                'supports' => array('title', 'page-attributes', 'thumbnail')

            );



            register_post_type( 'post_for_images', $args );

        }

        public function ak_wc_product_metabox(){

            add_meta_box(

                'ak_wc_product_design',

                esc_html__('Product Design', 'ak_prodcut_design'),

                array( $this , 'ak_wc_product_metabox_callback' ),

                'ak_wc_prodcut'

            );

            

        }

        public function ak_wc_product_metabox_callback(){

            global $post;

            $main_post_id = $post->ID;

            ?>

            <div class="ak-wc-meta-whole-data">

            <?php

                include AKPD_PLUGIN_DIR . 'includes/metaboxes/class_wc_ak_first_metabox_setting.php'; 

            ?>

            <div>

            <?php



        }



        

    }



    new Ak_Wc_Product_Design_Main();



}


function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );