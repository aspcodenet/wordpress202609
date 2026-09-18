<?php
/**
 * Plugin Name:       Vi som jobbar här (CPT.-bla)
 * Plugin URI:        https://example.com/
 * Description:       En plugin som skapar en Custom Post Type för personal.
 * Version:           1.0.0
 * Author:            Stefan
 * Author URI:        https://example.com/
 * Text Domain:       vi-som-jobbar-har
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Registrera Custom Post Type "Personal"
function vsh_register_personal_cpt() {
    $labels = array(
        'name'               => _x( 'Personal', 'Post Type General Name', 'vsh-cpt' ),
        'singular_name'      => _x( 'Person', 'Post Type Singular Name', 'vsh-cpt' ),
        'menu_name'          => __( 'Personal', 'vsh-cpt' ),
        'name_admin_bar'     => __( 'Personal', 'vsh-cpt' ),
        'add_new'            => __( 'Lägg till ny', 'vsh-cpt' ),
        'add_new_item'       => __( 'Lägg till ny person', 'vsh-cpt' ),
        'new_item'           => __( 'Ny person', 'vsh-cpt' ),
        'edit_item'          => __( 'Redigera person', 'vsh-cpt' ),
        'view_item'          => __( 'Visa person', 'vsh-cpt' ),
        'all_items'          => __( 'All personal', 'vsh-cpt' ),
        'search_items'       => __( 'Sök personal', 'vsh-cpt' ),
        'parent_item_colon'  => __( 'Överordnad person:', 'vsh-cpt' ),
        'not_found'          => __( 'Ingen personal hittades.', 'vsh-cpt' ),
        'not_found_in_trash' => __( 'Ingen personal hittades i papperskorgen.', 'vsh-cpt' ),
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'personal' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest'       => true,
    );
    register_post_type( 'personal', $args );
}
add_action( 'init', 'vsh_register_personal_cpt' );

// Tvinga WordPress att uppdatera sina permalänkar vid aktivering
function vsh_rewrite_flush() {
    vsh_register_personal_cpt();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'vsh_rewrite_flush' );

// Shortcode för att visa all personal på en publik sida
function vsh_personal_lista_shortcode() {
    $args = array(
        'post_type'      => 'personal',
        'posts_per_page' => -1, // Visa alla personalposter
    );
    $query = new WP_Query( $args );
    
    ob_start();
    
    if ( $query->have_posts() ) : ?>
        <div class="personal-lista">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <article class="personal-kort">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="personal-bild">
                             <?php the_post_thumbnail( 'thumbnail' ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="personal-info">
                        <h3><?php the_title(); ?></h3>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>Ingen personal hittades.</p>
    <?php endif;

    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode( 'personal_lista', 'vsh_personal_lista_shortcode' );