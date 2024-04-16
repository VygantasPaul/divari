<?php
/**
 * Header template
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
        <link rel="profile" href="//gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <?php
		do_action( 'alpha_preload_fonts' );
		?>

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <?php if ( alpha_get_option( 'loading_animation' ) ) : ?>
        <?php
			echo apply_filters(
				'alpha_page_loading_animation',
				'<div class="loading-overlay">
					<div class="bounce-loader">
					</div>
				</div>'
			);
			?>
        <?php endif; ?>

        <?php do_action( 'alpha_before_page_wrapper' ); ?>
        
        <div class="page-wrapper">

       
        <?php
// $parent_categories = get_terms(array(
//     'taxonomy' => 'product_cat',
//     'parent' => 0,
//     'hide_empty' => false, // Set to true if you want to hide empty categories
// ));

// foreach ($parent_categories as $parent_category) {
//     echo '<div class="parent-category">';
//     echo '<h2>' . $parent_category->name . '</h2>';

//     $child_categories = get_terms(array(
//         'taxonomy' => 'product_cat',
//         'parent' => $parent_category->term_id,
//         'hide_empty' => false, // Set to true if you want to hide empty categories
//     ));

//     foreach ($child_categories as $child_category) {
//         echo '<div class="child-category">';
//         echo '<h3>' . $child_category->name . '</h3>';

//         $grandchild_categories = get_terms(array(
//             'taxonomy' => 'product_cat',
//             'parent' => $child_category->term_id,
//             'hide_empty' => false, // Set to true if you want to hide empty categories
//         ));

//         foreach ($grandchild_categories as $grandchild_category) {
//             echo '<div class="grandchild-category">';
//             echo '<h4>' . $grandchild_category->name . '</h4>';
//             // You can continue nesting if needed
//             echo '</div>'; // .grandchild-category
//         }

//         echo '</div>'; // .child-category
//     }

//     echo '</div>'; // .parent-category
// }
?>

            <?php get_template_part( 'sidebar'); ?>
            <?php
		

			alpha_get_template_part( 'header/header' );

			alpha_print_title_bar();

			?>

            <?php do_action( 'alpha_before_main' ); ?>

            <main id="main" class="<?php echo apply_filters( 'alpha_main_class', 'main' ); ?>">