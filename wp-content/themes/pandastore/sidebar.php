<?php

/**
 * Blank template
 *
 * Please refer to templates/sidebar.php file, thank you.
 *
 * @author     D-THEMES
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined('ABSPATH') || die;

?>


<aside class="sidebar sidebar-offcanvas sidebar-side left-sidebar" id="home-sidebar">

    <div class="sidebar-overlay">
    </div>
    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
    <div class="sidebar-content">
        <div>
            <div class="logo">
                <a href="http://test.divari.lt/" class="logo" title="Divari logo">
                    <img src=" <?php home_url() ?>/wp-content/uploads/2024/03/divari.svg" class="site-logo skip-data-lazy attachment-full size-full" alt="Divari" decoding="async" style="filter: invert(0);"></a>
            </div>

            <?php
            
            wp_nav_menu(array(
                'menu'   => 'Main Menu',
                'menu_class' => 'menu',
                'menu_id'   => 'menu-main-menu',

            ));

            ?>
        </div>
    </div>

</aside>


