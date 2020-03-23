<?php
/**
 * @see https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
 * Wrap all polylang integration function in a if function exists test, so if the plugin is turned off or upgraded
 * the site doesn't error out.
 * use: function_exists('pll_the_languages' )
 */



/**
 * Tests if polylang plugin is installed.
 * Must check for plugin existence, because when the polylang plugin is updated, it will be deleted and reinstalled, which
 * could create an error on update if dependent functions are not protected.
 * @return bool
 */
function zume_has_polylang() {
    if ( function_exists( 'pll_the_languages' ) ) {
        return true;
    } else {
        return false;
    }
}

function zume_the_languages( $args = array() ) {
    if ( function_exists( 'pll_the_languages' ) ) {
        return pll_the_languages( $args );
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

function zume_current_language() {
    if ( function_exists( 'pll_the_languages' ) ) {
        $current_language = pll_current_language();
        return ( ! empty( $current_language ) ) ? $current_language : 'en';
    }
    else {
        return 'en';
    }
}

function zume_default_language() {
    if ( function_exists( 'pll_the_languages' ) ) {
        return pll_default_language();
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

function zume_get_translation( $post_id, $slug = 'en' ) {
    if ( function_exists( 'pll_the_languages' ) ) {
        if ( empty( $slug ) ) {
            $slug = 'en';
        }
        return pll_get_post( $post_id, $slug );
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

/**
 * @param        $page_title
 * @param string $slug
 *
 * @return string|\WP_Error
 */
function zume_get_posts_translation_url( $page_title, $slug = 'en' ) {

    if ( function_exists( 'pll_the_languages' ) ) {
        // find post by title
        $post_id = get_page_by_title( $page_title, OBJECT, 'page' );

        // get translation id by eng id
        if ( empty( $slug ) ) {
            $slug = 'en';
        }

        if ( isset( $post_id->ID ) && ! empty( $post_id->ID ) ) {
            $trans_id = pll_get_post( $post_id->ID, $slug );
            if ( ! $trans_id ) {
                return '';
            }
        } else {
            return '';
        }

        $trans_object = get_post( $trans_id, OBJECT );

        $trans_url = site_url( '/' )  . $trans_object->post_name;

        return $trans_url;
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

function zume_get_landing_translation_url( int $landing_id, $slug = 'en' ) {

    if ( function_exists( 'pll_the_languages' ) ) {
        // find post by title
        $post_id = zume_landing_page_post_id( $landing_id );

        // get translation id by eng id
        if ( empty( $slug ) ) {
            $slug = 'en';
        }

        if ( ! empty( $post_id ) ) {
            $trans_id = pll_get_post( $post_id, $slug );
            if ( ! $trans_id ) {
                return '';
            }
        } else {
            return '';
        }

        $trans_object = get_post( $trans_id, OBJECT );

        $trans_url = site_url( '/' )  . $trans_object->post_name;

        return $trans_url;
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

function zume_get_landing_title( int $landing_id, $slug = 'en' ) {

    if ( function_exists( 'pll_the_languages' ) ) {
        // find post by title
        $post_id = zume_landing_page_post_id( $landing_id );

        $meta = get_post_meta( $post_id, 'zume_piece_h1', true );
        if ( $meta ) {
            return $meta;
        }

        // get translation id by eng id
        if ( empty( $slug ) ) {
            $slug = 'en';
        }

        if ( ! empty( $post_id ) ) {
            $trans_id = pll_get_post( $post_id, $slug );
            if ( ! $trans_id ) {
                return '';
            }
        } else {
            return '';
        }

        $trans_object = get_post( $trans_id, OBJECT );

        return $trans_object->post_title;
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

function zume_get_concept_translation_url( $page_title, $slug = 'en' ) {

    if ( function_exists( 'pll_the_languages' ) ) {
        // find post by title
        $post_id = get_page_by_title( $page_title, OBJECT, 'page' );

        // get translation id by eng id
        if ( empty( $slug ) ) {
            $slug = 'en';
        }

        if ( isset( $post_id->ID ) && ! empty( $post_id->ID ) ) {
            $trans_id = pll_get_post( $post_id->ID, $slug );
            if ( ! $trans_id ) {
                return '';
            }
        } else {
            return '';
        }

        $trans_object = get_post( $trans_id, OBJECT );

        $trans_url = site_url( '/' )  . $trans_object->post_name;

        return $trans_url;
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

/**
 * Gets the translation post id for the front page
 *
 * @param $page_title
 * @param string $slug
 * @return array|int|null|string|WP_Error|WP_Post
 */
function zume_get_home_translation_id( $page_title, $slug = 'en' ) {

    if ( function_exists( 'pll_the_languages' ) ) {
        // find post by title
        $post_id = get_page_by_title( $page_title, OBJECT, 'page' );
        if ( empty( $slug ) ) {
            $slug = 'en';
        }
        // get translation id by eng id
        if ( isset( $post_id->ID )){
            $trans_id = pll_get_post( $post_id->ID, $slug );
            if ( ! $trans_id ) {
                return '';
            }
        } else {
            return '';
        }

        $trans_object = get_post( $trans_id, OBJECT );

        return $trans_object->ID;
    }
    else {
        return new WP_Error( 'Polylang_missing', 'Polylang plugin missing' );
    }
}

