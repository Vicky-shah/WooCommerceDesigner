<?php

    $ak_enable_design_background_color = get_post_meta($main_post_id, 'ak_enable_design_background_color', true);
	// $args = array( 'post_type' => 'post_for_images');
	// $loop=new WP_Query( $args );
	// var_dump($loop);
	$featured_image = get_post_meta($main_post_id, 'featured_image', true);
	$color_picker = get_post_meta($main_post_id, 'colorPicker', true);

	$main_heading_size = get_post_meta($main_post_id, 'main_heading_size', true);
	$main_heading_color = get_post_meta($main_post_id, 'main_heading_color', true);
	$sub_heading_size = get_post_meta($main_post_id, 'sub_heading_size', true);
	$sub_heading_color = get_post_meta($main_post_id, 'sub_heading_color', true);
	if(get_post_meta($main_post_id, 'colors_list', true)){
	$colorsList = get_post_meta($main_post_id, 'colors_list', true);
	}
	else{
	$colorsList = array();
	}

	if(get_post_meta($main_post_id, 'frames_list', true)){
	$framesList = get_post_meta($main_post_id, 'frames_list', true);
	}
	else{
	$framesList = array();
	}

	if(get_post_meta($main_post_id, 'designs_list', true)){
	$designsList = get_post_meta($main_post_id, 'designs_list', true);
	}
	else{
	$designsList = array();
	}

	if(get_post_meta($main_post_id, 'artworks_list', true)){
	$artworksList = get_post_meta($main_post_id, 'artworks_list', true);
	}
	else{
	$artworksList = array();
	}


?>

<div class="productLayoutSettingsContainer">
	<h3 class="mainHeading">Product Layout Settings</h3>
	<div class="divider"> </div>	

	<div class="prodcutLayoutSettingsSubContainer">
		<h3 class="subHeading">Upload Images</h3>
		<label class="customUploadButton" for="uploadImage">Upload</label>
		<input id="uploadImage" type="file" style="display:none"/>
</div>

<div class="main_artwork" id="productLayoutImageContainer">
	<?php if (count($designsList) > 0){
		$designCount = 0;
       foreach((array)$designsList as $frame )
       {
      $destitle =  $designsList[$designCount]["title"];
       $desprice =  $designsList[$designCount]["price"];
         $desimg =  $designsList[$designCount]["image"];

      ?>
      <div class="design_display_data_div1" >
                <img  src="<?php echo $desimg;?>" />
                <input name="addedDesignArrayIndex" data-design-array-index="<?php echo $designCount;?>" hidden/>
                <input type="text" value="<?php echo $desimg;?>" name="designs_list[<?php echo $designCount;?>][image]" hidden/>
            <div class="input-icons">
                <i class="fa fa-dollar icon"></i> 
                <input class="input-field" type="number"  value="<?php echo $desprice ?>" name="designs_list[<?php echo $designCount;?>][price]"  placeholder="Design Price"> </div>
            <input type="text" value="<?php echo $destitle ?>" name="designs_list[<?php echo $designCount;?>][title]"  placeholder="Design Name">
            </div>
  <?php 
$designCount++;
}
}?>

</div>
	<div class="divider"> </div>	

	<div class="prodcutLayoutSettingsSubContainer">
		<h3 class="subHeading">Upload Frames</h3>
		<label class="customUploadButton" for="uploadFrame">Upload</label>
		<input id="uploadFrame" type="file" style="display:none"/>
	</div>
	
	<div class="main_artwork" id="productLayoutFrameContainer">
	<?php if (count($framesList) > 0){
		$frameCount = 0;
       foreach((array)$framesList as $frame )
       {
      $title =  $framesList[$frameCount]["title"];
       $price =  $framesList[$frameCount]["price"];
         $img =  $framesList[$frameCount]["image"];

      ?>
      <div class="frame_display_data_div1" >
                <img  src="<?php echo $img;?>" />
                <input name="addedFrameArrayIndex" data-frame-array-index="<?php echo $frameCount;?>" hidden/>
                <input type="text" value="<?php echo $img;?>" name="frames_list[<?php echo $frameCount;?>][image]" hidden/>
            <div class="input-icons">
                <i class="fa fa-dollar icon"></i>
                <input class="input-field" type="number" value="<?php echo $price ?>" name="frames_list[<?php echo $frameCount;?>][price]"  placeholder="Frame Price"> </div>
            <input type="text" value="<?php echo $title ?>" name="frames_list[<?php echo $frameCount;?>][title]"  placeholder="Frame Name">
            </div>
  <?php 
$frameCount++;
}
}?>
	<!--<div class="artwork_display_data_div1">
		<img id="featured_image_main" src="<?php echo esc_url($featured_image); ?>">
	<input type="number" name="image_price" id="image_price" placeholder="Image Price">
	<input type="text" name="image_text" id="image_text" placeholder="Image name">
	</div>-->

