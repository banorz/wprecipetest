<?php
// Grid should never be null. Construct just allows easy access to WPUPG_Grid functions in IDE.
if( is_null( $grid ) ) $grid = new WPUPG_Grid(0);

$filter_style = $grid->filter_style();
$isotope_style = $filter_style['isotope'];
?>

<table id="wpupg_form_isotope_filter_style" class="wpupg_form">
    <tr>
        <td>&nbsp;</td>
        <td><span class="wpupg_label_prefix"><?php _e( 'Background Color', 'wp-ultimate-post-grid' ); ?></span></td>
        <td><span class="wpupg_label_prefix"><?php _e( 'Text Color', 'wp-ultimate-post-grid' ); ?></span></td>
        <td><span class="wpupg_label_prefix"><?php _e( 'Border Color', 'wp-ultimate-post-grid' ); ?></span></td>
    </tr>
    <tr>
        <td><span class="wpupg_label_prefix"><?php _e( 'Default', 'wp-ultimate-post-grid' ); ?></span></td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_background_color" name="wpupg_isotope_filter_style_background_color" value="<?php echo $isotope_style['background_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_text_color" name="wpupg_isotope_filter_style_text_color" value="<?php echo $isotope_style['text_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_border_color" name="wpupg_isotope_filter_style_border_color" value="<?php echo $isotope_style['border_color']; ?>">
        </td>
    </tr>
    <tr>
        <td><span class="wpupg_label_prefix"><?php _e( 'Active', 'wp-ultimate-post-grid' ); ?></span></td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_background_active_color" name="wpupg_isotope_filter_style_background_active_color" value="<?php echo $isotope_style['background_active_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_text_active_color" name="wpupg_isotope_filter_style_text_active_color" value="<?php echo $isotope_style['text_active_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_border_active_color" name="wpupg_isotope_filter_style_border_active_color" value="<?php echo $isotope_style['border_active_color']; ?>">
        </td>
    </tr>
    <tr>
        <td><span class="wpupg_label_prefix"><?php _e( 'Hover', 'wp-ultimate-post-grid' ); ?></span></td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_background_hover_color" name="wpupg_isotope_filter_style_background_hover_color" value="<?php echo $isotope_style['background_hover_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_text_hover_color" name="wpupg_isotope_filter_style_text_hover_color" value="<?php echo $isotope_style['text_hover_color']; ?>">
        </td>
        <td>
            <input type="color" id="wpupg_isotope_filter_style_border_hover_color" name="wpupg_isotope_filter_style_border_hover_color" value="<?php echo $isotope_style['border_hover_color']; ?>">
        </td>
    </tr>
</table>
<table id="wpupg_form_isotope_filter_style_2" class="wpupg_form">
    <tr class="wpupg_divider">
        <td><span class="wpupg_label_prefix"><?php _e( 'Border', 'wp-ultimate-post-grid' ); ?></span><label for="wpupg_isotope_filter_style_border_width"><?php _e( 'Width', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <div id="wpupg_isotope_filter_style_border_width_slider"></div>
        </td>
        <td><input type="text" name="wpupg_isotope_filter_style_border_width" id="wpupg_isotope_filter_style_border_width" value="<?php echo $isotope_style['border_width']; ?>" />px</td>
    </tr>
    <tr class="wpupg_divider">
        <td><span class="wpupg_label_prefix"><?php _e( 'Margin', 'wp-ultimate-post-grid' ); ?></span><label for="wpupg_isotope_filter_style_margin_vertical"><?php _e( 'Vertical', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <div id="wpupg_isotope_filter_style_margin_vertical_slider"></div>
        </td>
        <td><input type="text" name="wpupg_isotope_filter_style_margin_vertical" id="wpupg_isotope_filter_style_margin_vertical" value="<?php echo $isotope_style['margin_vertical']; ?>" />px</td>
    </tr>
    <tr>
        <td><label for="wpupg_isotope_filter_style_margin_horizontal"><?php _e( 'Horizontal', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <div id="wpupg_isotope_filter_style_margin_horizontal_slider"></div>
        </td>
        <td><input type="text" name="wpupg_isotope_filter_style_margin_horizontal" id="wpupg_isotope_filter_style_margin_horizontal" value="<?php echo $isotope_style['margin_horizontal']; ?>" />px</td>
    </tr>
    <tr>
        <td><span class="wpupg_label_prefix"><?php _e( 'Padding', 'wp-ultimate-post-grid' ); ?></span><label for="wpupg_isotope_filter_style_padding_vertical"><?php _e( 'Vertical', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <div id="wpupg_isotope_filter_style_padding_vertical_slider"></div>
        </td>
        <td><input type="text" name="wpupg_isotope_filter_style_padding_vertical" id="wpupg_isotope_filter_style_padding_vertical" value="<?php echo $isotope_style['padding_vertical']; ?>" />px</td>
    </tr>
    <tr>
        <td><label for="wpupg_isotope_filter_style_padding_horizontal"><?php _e( 'Horizontal', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <div id="wpupg_isotope_filter_style_padding_horizontal_slider"></div>
        </td>
        <td><input type="text" name="wpupg_isotope_filter_style_padding_horizontal" id="wpupg_isotope_filter_style_padding_horizontal" value="<?php echo $isotope_style['padding_horizontal']; ?>" />px</td>
    </tr>
    <tr class="wpupg_divider">
        <td><label for="wpupg_isotope_filter_style_alignment"><?php _e( 'Alignment', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_isotope_filter_style_alignment" id="wpupg_isotope_filter_style_alignment" class="wpupg-select2">
                <?php
                $alignment_options = array(
                    'left' => __( 'Left', 'wp-ultimate-post-grid' ),
                    'center' => __( 'Center', 'wp-ultimate-post-grid' ),
                    'right' => __( 'Right', 'wp-ultimate-post-grid' ),
                );

                foreach( $alignment_options as $alignment_option => $alignment_option_name ) {
                    $selected = $alignment_option == $isotope_style['alignment'] ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $alignment_option ) . '"' . $selected . '>' . $alignment_option_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'How to align the filters.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr class="wpupg_divider">
        <td><label for="wpupg_isotope_filter_style_all_button_text"><?php _e( 'Button text', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <input type="text" name="wpupg_isotope_filter_style_all_button_text" id="wpupg_isotope_filter_style_all_button_text" value="<?php echo $isotope_style['all_button_text']; ?>" />
        </td>
        <td><?php _e( 'Text shown on the "All" button.', 'wp-ultimate-post-grid' ); ?> <?php _e( 'Use no text to hide the button.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr>
        <td><label for="wpupg_isotope_filter_style_term_order"><?php _e( 'Term Order', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_isotope_filter_style_term_order" id="wpupg_isotope_filter_style_term_order" class="wpupg-select2">
                <?php
                $term_order_options = array(
                    'alphabetical' => __( 'Alphabetical', 'wp-ultimate-post-grid' ),
                    'reverse_alphabetical' => __( 'Reverse Alphabetical', 'wp-ultimate-post-grid' ),
                    'alphabetical_taxonomies' => __( 'Alphabetical per Taxonomy', 'wp-ultimate-post-grid' ),
                    'reverse_alphabetical_taxonomies' => __( 'Reverse Alphabetical per Taxonomy', 'wp-ultimate-post-grid' ),
                    'alphabetical_taxonomies_grouped' => __( 'Alphabetical per Taxonomy (separate lines)', 'wp-ultimate-post-grid' ),
                    'reverse_alphabetical_taxonomies_grouped' => __( 'Reverse Alphabetical per Taxonomy (separate lines)', 'wp-ultimate-post-grid' ),
                );

                foreach( $term_order_options as $term_order_option => $term_order_option_name ) {
                    $selected = $term_order_option == $isotope_style['term_order'] ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $term_order_option ) . '"' . $selected . '>' . $term_order_option_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'Order of the Isotope term buttons.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
</table>

<div id="wpupg_filter_preview_isotope_filter_style" class="wpupg_filter_preview">
    <div class="wpupg-filter-isotope-term" id="wpupg_isotope_filter_style_all_button_text_preview"><?php _e( 'All', 'wp-ultimate-post-grid' ); ?></div>
    <div class="wpupg-filter-isotope-term"><?php _e( 'A Tag', 'wp-ultimate-post-grid' ); ?></div>
    <div class="wpupg-filter-isotope-term"><?php _e( 'Example', 'wp-ultimate-post-grid' ); ?></div>
    <div class="wpupg-filter-isotope-term active"><?php _e( 'This is Active', 'wp-ultimate-post-grid' ); ?></div>
    <div class="wpupg-filter-isotope-term"><?php _e( 'Why?', 'wp-ultimate-post-grid' ); ?></div>
</div>
