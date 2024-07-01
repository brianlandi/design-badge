<?php
add_action( 'the_content', 'db_display_badge' );

function db_display_badge( $content ) {
	$options = get_option( 'db_settings' );
	$design_tool = $options['db_select_field_design_tool'];
	$position_on_page = $options['db_range_position_on_page'];
	$custom_image = $options['db_image_field'];
	$custom_image_bg_color = $options['db_custom_image_background_color'];
	$global_link = $options['db_text_field_design_link'];


	if ( is_page() ) {
		$design_link = get_post_meta( get_the_ID(), '_db_meta_key_design_link', true );
		$display_badge = get_post_meta( get_the_ID(), '_db_meta_key_display_badge', true );

		if ( $design_tool === 'custom' && ! empty( $custom_image ) ) {
			if ( $custom_image_bg_color ) {
				$bg_style = 'background-image: url(' . $custom_image . '); background-color: ' . $custom_image_bg_color . '; border: 1px solid gray; border-right: none;';
			} else {
				$bg_style = 'background-image: url(' . $custom_image . ');';
			}
		}

		if ( $global_link && ! $design_link ) {
			$design_link = $global_link;
		}

		if ( ! empty( $design_link ) && $display_badge ) {
			// Badge Markup
			$badge_html = '<div class="design-badge design-badge--' . $design_tool . '" style="top: ' . $position_on_page . '%; ' . $bg_style . ';">';
			$badge_html .= '<a href="' . esc_url( $design_link ) . '" target="_blank"></a>';
			$badge_html .= '</div>';
			// Append to content
			$content .= $badge_html;
		}
	}
	return $content;
}