</div>
	<div class="divider"> </div>	

	<div class="prodcutLayoutSettingsSubContainer">
		<h3 class="subHeading">Background Color</h3>
		<div id="colors-block" style="display:flex;">
		<!--<input type="text" name="product_colors" id="product_colors">	-->
	<?php if (count($colorsList) > 0){
		$colorCount = 0;
       foreach((array)$colorsList as $color )
       {
      $val =  $colorsList[$colorCount];
       	?>

		<input type="color" id="product-color-<?php echo $colorCount; ?>" name="colors_list[<?php echo $colorCount; ?>]" data-id="<?php echo $colorCount; ?>" class="colorpicker-product" value="<?php echo  $val; ?>">
		<?php 
		$colorCount++;
	}
	}
	else{ ?>

<input type="color" id="product-color-0" name="colors_list[0]" data-id="0" class="colorpicker-product">
	<?php }?>
		<!--<input class="colorPickerCodeShow" style=" color : white;  background-color: <?php echo esc_attr($color_picker); ?>" type="text" value="<?php echo esc_attr($color_picker); ?>" disabled="disabled"/>
		<input class="colorPicker" type="color" name="colorPicker" value="<?php echo esc_attr($color_picker); ?>"/>-->
		</div>
		<a id="uploadColor" class="customUploadButton">Upload</a>
	</div>
	<div class="divider"> </div>	

</div>


<div class="productTextSettingsContainer">
<h3 class="mainHeading">Product Text Settings</h3>
<div class="divider"> </div>	
	
	<div class="productTextSettingsSubContainer">
		<div>
			<label>Main Heading Size (Px)</label>
			<input class="inputField" type="number" name="main_heading_size" value="<?php echo esc_attr($main_heading_size); ?>" />

		</div>
		<div>
		<label>Main Heading Color</label>
	
		<div style="display:flex;justify-content: center;">	
		<input type="color" id="main_heading_color" name="main_heading_color" class="colorpicker" value="<?php echo esc_attr($main_heading_color); ?>" >		<!--<input class="colorPickerCodeShow" type="text" value="<?php echo esc_attr($main_heading_color); ?>" style=" color : white;  background-color: <?php echo esc_attr($main_heading_color); ?>" disabled="disabled"/>-->		   
		<!--<input class="colorPicker" type="color" name="main_heading_color" value="<?php echo esc_attr($main_heading_color); ?>"/>-->

	</div>
	
	</div>
	</div>
	<div class="divider"> </div>	

	<div class="productTextSettingsSubContainer">
	<div>
			<label>Sub Heading Size (Px)</label>
			<input class="inputField" type="number" name="sub_heading_size" value="<?php echo esc_attr($sub_heading_size); ?>"/>

		</div>
		<div>
		<label>Sub Heading Color</label>
	
		<div style="display:flex;justify-content: center;">
		<input type="color" id="sub_heading_color" name="sub_heading_color" class="colorpicker" value="<?php echo esc_attr($sub_heading_color); ?>" >
		<!--<input class="colorPickerCodeShow" type="text" value="<?php echo esc_attr($sub_heading_color); ?>" disabled="disabled" style=" color : white;  background-color: <?php echo esc_attr($sub_heading_color); ?>"/>
		<input class="colorPicker" type="color" name="sub_heading_color" value="<?php echo esc_attr($sub_heading_color); ?>"/>-->

	</div>
	
	</div>
	</div>
	<div class="divider"> </div>	

</div>

