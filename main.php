<?php
/*Plugin Name: Product Slider for bootScore
Plugin URI: https://bootscore.me
Description: WooCommerce Product slider for bootScore theme https://bootscore.me. Use Shortcode like this [product-slider type="product" order="DESC" orderby="date" posts="12"] and read readme.txt in PlugIn folder for options.
Version: 1.0.0
Author: Bastian Kreiter
Author URI: https://crftwrk.de
License: GPLv2
*/





// Register Styles and Scripts
function product_scripts() {

    wp_enqueue_script( 'swiper-js', plugins_url( '/js/swiper.min.js', __FILE__ ));
    
    wp_enqueue_script( 'slider', plugins_url( '/js/slider.js', __FILE__ ));
    
    wp_register_style( 'swiper', plugins_url('css/swiper.min.css', __FILE__) );
        wp_enqueue_style( 'swiper' );
    
    wp_register_style( 'product-style', plugins_url('css/product-style.css', __FILE__) );
        wp_enqueue_style( 'product-style' );
    }

add_action('wp_enqueue_scripts','product_scripts');


// Product Slider Shortcode
add_shortcode( 'product-slider', 'bootscore_product_slider' );
function bootscore_product_slider( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
		'type' => 'post',
		'order' => 'date',
		'orderby' => 'date',
		'posts' => -1,
		'category' => '',
	), $atts ) );
	$options = array(
		'post_type' => $type,
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $posts,
		'category_name' => $category,
	);
	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>


<!-- Swiper -->

<div class="px-5 position-relative my-5">

    <div class="swiper-container">

        <div class="swiper-wrapper">

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

            <div <?php wc_product_class( 'swiper-slide card h-auto mb-5 d-flex text-center product-card', $product ); ?>>
                <?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

        ?>
                <div class="card-body d-flex flex-column">
                    <?php
	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
                </div>
            </div>

            <?php endwhile; wp_reset_postdata(); ?>

        </div> <!-- .swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>

    </div><!-- swiper-container -->

    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

</div><!-- px-5 position-relative mb-5 -->

<!-- Swiper End -->

<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}

// Product Slider Shortcode End
