<?php

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {

    exit; 

}



if ( !class_exists( 'Akpd_Product_Design_Addon_Front' ) ) {



  class Akpd_Product_Design_Addon_Front {



    public function __construct() {


        add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'akpd_show_on_product_page' ) );
		add_action('woocommerce_product_thumbnails',array($this,'akpd_show_on_product_page_images'));
		
		add_action( 'woocommerce_add_order_item_meta',  array( $this,'add_order_item_meta' ), 10, 2);
	 	add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 25, 2 );
		add_filter( 'woocommerce_get_item_data', array( $this,'get_item_data' ), 25, 2 );
       	add_action( 'woocommerce_thankyou', array($this,'add_content_thankyou_func') ,10, 1);
 

		add_action( 'wp_enqueue_scripts', array( $this, 'akpd_front_scripts' ) );


    }



public function akpd_front_scripts(){

        wp_enqueue_style( 'akpd-frontc1', plugins_url( '/assest/css/akpd-front.css', __FILE__ ), false, '1.0' );
        wp_enqueue_script( 'ak_front_js', plugins_url( '/assest/js/akpd-front.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script('front_jquery',"https://code.jquery.com/jquery-3.6.0.min.js");
        wp_enqueue_script('pdf_down_js',"https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js");


        $akpd_front_data = array(

            'admin_url'  => admin_url('admin-ajax.php'),

            'nonce' => wp_create_nonce('akpd-ajax-nonce'),



        );

        wp_localize_script( 'ak_front_js', 'akpd_front_php_vars', $akpd_front_data );

    }

function add_content_thankyou_func($order_id) {
	if ( ! $order_id )
        return;

    // Allow code execution only once 
  

        // Get an instance of the WC_Order object
        $order = wc_get_order( $order_id );

        // Get the order key
        $order_key = $order->get_order_key();

        // Get the order number
        $order_key = $order->get_order_number();
        // Loop through order items
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
            $product_id = $product->get_id();

            $product_name = $item->get_name();
			
			$image_title= $item->get_meta('Image Title');
			$image_sub_title= $item->get_meta('Image Sub Title');
			$ak_frames= $item->get_meta('Ak Frames');
			$ak_colors= $item->get_meta('Ak Color');
			$image_url= $item->get_meta('Image Url');
			$frame_url= $item->get_meta('Frame Url');
			$heading_size= $item->get_meta('Heading Size');
			$heading_color= $item->get_meta('Heading Color');
			$sub_color= $item->get_meta('Sub Color');
			$sub_size= $item->get_meta('Sub Size');
        }


      
    
 ?>
<div class="order_print_block">
 	<button id="printButton"> Print Purchased Image</button>
	<div id="printModal" class="modal">

  		<div class="modal-content">
			
   		     <span class="close">&times;</span>
			<div id="htmlContent" style="text-align:center;margin-bottom:20px">
				<div style="background:url(<?php echo $frame_url; ?>);background-repeat:no-repeat;background-size:100% 100%;padding:30px">
				<div class="container_image" style="background-color:<?php echo $ak_colors; ?>;width: 90%; margin: 20px auto; height: 600px;">
					<img src="<?php echo $image_url; ?>" style="    height: 600px; margin: auto;">
				</div>
				<h2 style="color:<?php echo $heading_color; ?>;font-size:<?php echo $heading_size; ?>;margin-bottom: 0px;padding-top: 20px;">
					<?php echo $image_title; ?>
				</h2>
				<p style="color:<?php echo $sub_color; ?>;font-size:<?php echo $sub_size; ?>">
					<?php echo $image_sub_title; ?>
				</p>
				</div>
			</div>
			
			<div id="editor"></div>
			<center>
			  <p>
				<button id="generatePDF" style="display:none">Download PDF</button>
				<button id="printPDF">Print PDF</button>

			  </p>
			</center>
		</div>
	</div>
</div>
<?php
}	  
	  
public function add_order_item_meta ( $item_id, $values ) {

	if ( isset( $values['custom_data'] ) ) {

		$custom_data  = $values['custom_data'];
		wc_add_order_item_meta( $item_id, 'Image Title', $custom_data['image_title'] );
		wc_add_order_item_meta( $item_id, 'Image Sub Title', $custom_data['image_sub_title'] );
		wc_add_order_item_meta( $item_id, 'AK Frames', $custom_data['ak_frames'] );
		wc_add_order_item_meta( $item_id, 'Ak Color', $custom_data['ak_colors'] );
		wc_add_order_item_meta( $item_id, 'Image Url', $custom_data['image_url'] );
		wc_add_order_item_meta( $item_id, 'Frame Url', $custom_data['frame_url'] );
		wc_add_order_item_meta( $item_id, 'Heading Size', $custom_data['heading_size'] );
		wc_add_order_item_meta( $item_id, 'Heading Color', $custom_data['heading_color'] );
		wc_add_order_item_meta( $item_id, 'Sub Size', $custom_data['sub_size'] );
		wc_add_order_item_meta( $item_id, 'Sub Color', $custom_data['sub_color'] );



	}
}

public function add_cart_item_data( $cart_item_meta, $product_id ) {


		$custom_data  = array() ;
		$custom_data[ 'image_title' ]    = isset( $_POST['product_title'] ) ?  sanitize_text_field ( $_POST['product_title'] ) : "" ;
		$custom_data[ 'image_sub_title' ] = isset( $_POST['product_sub_title'] ) ? sanitize_text_field ( $_POST['product_sub_title'] ): "" ;
		$custom_data[ 'ak_frames' ] = isset( $_POST['ak_frames'] ) ? sanitize_text_field ( $_POST['ak_frames'] ): "" ;
		$custom_data[ 'ak_colors' ] = isset( $_POST['ak_colors'] ) ? sanitize_text_field ( $_POST['ak_colors'] ): "" ;
		$custom_data[ 'image_url' ] = isset( $_POST['image_url'] ) ? sanitize_text_field ( $_POST['image_url'] ): "" ;
		$custom_data[ 'frame_url' ] = isset( $_POST['frame_url'] ) ? sanitize_text_field ( $_POST['frame_url'] ): "" ;
		$custom_data[ 'heading_size' ] = isset( $_POST['heading_size'] ) ? sanitize_text_field ( $_POST['heading_size'] ): "" ;
		$custom_data[ 'heading_color' ] = isset( $_POST['heading_color'] ) ? sanitize_text_field ( $_POST['heading_color'] ): "" ;
		$custom_data[ 'sub_size' ] = isset( $_POST['sub_size'] ) ? sanitize_text_field ( $_POST['sub_size'] ): "" ;
		$custom_data[ 'sub_color' ] = isset( $_POST['sub_color'] ) ? sanitize_text_field ( $_POST['sub_color'] ): "" ;


		$cart_item_meta['custom_data']     = $custom_data ;
	
	
	return $cart_item_meta;
}
public function get_item_data ( $other_data, $cart_item ) {

	if ( isset( $cart_item[ 'custom_data' ] ) ) {
		$custom_data  = $cart_item['custom_data'];
		$other_data=array(array( 'name' => 'Product Title',
            'display'  => $custom_data['image_title'] ),
            array( 'name' => 'Product Sub Title',
            'display'  => $custom_data['image_sub_title'] ),
            array( 'name' => 'Background Color',
                     'display'  => $custom_data['ak_colors'] ),
                     array( 'name' => 'Frame',
                     'display'  => $custom_data['ak_frames'] )
        );
	}
	
	return $other_data;
}

public function akpd_show_on_product_page_images(){
		  global $product;
		 $ak_product_id = $product->get_id();

      $get_post_data = get_post($ak_product_id);

      $rule_id = $get_post_data->post_parent;
	  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $ak_product_id ), 'single-post-thumbnail' );
	  $main_heading_color = get_post_meta($rule_id, 'main_heading_color', true);
      $main_heading_size = get_post_meta($rule_id, 'main_heading_size', true);
      $sub_heading_size = get_post_meta($rule_id, 'sub_heading_size', true);
      $sub_heading_color = get_post_meta($rule_id, 'sub_heading_color', true);
		?>
		<div class="product_single_featured_image" id="product_single_featured_image">
			<img src="<?php echo $image[0];?>" />
			<div class="product_single_image_headings">
				<h2 id="product_single_image_title" style="color:<?php echo $main_heading_color; ?>;font-size:<?php echo $main_heading_size;  ?>px">
				Image Title
			</h2>
			<p id="product_single_image_title_sub" style="color:<?php echo $sub_heading_color; ?>;font-size:<?php echo $sub_heading_size;  ?>px">
				Image Sub Title
			</p>
			</div>
			
		</div>
	<?php
		
	}

    public function akpd_show_on_product_page(){

      global $product;
      $ak_product_id = $product->get_id();

      $get_post_data = get_post($ak_product_id);

      $rule_id = $get_post_data->post_parent;

      $old_data_front = ( array ) get_post_meta( $rule_id, 'field_ids_array', true );

      $fields_ids_array = array_filter( $old_data_front );

      $ak_enable_design_background_color = get_post_meta($rule_id, 'ak_enable_design_background_color', true);
		
    
	  $colors_list = get_post_meta($rule_id, 'colors_list', true);
      $frames_list = get_post_meta($rule_id, 'frames_list', true);
      $designs_list = get_post_meta($rule_id, 'designs_list', true);
		?>
	<div class="product_data_front"> 
		<h3 class="heading_front images_heading">
			   Select image of the Art
		   </h3>
       <div class="product_images_front">
		   
       <?php
       foreach($designs_list as $design){
		   ?>
		   <div class="product_image_single">
			     <img class="design-product-single" src="<?php echo $design["image"]  ?>" width="200px" height="200px" />

		   </div>
		<?php
	   }	
		?>
	  </div>
		<input name="image_url" id="image_url" hidden/>
		<input name="frame_url" id="frame_url" hidden/>
		<input name="heading_size" id="heading_size" hidden/>
		<input name="heading_color" id="heading_color" hidden/>
		<input name="sub_size" id="sub_size" hidden/>
		<input name="sub_color" id="sub_color" hidden/>
	<div class="product_sub_data">
			
	 <div id="product_title_front" >

        <label class="heading_front">Title</label>

        <input type="text" class="input_product" placeholder="Enter Title Here" name="product_title" id="product_title" value="">

      </div>

    <div id="product_sub_title_front">

        <label class="heading_front">Sub Title</label>

        <input type="text" class="input_product" placeholder="Enter Sub Title Here" name="product_sub_title" id="product_sub_title" value="">

      </div>

      

      <div class="ak_color_select">

      <label class="heading_front"><?php echo esc_html__('Select Background Color ', 'ak_prodcut_design '); ?></label>

      <select name="ak_colors" id="ak_colors" value="Select Color">

           <option value="white">Select Color</option> 

          <?php

              foreach($colors_list as $ak_separated_color){

          ?>

          <option style="background-color:<?php echo $ak_separated_color?> ;" value="<?php echo $ak_separated_color?>" >        </option>

          <?php

              }

          ?>

      </select>

    </div>
  <label class="heading_front"> Select Frame</label>

			
			    <select name="ak_frames" id="ak_frames" value="Select Frame">
				
          		<option value="" data-frame="">Select Frame</option> 

          <?php
			
              foreach($frames_list as $frame){

          ?>

          <option value="<?php echo $frame["title"]?>" data-frame="<?php echo $frame["image"]; ?>" > <span><?php echo $frame["title"]?> </span><span style="float:right;color:green">(<span>$</span><?php echo $frame["price"]?> )</span>   </option>

          <?php

              }

          ?>

      </select>
     
    
		</div>
	</div>
  
<?php
    }

  }



  new Akpd_Product_Design_Addon_Front();



}







