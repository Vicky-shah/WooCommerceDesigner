<?php 
	$old_options_array = (array) get_post_meta( $current_filed_id,'option_added_post_ids_array', true );
	?>
		<select>
	<?php
	foreach ( $old_options_array as $current_option_id):
		if (empty($current_option_id)) {
			continue;
		}
		$color_name = get_post_meta($current_option_id, 'color_name_'.$current_option_id, true);
		$price = get_post_meta($current_option_id, 'price_'.$current_option_id, true);
		$frame = get_post_meta($current_option_id, 'frame_'.$current_option_id, true);
		$image = get_post_meta($current_option_id, 'image_'.$current_option_id, true);
		?>
		<option value="<?php echo $current_option_id; ?>"><?php echo $color_name; ?></option>
		
	<?php endforeach ?>
	</select>

