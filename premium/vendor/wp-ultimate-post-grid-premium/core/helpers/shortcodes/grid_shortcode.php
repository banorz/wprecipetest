<?php

class WPUPG_Grid_Shortcode {

    public function __construct()
    {
        add_shortcode( 'wpupg-grid', array( $this, 'shortcode' ) );

//        add_filter( 'mce_external_plugins', array( $this, 'tinymce_plugin' ) );
    }

    public function shortcode( $options )
    {
        $output = '';

        $slug = strtolower( trim( $options['id'] ) );

        if( $slug ) {
            unset( $options['id'] );
            $no_output_mode = isset( $options['wpupg_no_output'] ) && $options['wpupg_no_output'] ? true : false;
            unset( $options['wpupg_no_output'] );

            $post = get_page_by_path( $slug, OBJECT, WPUPG_POST_TYPE );

            if( !is_null( $post ) ) {
                $grid = WPUPG_Grid_Manager::get( $post );

                // Check if we need to filter the grid dynamically
                $dynamic_rules = array();
                if( count( $options ) > 0 && WPUltimatePostGrid::is_premium_active() ) {

                    // Term Grid.
                    if ( $grid->type() == 'terms' ) {
                        if( isset( $options['term_id'] ) ) {
                            $term_ids = str_replace( ',', ';', $options['term_id'] );
                            $term_ids = str_replace( 'current_term', get_queried_object_id(), $term_ids );

                            $dynamic_rules = array(
                                'values' => explode( ';', $term_ids ),
                                'type' => 'restrict',
                            );
                            unset( $options['term_id'] );
                        }

                        if( isset( $options['exclude_term_id'] ) ) {
                            $term_ids = str_replace( ',', ';', $options['exclude_term_id'] );
                            $term_ids = str_replace( 'current_term', get_queried_object_id(), $term_ids );

                            $dynamic_rules = array(
                                'values' => explode( ';', $term_ids ),
                                'type' => 'exclude',
                            );
                            unset( $options['exclude_term_id'] );
                        }
                    } else {
                        // Post Grid.
                        if( isset( $options['post_id'] ) ) {
                            $post_ids = str_replace( ',', ';', $options['post_id'] );
                            $post_ids = str_replace( 'current_post', get_the_ID(), $post_ids );

                            $dynamic_rules[] = array(
                                'post_type' => 'wpupg_general',
                                'taxonomy' => 'id',
                                'values' => explode( ';', $post_ids ),
                                'type' => 'restrict',
                            );
                            unset( $options['post_id'] );
                        }

                        if( isset( $options['exclude_post_id'] ) ) {
                            $post_ids = str_replace( ',', ';', $options['exclude_post_id'] );
                            $post_ids = str_replace( 'current_post', get_the_ID(), $post_ids );

                            $dynamic_rules[] = array(
                                'post_type' => 'wpupg_general',
                                'taxonomy' => 'id',
                                'values' => explode( ';', $post_ids ),
                                'type' => 'exclude',
                            );
                            unset( $options['exclude_post_id'] );
                        }

                        if( isset( $options['author'] ) ) {
                            $author_ids = str_replace( ',', ';', $options['author'] );
                            $author_ids = str_replace( 'current_user', get_current_user_id(), $author_ids );

                            $dynamic_rules[] = array(
                                'post_type' => 'wpupg_general',
                                'taxonomy' => 'author',
                                'values' => explode( ';', $author_ids ),
                                'type' => 'restrict',
                            );
                            unset( $options['author'] );
                        }

                        if( isset( $options['exclude_author'] ) ) {
                            $author_ids = str_replace( ',', ';', $options['exclude_author'] );
                            $author_ids = str_replace( 'current_user', get_current_user_id(), $author_ids );

                            $dynamic_rules[] = array(
                                'post_type' => 'wpupg_general',
                                'taxonomy' => 'author',
                                'values' => explode( ';', $author_ids ),
                                'type' => 'exclude',
                            );
                            unset( $options['exclude_author'] );
                        }

                        if( isset( $options['date'] ) ) {
                            $date_condition = str_replace( '_today', '', $options['date'] );
                            $date_condition = in_array( $date_condition, array( 'before', 'after' ) ) ? $date_condition : 'is';

                            $dynamic_rules[] = array(
                                'post_type' => 'wpupg_general',
                                'taxonomy' => 'date',
                                'values' => array( $date_condition, date( 'Y-m-d' ) ),
                                'type' => 'restrict',
                            );
                            unset( $options['date'] );
                        }

                        foreach( $options as $taxonomy => $terms ) {
                            if( taxonomy_exists( $taxonomy ) ) {
                                $dynamic_rules[] = array(
                                    'post_type' => 'wpupg_dynamic',
                                    'taxonomy' => $taxonomy,
                                    'values' => explode( ';', str_replace( ',', ';', $terms ) ),
                                    'type' => 'restrict',
                                );
                            } elseif( 'exclude_' === substr( $taxonomy, 0, 8 ) ) {
                                $dynamic_rules[] = array(
                                    'post_type' => 'wpupg_dynamic',
                                    'taxonomy' => substr( $taxonomy, 8 ),
                                    'values' => explode( ';', str_replace( ',', ';', $terms ) ),
                                    'type' => 'exclude',
                                );
                            }
                        }
                    }
                }
                if( count( $dynamic_rules ) > 0 || 'rand' === $grid->order_by() ) {
                    $grid->set_dynamic_rules( $dynamic_rules );
                } else if ( WPUltimatePostGrid::option( 'cache_reset_front_end', '1' ) == '1' ) {
                    // Make sure latest version of grid is shown.
                    $grid_ids = get_option( 'wpupg_regenerate_grids_check', false );

                    if( $grid_ids && in_array( $grid->ID(), $grid_ids ) ) {
                        WPUltimatePostGrid::get()->helper( 'grid_cache' )->generate( $grid->ID() );
                    }
                }

                if ( $no_output_mode ) {
                    return '';
                }

                $link_type = $grid->link_type();
                $link_target = $grid->link_target();
                $layout_mode = $grid->layout_mode();
                $centered = $grid->centered() ? 'true' : 'false';

                $posts = '<div id="wpupg-grid-' . esc_attr( $slug ) . '" class="wpupg-grid" data-grid="' . esc_attr( $slug ) . '" data-grid-id="' . $grid->ID() . '" data-link-type="' . $link_type . '" data-link-target="' . $link_target . '" data-layout-mode="' . $layout_mode . '" data-centered="' . $centered . '">';
                $posts .= $grid->draw_posts();
                $posts .= '</div>';

                $output = apply_filters( 'wpupg_posts_shortcode', $posts, $grid );

                // Message when no items match filter
                if( $grid->empty_message() ) {
                    $output .= '<div id="wpupg-grid-' . esc_attr( $slug ) . '-empty" class="wpupg-grid-empty">' . $grid->empty_message() . '</div>';
                }

                $pagination = '';
                if( $grid->pagination_type() == 'pages' ) {
                    $pagination_type = $grid->pagination_type();
                    $pagination_style = $grid->pagination_style();

                    $style_data = ' data-margin-vertical="' . $pagination_style['margin_vertical'] . '"';
                    $style_data .= ' data-margin-horizontal="' . $pagination_style['margin_horizontal'] . '"';
                    $style_data .= ' data-padding-vertical="' . $pagination_style['padding_vertical'] . '"';
                    $style_data .= ' data-padding-horizontal="' . $pagination_style['padding_horizontal'] . '"';
                    $style_data .= ' data-border-width="' . $pagination_style['border_width'] . '"';

                    $style_data .= ' data-background-color="' . $pagination_style['background_color'] . '"';
                    $style_data .= ' data-text-color="' . $pagination_style['text_color'] . '"';
                    $style_data .= ' data-border-color="' . $pagination_style['border_color'] . '"';

                    $style_data .= ' data-active-background-color="' . $pagination_style['background_active_color'] . '"';
                    $style_data .= ' data-active-text-color="' . $pagination_style['text_active_color'] . '"';
                    $style_data .= ' data-active-border-color="' . $pagination_style['border_active_color'] . '"';

                    $style_data .= ' data-hover-background-color="' . $pagination_style['background_hover_color'] . '"';
                    $style_data .= ' data-hover-text-color="' . $pagination_style['text_hover_color'] . '"';
                    $style_data .= ' data-hover-border-color="' . $pagination_style['border_hover_color'] . '"';
                    
                    $pagination .= '<div id="wpupg-grid-' . esc_attr( $slug ) . '-pagination" class="wpupg-pagination wpupg-pagination-' . $pagination_type . '" style="text-align: ' . $pagination_style['alignment'] . ';" data-grid="' . esc_attr( $slug ) . '" data-type="' . $pagination_type . '"' . $style_data . '>';
                    $pagination .= $grid->draw_pagination();
                    $pagination .= '</div>';
                }

                $output .= apply_filters( 'wpupg_pagination_shortcode', $pagination, $grid );

                wp_localize_script( 'wpupg_grid', 'wpupg_grid_' . $grid->ID(), array(
                    'posts' => $grid->posts(),
                ));
            }
        }

        return $output;
    }

    public function tinymce_plugin( $plugin_array )
    {
        $plugin_array['wpupg_grid_shortcode'] = WPUltimatePostGrid::get()->coreUrl . '/js/tinymce_shortcode.js';
        return $plugin_array;
    }
}