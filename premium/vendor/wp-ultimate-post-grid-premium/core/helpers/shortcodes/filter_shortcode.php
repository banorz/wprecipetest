<?php

class WPUPG_Filter_Shortcode {

    public function __construct()
    {
        add_shortcode( 'wpupg-filter', array( $this, 'shortcode' ) );
    }

    public function shortcode( $options )
    {
        $output = '';

        $slug = strtolower( trim( $options['id'] ) );

        if( $slug ) {
            unset( $options['id'] );
            $post = get_page_by_path( $slug, OBJECT, WPUPG_POST_TYPE );

            if( !is_null( $post ) ) {
                $grid = WPUPG_Grid_Manager::get( $post );

                // Check if we need to pre filter
                $pre_filter = array();
                if( count( $options ) > 0 && WPUltimatePostGrid::is_premium_active() ) {
                    foreach( $options as $taxonomy => $terms ) {
                        if( taxonomy_exists( $taxonomy ) ) {
                            $pre_filter[$taxonomy] = explode(';', str_replace(',', ';', $terms));
                        }
                    }
                }

                $filter_type = $grid->filter_type();

                $filter = '';
                if( $filter_type == 'isotope' || $grid->filter_type() == 'text_isotope' ) {
                    $filter_style = $grid->filter_style();
                    $filter_style = $filter_style['isotope'];

                    $style_data = ' data-filter-type="' . $filter_type . '"';
                    $style_data .= ' data-margin-vertical="' . $filter_style['margin_vertical'] . '"';
                    $style_data .= ' data-margin-horizontal="' . $filter_style['margin_horizontal'] . '"';
                    $style_data .= ' data-padding-vertical="' . $filter_style['padding_vertical'] . '"';
                    $style_data .= ' data-padding-horizontal="' . $filter_style['padding_horizontal'] . '"';
                    $style_data .= ' data-border-width="' . $filter_style['border_width'] . '"';

                    $style_data .= ' data-background-color="' . $filter_style['background_color'] . '"';
                    $style_data .= ' data-text-color="' . $filter_style['text_color'] . '"';
                    $style_data .= ' data-border-color="' . $filter_style['border_color'] . '"';

                    $style_data .= ' data-active-background-color="' . $filter_style['background_active_color'] . '"';
                    $style_data .= ' data-active-text-color="' . $filter_style['text_active_color'] . '"';
                    $style_data .= ' data-active-border-color="' . $filter_style['border_active_color'] . '"';
                    
                    $style_data .= ' data-hover-background-color="' . $filter_style['background_hover_color'] . '"';
                    $style_data .= ' data-hover-text-color="' . $filter_style['text_hover_color'] . '"';
                    $style_data .= ' data-hover-border-color="' . $filter_style['border_hover_color'] . '"';

                    $multiselect = $grid->filter_multiselect() ? 'true' : 'false';
                    $inverse = $grid->filter_inverse() ? 'true' : 'false';
                    $filter .= '<div id="wpupg-grid-' . esc_attr( $slug ) . '-filter" class="wpupg-filter wpupg-filter-' . $filter_type . '" style="text-align: ' . $filter_style['alignment'] . ';" data-grid="' . esc_attr( $slug ) . '" data-type="' . $filter_type . '" data-multiselect="' . $multiselect . '" data-multiselect-type="' . $grid->filter_multiselect_type() . '" data-inverse="' . $inverse . '"' . $style_data . '>';
                    $filter .= $grid->filter();
                    $filter .= '</div>';
                }

                $output = apply_filters( 'wpupg_filter_shortcode', $filter, $grid );

                wp_localize_script( 'wpupg_grid', 'wpupg_filter_' . $grid->ID(), array(
                    'pre_filter' => $pre_filter,
                ));
            }
        }

        return $output;
    }
}