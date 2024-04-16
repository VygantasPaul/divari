<?php

/* Template Name: Home page */

get_header();

?>

<style>

</style>
<main class="main pt-2">
    <div class="container-fluid">
        <?php if (have_rows('home_page')) : ?>
            <section class="intro-section row grid">
                <div class="grid-item col-lg-12 col-xl-8 height-x2">
                    <div class="intro-slider owl-dots-line">
                        <div class="owl-carousel owl-theme banner-slider row cols-1 gutter-no" data-owl-options="{
            'dotsContainer': '.owl-dots-container',
            'nav': false,
            'dots': true,
            'loop': false,
            'items': 1
        }">
                            <?php $total_slides = 0; ?>
                            <?php while (have_rows('home_page')) : the_row(); ?>
                                <?php if (have_rows('slider_row')) : ?>
                                    <?php while (have_rows('slider_row')) : the_row(); ?>
                                        <?php
                                        $heading = get_sub_field('heading');
                                        $price = get_sub_field('price');
                                        $sub_price = get_sub_field('sub_price');
                                        $image = get_sub_field('image');
                                        $subheading = get_sub_field('subheading');
                                    
                                        $page_link = get_sub_field('button');
                                        ?>
                                        <div class="banner banner-fixed <?php echo ($total_slides % 2 === 0) ? 'intro-slide1' : 'intro-slide2'; ?>  overlay-zoom">
                                            <img class="big-slide" src="<?php echo $image['url'] ?>" alt="banner" style="background: #e4e6e7;">
                                            <div class="banner-content ">
                                                <h5 class="banner-subtitle text-uppercase text-dim lh-1 mb-4"><?php echo $subheading ?></h5>
                                                <h2 class="banner-title mb-5"><?php echo $heading ?></h2>
                                                <h3 class="banner-desc lh-1"><?php echo __('From', "pandastore") ?><span class="pl-3 text-primary"><sup>€</sup><?php echo $price ?><sup><?php echo $sub_price ?></sup></span></h3>
                                                <a href="<?php echo ($page_link) ?>" class="btn btn-dark"><?php echo __('Show now', "pandastore") ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                            </div>
                                        </div>
                                        <?php $total_slides++; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>

                        </div>
                        <div class="owl-dots-container">
                            <?php for ($i = 0; $i < $total_slides; $i++) : ?>
                                <button title="dots-container" class="owl-dot<?php echo ($i === 0) ? ' active' : ''; ?>">
                                    0<?php echo $i + 1; ?>.
                                </button>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (have_rows('header_side')) : ?>
                <?php while (have_rows('header_side')) : the_row(); ?>
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="row f-height">
                            <?php if (have_rows('top_banner')) : ?>
                                <?php while (have_rows('top_banner')) : the_row(); ?>
                                    <?php $heading = get_sub_field('heading');  ?>
                                    <?php $price = get_sub_field('price');  ?>
                                    <?php $sub_price = get_sub_field('sub_price');  ?>
                                    <?php $image = get_sub_field('image');  ?>
                                    <?php $show_now = get_sub_field('show_now');  ?>
                                    <div class="grid-item col-xl-12 col-md-6 height-x1">
                                        <div class="banner banner-fixed intro-banner1 overlay-zoom">
                                            <figure>
                                                <img src="<?php echo $image['url'] ?>" alt="banner" style="background: #dadfce;">
                                            </figure>
                                            <div class="banner-content">
                                                <h2 class="banner-title lh-1 mb-2"><?php echo $heading; ?></h2>
                                                <h4 class="banner-subtitle lh-1 "><?php echo __('From', "pandastore") ?><span class="pl-2 text-primary"><sup>€</sup><?php echo $price ?><sup><?php echo $sub_price ?></sup></span></h4>
                                                <a href="demo6-shop.html" class="btn btn-link btn-underline"><?php echo __('Show now', "pandastore") ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <?php if (have_rows('bottom_banner')) : ?>
                                <?php while (have_rows('bottom_banner')) : the_row(); ?>
                                    <?php $heading = get_sub_field('heading');  ?>
                                    <?php $price = get_sub_field('price');  ?>
                                    <?php $sub_price = get_sub_field('sub_price');  ?>
                                    <?php $image = get_sub_field('image');  ?>
                                    <?php $show_now = get_sub_field('show_now');  ?>
                                    <div class="grid-item col-xl-12 col-md-6 height-x1">
                                        <div class="banner banner-fixed intro-banner2 overlay-zoom">
                                            <figure>
                                                <img src="<?php echo $image['url'] ?>" alt="banner" style="background: #dadfce;">
                                            </figure>
                                            <div class="banner-content">
                                                <h2 class="banner-title lh-1 mb-2"><?php echo $heading; ?></h2>
                                                <h4 class="banner-subtitle lh-1 "><?php echo __('From', "pandastore") ?><span class="pl-2 text-primary"><sup>€</sup><?php echo $price ?><sup><?php echo $sub_price ?></sup></span></h4>
                                                <a href="demo6-shop.html" class="btn btn-link btn-underline"><?php echo __('Show now', "pandastore") ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            </section>
            <?php if (have_rows('service_group')) : ?>
                <?php while (have_rows('service_group')) : the_row(); ?>
                    <section class="services-section owl-box-border">
                    <div class="owl-carousel owl-theme row cols-xxl-4 cols-lg-2 cols-md-3 cols-sm-2 cols-1"
                            data-owl-options="{
                                'nav': false,
                                'dots': false,
                                'loop': true,
                                'autoplay': true,
                                'responsive': {
                                    '0': {
                                        'items': 1
                                    },
                                    '576': {
                                        'items': 2
                                    },
                                    '768': {
                                        'items': 3
                                    },
                                    '992': {
                                        'items': 2
                                    },
                                    '1200': {
                                        'items': 3
                                    },
                                    '1600': {
                                        'items': 4,
                                        'loop': false,
                                        'mouseDrag':false,
                                        'autoplay': false
                                    }
                                }
                            }">
                            <?php if (have_rows('service_row')) : ?>
                                <?php while (have_rows('service_row')) : the_row(); ?>
                                    <?php $icon = get_sub_field('icon');  ?>
                                    <?php $title = get_sub_field('title');  ?>
                                    <?php $text = get_sub_field('text');  ?>
                                    <div class="icon-box icon-box-side">
                                        <span class="icon-box-icon">
                                            <i class="<?php echo $icon; ?>"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title"><?php echo $title ?></h4>
                                            <p><?php echo $text ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php if (have_rows('discount_row_1')) : ?>
                <?php while (have_rows('discount_row_1')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading');  ?>
                    <section class="products-section">
                        <h2 class="title"><?php echo $heading ?></h2>
                        <div class="row">
                            <?php if (have_rows('first_block')) : ?>
                                <?php while (have_rows('first_block')) : the_row(); ?>
                                    <?php $collection_title = get_sub_field('collection_title');  ?>
                                    <?php $collection_subtitle = get_sub_field('collection_subtitle');  ?>
                                    <?php $collection_image = get_sub_field('collection_image');  ?>
                                    <?php $collection_price = get_sub_field('collection_price');  ?>
                                    <?php $collection_sub_price = get_sub_field('collection_sub_price');  ?>
                                    <div class="col-12 col-xxl-3 col-md-4 banner-wrapper">
                                        <div class="banner banner-fixed h-100" style="background-image: url(<?php echo $collection_image['url'] ?>); background-color: #e3eae8;">
                                            <div class="banner-content">
                                                <h5 class="banner-subtitle mb-3 text-uppercase text-body lh-1"><?php echo $collection_subtitle ?></h5>
                                                <h3 class="banner-title mb-1 lh-1 mb-4"><?php echo $collection_title ?></h3>
                                                <p class="banner-desc lh-1"><?php echo __('From', 'pandastore') ?><span class="pl-1 text-primary"><sup>€</sup><?php echo $collection_price ?><sup><?php echo $collection_sub_price ?></sup></span></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <div class="col-12 col-xxl-9 col-md-8 d-block">
                                <div class="owl-carousel owl-nav-top row cols-xxl-4 cols-xl-3 cols-2" data-owl-options="{
                                    'items': 2,
                                    'loop': false,
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20,
                                    'responsive': {
                                        '0': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '768': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '1200': {
                                            'items': 3
                                        },
                                        '1600': {
                                            'items': 4
                                        }
                                    }
                                }">
                                    <?php $featured_posts = get_sub_field('collection_type_block');
                                    if ($featured_posts) :
                                    ?>
                                        <?php foreach ($featured_posts as $post) :
                                            setup_postdata($post); ?>
                                            <?php
                                            global $product;
                                            $product = wc_get_product($post->ID); // Get the product object
                                            $product_id = $product->get_id();


                                            ?>
                                            <div class="product shadow-media text-center">
                                                <figure class="product-media">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?></a> <!-- Displaying the thumbnail -->
                                                    <?php endif; ?>
                                                </figure>
                                                <div class="product-details">
                                                    <h5 class="product-name"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h5>
                                                    <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                                                </div>
                                                <div class="product-hide-details">
                                                    <div class="product-action">
                                                        <a href="?add-to-cart=<?php echo $product_id; ?>" data-product_id="<?php echo $product_id; ?>" data-quantity="1" class="btn-product btn-cart add_to_cart_button ajax_add_to_cart single_add_to_cart_button" data-toggle="modal" data-target="#addCartModal" title="Add to Cart"> <?php esc_attr_e('Add To Cart','pandastore') ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php
                                        wp_reset_postdata();
                                    endif; ?>
                                </div>

                            </div>
                        </div>

                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php if (have_rows('3_columns_block')) : ?>
                <?php while (have_rows('3_columns_block')) : the_row(); ?>
                    <section class="banners-section row justify-content-center">
                        <?php if (have_rows('first_block')) : ?>
                            <?php while (have_rows('first_block')) : the_row(); ?>
                                <?php $title = get_sub_field('title');  ?>
                                <?php $discount = get_sub_field('discount');  ?>
                                <?php $image = get_sub_field('image');  ?>
                                <?php $button = get_sub_field('button');  ?>
                                <div class="col-xl-4 col-md-6 mb-4 mb-xl-0">
                                    <div class="banner banner-fixed banner1 overlay-zoom" data-animation-options="{
                                    'name': 'fadeIn'
                                }">
                                        <figure>
                                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" style="background: #e5e7d3;">
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title lh-1 mb-2"><?php echo $title ?></h3>
                                            <h4 class="banner-subtitle lh-1 mb-5"><?php esc_attr_e('Discount', 'pandastore') ?> <span class="text-primary"><?php echo $discount ?>%</span>
                                            </h4>
                                            <a href="<?php echo $button ?>" class="btn btn-link btn-underline"><?php esc_attr_e('Show now', 'pandastore') ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('second_block')) : ?>
                            <?php while (have_rows('second_block')) : the_row(); ?>
                                <?php $title = get_sub_field('title');  ?>
                                <?php $up_to_off_discount = get_sub_field('up_to_off_discount');  ?>
                                <?php $for_what = get_sub_field('for_what');  ?>
                                <?php $image = get_sub_field('image');  ?>
                                <div class="col-xl-4 col-md-6 mb-4 mb-xl-0">
                                    <div class="banner banner-fixed banner2 overlay-effect3">
                                        <figure>
                                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" style="background: #e5e7d3;">
                                        </figure>
                                        <div class="banner-content x-50 y-50 w-100 text-center">
                                            <h4 class="banner-subtitle lh-1 mb-3"><?php echo $title ?></h4>
                                            <h3 class="banner-title lh-1 mb-3 text-uppercase">Up to <span class="text-primary"><?php echo $up_to_off_discount ?>% Off</span></h3>
                                            <p class="banner-desc lh-1 mb-0 text-uppercase text-dim"><?php echo $for_what; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('third_block')) : ?>
                            <?php while (have_rows('third_block')) : the_row(); ?>
                                <?php $title = get_sub_field('title');  ?>
                                <?php $discount = get_sub_field('discount');  ?>
                                <?php $image = get_sub_field('image');  ?>
                                <?php $button = get_sub_field('button');  ?>
                                <div class="col-xl-4 col-md-6 mb-4 mb-xl-0">
                                    <div class="banner banner-fixed banner3 overlay-zoom" data-animation-options="{
                                    'name': 'fadeIn'
                                }">
                                        <figure>
                                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" style="background: #e5e7d3;">
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title text-dim lh-1 mb-2"><?php echo $title ?></h3>
                                            <h4 class="banner-subtitle lh-1 mb-5"><?php esc_attr_e('Discount', 'pandastore') ?> <span class="text-primary"><?php echo $discount ?>%</span>
                                            </h4>
                                            <a href="<?php echo $button ?>" class="btn btn-link btn-underline"><?php esc_attr_e('Show now', 'pandastore') ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php if (have_rows('discount_row_2')) : ?>
                <?php while (have_rows('discount_row_2')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading');  ?>
                    <section class="products-section">
                        <h2 class="title"><?php echo $heading ?></h2>
                        <div class="row">
                            <?php if (have_rows('first_block')) : ?>
                                <?php while (have_rows('first_block')) : the_row(); ?>
                                    <?php $collection_title = get_sub_field('collection_title');  ?>
                                    <?php $collection_subtitle = get_sub_field('collection_subtitle');  ?>
                                    <?php $collection_image = get_sub_field('collection_image');  ?>
                                    <?php $collection_price = get_sub_field('collection_price');  ?>
                                    <?php $collection_sub_price = get_sub_field('collection_sub_price');  ?>
                                    <div class="col-xxl-3 col-md-4 banner-wrapper ">
                                        <div class="banner banner-fixed h-100" style="background-image: url(<?php echo $collection_image['url'] ?>); background-color: #e3eae8;">
                                            <div class="banner-content">
                                                <h5 class="banner-subtitle mb-3 text-uppercase text-body lh-1"><?php echo $collection_subtitle ?></h5>
                                                <h3 class="banner-title mb-1 lh-1 mb-4"><?php echo $collection_title ?></h3>
                                                <p class="banner-desc lh-1"><?php echo __('From', 'pandastore') ?><span class="pl-1 text-primary"><sup>€</sup><?php echo $collection_price ?><sup><?php echo $collection_sub_price ?></sup></span></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <div class="col-xxl-9 col-md-8 d-block">
                                <div class="owl-carousel owl-nav-top row cols-xxl-4 cols-xl-3 cols-2" data-owl-options="{
                                    'items': 2,
                                    'loop': false,
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20,
                                    'responsive': {
                                        '0': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '768': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '1200': {
                                            'items': 3
                                        },
                                        '1600': {
                                            'items': 4
                                        }
                                    }
                                }">
                                    <?php $featured_posts = get_sub_field('collection_type_block');
                                    if ($featured_posts) :
                                    ?>
                                      <?php foreach ($featured_posts as $post) :
                                            setup_postdata($post); ?>
                                            <?php
                                            global $product;
                                            $product = wc_get_product($post->ID); // Get the product object
                                            $product_id = $product->get_id();


                                            ?>
                                            <div class="product shadow-media text-center">
                                                <figure class="product-media">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?></a> <!-- Displaying the thumbnail -->
                                                    <?php endif; ?>
                                                </figure>
                                                <div class="product-details">
                                                    <h5 class="product-name"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h5>
                                                    <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                                                </div>
                                                <div class="product-hide-details">
                                                    <div class="product-action">
                                                        <a href="?add-to-cart=<?php echo $product_id; ?>" data-product_id="<?php echo $product_id; ?>" data-quantity="1" class="btn-product btn-cart add_to_cart_button ajax_add_to_cart single_add_to_cart_button" data-toggle="modal" data-target="#addCartModal" title="Add to Cart"> <?php esc_attr_e('Add To Cart','pandastore') ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php
                                        wp_reset_postdata();
                                    endif; ?>
                                </div>

                            </div>
                        </div>

                    </section>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php if (have_rows('2_columns_block')) : ?>
                <?php while (have_rows('2_columns_block')) : the_row(); ?>
                    <section class="banners-section row">
                        <?php if (have_rows('first_block')) : ?>
                            <?php while (have_rows('first_block')) : the_row(); ?>
                                <?php $title = get_sub_field('title');  ?>
                                <?php $image = get_sub_field('image');  ?>
                                <?php $button = get_sub_field('button');  ?>
                                <div class="col-xl-6 mb-4 mb-xl-0">
                                    <div class="banner banner-fixed banner4 overlay-zoom" data-animation-options="{
                                    'name': 'fadeIn'
                                }">
                                        <figure>
                                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" style="background: #e5e7d3;">
                                        </figure>
                                        <div class="banner-content">
                                            <h4 class="text-uppercase text-dim lh-1 mb-4"><?php echo __('Best sellers', 'pandastore') ?></h4>
                                            <h3 class="banner-title mb-xxl-10 mb-6 pb-7"> <?php echo $title ?></h3>
                                            <a href="<?php echo $button ?>" class="btn btn-link btn-underline"><?php echo __('Shop now', 'pandastore') ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('second_block')) : ?>
                            <?php while (have_rows('second_block')) : the_row(); ?>
                                <?php $title = get_sub_field('title');  ?>
                                <?php $image = get_sub_field('image');  ?>
                                <?php $button = get_sub_field('button');  ?>
                                <div class="col-xl-6">
                                    <div class="banner banner-fixed banner5 overlay-zoom" data-animation-options="{
                                    'name': 'fadeIn'
                                }">
                                        <figure>
                                            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" style="background: #9b9996;">
                                        </figure>
                                        <div class="banner-content">
                                            <h5 class="text-uppercase text-white lh-1 mb-4"><?php echo __('Just Arrived', 'pandastore') ?></h5>
                                            <h3 class="banner-title mb-xxl-10 mb-6 pb-7 text-white"><?php echo $title ?></h3>
                                            <a href="<?php echo $button ?>" class="btn btn-link btn-white btn-underline"><?php echo __('Shop now', 'pandastore') ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php if (have_rows('discount_row_3')) : ?>
                <?php while (have_rows('discount_row_3')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading');  ?>
                    <section class="products-section ">
                        <h2 class="title"><?php echo $heading ?></h2>
                        <div class="row">
                            <?php if (have_rows('first_block')) : ?>
                                <?php while (have_rows('first_block')) : the_row(); ?>
                                    <?php $collection_title = get_sub_field('collection_title');  ?>
                                    <?php $collection_subtitle = get_sub_field('collection_subtitle');  ?>
                                    <?php $collection_image = get_sub_field('collection_image');  ?>
                                    <?php $collection_price = get_sub_field('collection_price');  ?>
                                    <?php $collection_sub_price = get_sub_field('collection_sub_price');  ?>
                                    <div class="col-xxl-3 col-md-4 banner-wrapper ">
                                        <div class="banner banner-fixed h-100" style="background-image: url(<?php echo $collection_image['url'] ?>); background-color: #e3eae8;">
                                            <div class="banner-content">
                                                <h5 class="banner-subtitle mb-3 text-uppercase text-body lh-1"><?php echo $collection_subtitle ?></h5>
                                                <h3 class="banner-title mb-1 lh-1 mb-4"><?php echo $collection_title ?></h3>
                                                <p class="banner-desc lh-1"><?php echo __('From', 'pandastore') ?><span class="pl-1 text-primary"><sup>€</sup><?php echo $collection_price ?><sup><?php echo $collection_sub_price ?></sup></span></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <div class="col-xxl-9 col-md-8 d-block">
                                <div class="owl-carousel owl-nav-top row cols-xxl-4 cols-xl-3 cols-2" data-owl-options="{
                                    'items': 2,
                                    'loop': false,
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20,
                                    'responsive': {
                                        '0': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '768': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '1200': {
                                            'items': 3
                                        },
                                        '1600': {
                                            'items': 4
                                        }
                                    }
                                }">
                                    <?php $featured_posts = get_sub_field('collection_type_block');
                                    if ($featured_posts) :
                                    ?>
                                       <?php foreach ($featured_posts as $post) :
                                            setup_postdata($post); ?>
                                            <?php
                                            global $product;
                                            $product = wc_get_product($post->ID); // Get the product object
                                            $product_id = $product->get_id();


                                            ?>
                                            <div class="product shadow-media text-center">
                                                <figure class="product-media">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?></a> <!-- Displaying the thumbnail -->
                                                    <?php endif; ?>
                                                </figure>
                                                <div class="product-details">
                                                    <h5 class="product-name"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h5>
                                                    <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                                                </div>
                                                <div class="product-hide-details">
                                                    <div class="product-action">
                                                        <a href="?add-to-cart=<?php echo $product_id; ?>" data-product_id="<?php echo $product_id; ?>" data-quantity="1" class="btn-product btn-cart add_to_cart_button ajax_add_to_cart single_add_to_cart_button" data-toggle="modal" data-target="#addCartModal" title="Add to Cart"> <?php esc_attr_e('Add To Cart','pandastore') ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php
                                        wp_reset_postdata();
                                    endif; ?>
                                </div>

                            </div>
                        </div>

                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php if (have_rows('1_column_block')) : ?>
                <?php while (have_rows('1_column_block')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading');  ?>
                    <?php $right_title = get_sub_field('right_title');  ?>
                    <?php $image = get_sub_field('image');  ?>
                    <?php $button = get_sub_field('button');  ?>
                    <?php $description = get_sub_field('description');  ?>
                    <?php $price = get_sub_field('price');  ?>
                    <?php $subprice = get_sub_field('sub_price');  ?>
                    <section class="banner banner6" style="background-image: url(<?php echo $image['url'] ?>); background-color: #e7e3e5;">
                        <div class="row align-items-center">
                            <div class="col-md-6 pr-xl-8 pr-md-6 mb-md-0">
                                <div class="banner-content1">
                                    <h3 class="banner-title mb-7"><?php echo $heading ?></h3>
                                    <a href="<?php echo $button ?>" class="btn btn-link btn-underline"><?php esc_attr_e('Show now', 'pandastore') ?><i class="p-icon-arrow-long-right pl-1"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6 pl-xl-8 pl-md-6">
                                <div class="banner-content2 ml-lg-auto">
                                    <h3 class="banner-title lh-1 mb-3"><?php echo $right_title; ?></h3>
                                    <p class="banner-desc"><?php echo $description; ?></p>
                                    <p class="banner-price lh-1 mb-0"><?php esc_attr_e('From', 'pandastore') ?><span class="pl-2 text-primary"><sup>$</sup><?php echo $price; ?><sup><?php echo $subprice; ?></sup></span></p>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php if (have_rows('discount_row_4')) : ?>
                <?php while (have_rows('discount_row_4')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading');  ?>
                    <section class="products-section">
                        <h2 class="title"><?php echo $heading ?></h2>
                        <div class="row">
                            <?php if (have_rows('first_block')) : ?>
                                <?php while (have_rows('first_block')) : the_row(); ?>
                                    <?php $collection_subtitle = get_sub_field('collection_subtitle');  ?>
                                    <?php $collection_title = get_sub_field('collection_title');  ?>
                                    <?php $collection_image = get_sub_field('collection_image');  ?>
                                    <?php $collection_price = get_sub_field('collection_price');  ?>
                                    <?php $collection_sub_price = get_sub_field('collection_sub_price');  ?>
                                    <div class="col-xxl-3 col-md-4 banner-wrapper">
                                        <div class="banner banner-fixed h-100" style="background-image: url(<?php echo $collection_image['url'] ?>); background-color: #e3eae8;">
                                            <div class="banner-content">
                                                <h5 class="banner-subtitle mb-3 text-uppercase text-body lh-1"><?php echo $collection_subtitle ?></h5>
                                                <h3 class="banner-title mb-1 lh-1 mb-4"><?php echo $collection_title ?></h3>
                                                <h4 class="banner-desc lh-1"><?php echo __('From', 'pandastore') ?><span class="pl-1 text-primary"><sup>€</sup><?php echo $collection_price ?><sup><?php echo $collection_sub_price ?></sup></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <div class="col-xxl-9 col-md-8 d-block">
                                <div class="owl-carousel owl-nav-top row cols-xxl-4 cols-xl-3 cols-2" data-owl-options="{
                                    'items': 2,
                                    'loop': false,
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20,
                                    'responsive': {
                                        '0': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '768': {
                                            'dots': false,
                                            'nav': true,
                                            'items': 2
                                        },
                                        '1200': {
                                            'items': 3
                                        },
                                        '1600': {
                                            'items': 4
                                        }
                                    }
                                }">
                                    <?php $featured_posts = get_sub_field('collection_type_block');
                                    if ($featured_posts) :
                                    ?>
                                      <?php foreach ($featured_posts as $post) :
                                            setup_postdata($post); ?>
                                            <?php
                                            global $product;
                                            $product = wc_get_product($post->ID); // Get the product object
                                            $product_id = $product->get_id();


                                            ?>
                                            <div class="product shadow-media text-center">
                                                <figure class="product-media">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?></a> <!-- Displaying the thumbnail -->
                                                    <?php endif; ?>
                                                </figure>
                                                <div class="product-details">
                                                    <h5 class="product-name"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h5>
                                                    <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                                                </div>
                                                <div class="product-hide-details">
                                                    <div class="product-action">
                                                        <a href="?add-to-cart=<?php echo $product_id; ?>" data-product_id="<?php echo $product_id; ?>" data-quantity="1" class="btn-product btn-cart add_to_cart_button ajax_add_to_cart single_add_to_cart_button" data-toggle="modal" data-target="#addCartModal" title="Add to Cart"> <?php esc_attr_e('Add To Cart','pandastore') ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php
                                        wp_reset_postdata();
                                    endif; ?>
                                </div>

                            </div>
                        </div>

                    </section>
                <?php endwhile; ?>
            <?php endif; ?>
    </div>

</main>

<?php
get_footer();
?>