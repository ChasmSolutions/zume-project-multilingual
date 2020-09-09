<?php

function default_facebook_image( $opengraph_image ) {
    global $post;
    if ( 'page' === $post->post_type ) {
        $tool_id = zume_landing_page_post_id( (int) zume_get_translation( $post->ID, 'en' ) );
        if ( ! empty( $tool_id ) ) {
            $opengraph_image->add_image( get_template_directory_uri() . '/assets/images/piece-seo-images/'.esc_attr( $tool_id ).'.jpg' );
        }
    }
}
add_action( 'wpseo_add_opengraph_additional_images', 'default_facebook_image' );
