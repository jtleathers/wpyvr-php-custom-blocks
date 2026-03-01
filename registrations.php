<?php
function wpyvr_register_custom_post_types() {
    // Register Service Custom Post Type.
    $labels = array(
        'name'                     => _x( 'Services', 'post type general name', 'wpyvr' ),
        'singular_name'            => _x( 'Service', 'post type singular name', 'wpyvr' ),
        'add_new'                  => _x( 'Add New', 'service', 'wpyvr' ),
        'add_new_item'             => __( 'Add New Service', 'wpyvr' ),
        'edit_item'                => __( 'Edit Service', 'wpyvr' ),
        'new_item'                 => __( 'New Service', 'wpyvr' ),
        'view_item'                => __( 'View Service', 'wpyvr' ),
        'view_items'               => __( 'View Services', 'wpyvr' ),
        'search_items'             => __( 'Search Services', 'wpyvr' ),
        'not_found'                => __( 'No services found.', 'wpyvr' ),
        'not_found_in_trash'       => __( 'No services found in Trash.', 'wpyvr' ),
        'all_items'                => __( 'All Services', 'wpyvr' ),
        'insert_into_item'         => __( 'Insert into service', 'wpyvr' ),
        'uploaded_to_this_item'    => __( 'Uploaded to this service', 'wpyvr' ),
        'menu_name'                => _x( 'Services', 'admin menu', 'wpyvr' ),
        'filter_items_list'        => __( 'Filter services list', 'wpyvr' ),
        'items_list_navigation'    => __( 'Services list navigation', 'wpyvr' ),
        'items_list'               => __( 'Services list', 'wpyvr' ),
        'item_published'           => __( 'Service published.', 'wpyvr' ),
        'item_published_privately' => __( 'Service published privately.', 'wpyvr' ),
        'item_revereted_to_draft'  => __( 'Service reverted to draft.', 'wpyvr' ),
        'item_trashed'             => __( 'Service trashed.', 'wpyvr' ),
        'item_scheduled'           => __( 'Service scheduled.', 'wpyvr' ),
        'item_updated'             => __( 'Service updated.', 'wpyvr' ),
        'item_link'                => __( 'Service link.', 'wpyvr' ),
        'item_link_description'    => __( 'A link to a service.', 'wpyvr' ),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'services' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-chart-bar',
        'supports'           => array( 'title', 'editor' ),
    );
    
    register_post_type( 'wpyvr-service', $args );

}
add_action( 'init', 'wpyvr_register_custom_post_types' );

function wpyvr_register_taxonomies() {
    $labels = array(
        'name'                  => _x( 'Service Types', 'taxonomy general name', 'wpyvr' ),
        'singular_name'         => _x( 'Service Type', 'taxonomy singular name', 'wpyvr' ),
        'search_items'          => __( 'Search Service Types', 'wpyvr' ),
        'all_items'             => __( 'All Service Type', 'wpyvr' ),
        'parent_item'           => __( 'Parent Service Type', 'wpyvr' ),
        'parent_item_colon'     => __( 'Parent Service Type:', 'wpyvr' ),
        'edit_item'             => __( 'Edit Service Type', 'wpyvr' ),
        'view_item'             => __( 'View Service Type', 'wpyvr' ),
        'update_item'           => __( 'Update Service Type', 'wpyvr' ),
        'add_new_item'          => __( 'Add New Service Type', 'wpyvr' ),
        'new_item_name'         => __( 'New Service Type Name', 'wpyvr' ),
        'template_name'         => __( 'Service Type Archives', 'wpyvr' ),
        'menu_name'             => __( 'Service Type', 'wpyvr' ),
        'not_found'             => __( 'No service types found.', 'wpyvr' ),
        'no_terms'              => __( 'No service types', 'wpyvr' ),
        'items_list_navigation' => __( 'Service Types list navigation', 'wpyvr' ),
        'items_list'            => __( 'Service Types list', 'wpyvr' ),
        'item_link'             => __( 'Service Type Link', 'wpyvr' ),
        'item_link_description' => __( 'A link to a service type.', 'wpyvr' ),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menu'  => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'service-types' ),
    );
    
    register_taxonomy( 'wpyvr-service-type', array( 'wpyvr-service' ), $args );

}
add_action( 'init', 'wpyvr_register_taxonomies' );

function wpyvr_rewrite_flush() {
    wpyvr_register_custom_post_types();
    wpyvr_register_taxonomies();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wpyvr_rewrite_flush' );