<?php
/**
 * Plugin Name:       WPYVR Demo Plugin
 * Plugin URI:        https://github.com/jtleathers/
 * Description:       A demo of creating custom blocks with auto_register support.
 * Version:           1.0.0
 * Requires at least: 7.0
 * Requires PHP:      8.0
 * Author:            Jonathon Leathers
 * Author URI:        https://jonathonleathers.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        false
 */

// Register Custom Post Type and Taxonomy
require_once plugin_dir_path( __FILE__ ) . 'registrations.php';


add_action('init', 'wpyvr_register_block_types');
function wpyvr_register_block_types() {

    // Register a Simple Hello World block.
    register_block_type( 
        'wpyvr/hello-world', 
        array(
            'title'       => 'WPYVR Test Block',
            'icon'        => 'smiley',
            'category'    => 'text',
            'description' => 'A simple Hello World block for WPYVR.',
            'keywords'    => array( 'hi', 'hey', 'wpyvr' ),
            'render_callback' => function( $attributes) {
                $wrapper_attributes = get_block_wrapper_attributes();
                return sprintf(
                    '<div %1$s>Hello WPYVR!</div>',
                    $wrapper_attributes
                );
            },
            'supports' => array(
                'autoRegister' => true,
                'typography' => array(
                    'textAlign' => true,
                ),
                'color' => array(
                    'text' => true,
                    'background' => true,
                ),
                'spacing' => array(
                    'padding' => true,
                    'margin' => true,
                ),
            ),
        ) 
    );

    // Register a Service Posts block.
    register_block_type( 
        'wpyvr/service-posts', 
        array(
            'title'       => 'WPYVR Service Posts',
            'icon'        => 'list-view',
            'category'    => 'text',
            'description' => 'A block to display service posts for WPYVR.',
            'keywords'    => array( 'hi', 'hey', 'wpyvr' ),
            'render_callback' => 'wpyvr_render_service_posts_block',
            'supports' => array(
                'autoRegister' => true,
            ),
        ) 
    );
}

// Callback function for the Service Posts block.
function wpyvr_render_service_posts_block( $attributes ) {
    ob_start();
    ?>
    <div <?php echo get_block_wrapper_attributes(); ?>>
        <?php
        // Output the Service navigation
        $args = array(
            'post_type'      => 'wpyvr-service',
            'posts_per_page' => -1,
            'order'          => 'ASC',
            'orderby'        => 'title'
        );
        $query = new WP_Query( $args );
        if ( $query -> have_posts() ) :
            ?>
            <nav class="services-nav">
                <?php
                while ( $query -> have_posts() ) :
                    $query -> the_post();
                    ?>
                    <a href="#<?php echo esc_attr( get_the_ID() ); ?>" style="display: block;"><?php echo esc_html( get_the_title() ); ?></a>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </nav>
            <?php
        endif;
        
        // Output the Service posts
        $taxonomy = 'wpyvr-service-type';
        $terms    = get_terms(
            array(
                'taxonomy' => $taxonomy
            )
        );
        if( $terms && ! is_wp_error( $terms ) ) :
            foreach( $terms as $term ) :
                $args = array(
                    'post_type'      => 'wpyvr-service',
                    'posts_per_page' => -1,
                    'order'          => 'ASC',
                    'orderby'        => 'title',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field'    => 'slug',
                            'terms'    => $term->slug,
                        )
                    ),
                );
                $query = new WP_Query( $args );
                if ( $query -> have_posts() ) :
                    ?>
                    <section>
                        <h2><?php echo esc_html( $term->name ); ?></h2>
                        <?php
                        while ( $query -> have_posts() ) :
                            $query -> the_post();
                            ?>
                            <article id="<?php echo esc_attr( get_the_ID() ); ?>">
                                <h3><?php echo esc_html( get_the_title() ); ?></h3>
                                <?php the_content(); ?>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </section>
                    <?php
                endif;
            endforeach;
        endif;
        ?>
    </div>
    <?php
    return ob_get_clean();
}