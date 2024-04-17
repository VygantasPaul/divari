<?php 

/* Template Name: About page */

get_header()
?>



<main class="main">
    <div class="page-content about-page">
        <div class="container">
            <section class="row align-items-center">
                <?php if( have_rows('group_1') ): ?>
                <?php while( have_rows('group_1') ): the_row(); ?>
                <?php $poster = get_sub_field('poster'); ?>
                <?php $subtitle = get_sub_field('subtitle'); ?>
                <?php $heading = get_sub_field('heading'); ?>
                <?php $description = get_sub_field('description'); ?>

                <?php if ($poster): ?>
                <div class="col-lg-6">
                    <figure>
                        <img src="<?php echo $poster['url'] ?>" alt="<?php echo $poster['alt']; ?>" />
                    </figure>
                </div>
                <?php endif; ?>

                <div class="col-lg-6">
                    <div class="pl-lg-8 pr-lg-3 pt-5 pt-lg-0">
                        <h4 class="text-uppercase text-body font-weight-normal ls-1 mb-4">
                            <?php echo $subtitle ?>
                        </h4>
                        <h2 class="desc-title mb-4"> <?php echo $heading ?></h2>
                        <div class="pb-5">
                            <?php echo $description ?>
                        </div>
                        <?php
                    $page_link = get_sub_field('button');

                    // Check if the page link exists
                    if ($page_link) {
                        // Retrieve the permalink of the linked page
                        $permalink = $page_link['url'];
                        // Output the link
                        echo '<a class="btn btn-outline btn-dark ml-1 mb-1" href="' . esc_url($permalink) . '">' . esc_html($page_link['title']) . '<i class="p-icon-arrow-long-right"></i></a>';
                    }
                    ?>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </section>
        </div>
        <section class="pb-6" style="background-color:#f9f8f4">
            <div class="container text-center">
                <?php if( have_rows('group_2') ): ?>
                <?php while( have_rows('group_2') ): the_row(); ?>
                <?php $subtitle = get_sub_field('subtitle'); ?>
                <?php $heading = get_sub_field('heading'); ?>
                <h4 class="text-uppercase text-body font-weight-normal ls-1 mb-3"> <?php echo $subtitle ?></h4>
                <h2 class="desc-title mb-10"> <?php echo $heading ?></h2>
                <div class="row cols-lg-3 cols-md-2 cols-1 justify-content-center">
                    <?php if (have_rows('column')): ?>
                    <?php while (have_rows('column')): the_row(); ?>
                    <?php   $number = get_sub_field('number'); ?>
                    <?php   $title = get_sub_field('title'); ?>
                    <?php   $description = get_sub_field('description'); ?>
                    <div class="counter mb-6">
                        <span class="count-to text-primary" data-fromvalue="0" data-tovalue="<?php echo $number ?>"
                            data-duration="2000" data-delimiter=",">0</span>
                        <div class="counter-content">
                            <h4 class="count-title text-dark mb-2"><?php echo $title ?></h4>
                            <p class=" count-desc mx-auto" style="width: 80%;"><?php echo $description  ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </section>
        <div class="container">
            <section class="row align-items-center">
                <?php if( have_rows('group_3') ): ?>
                <?php while( have_rows('group_3') ): the_row(); ?>
                <?php $subtitle = get_sub_field('subtitle'); ?>
                <?php $heading = get_sub_field('heading'); ?>
                <?php $description = get_sub_field('description'); ?>
                <div class="col-lg-6">
                    <div class="pr-lg-3">
                        <h4 class="text-uppercase text-body font-weight-normal ls-1 mt-5 mb-4"><?php echo $subtitle ?>
                        </h4>
                        <h2 class="desc-title mb-4"><?php echo $heading ?></h2>
                        <div>
                            <?php echo $description ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php if ($poster): ?>
                    <div class="col-lg-6">
                        <figure>
                            <img src="<?php echo $poster['url'] ?>" width="<?php echo $poster['width'] ?>"
                                height="<?php echo $poster['height'] ?>" alt="<?php echo $poster['alt']; ?>" />
                        </figure>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </section>
        </div>
        <section style="background-color:#f9f8f4; padding-bottom: 8rem;">
            <?php if( have_rows('group_4') ): ?>
            <?php while( have_rows('group_4') ): the_row(); ?>
            <?php $subtitle = get_sub_field('subtitle'); ?>
            <?php $heading = get_sub_field('heading'); ?>
            <div class="container text-center">
                <h4 class="text-uppercase text-body font-weight-normal ls-1 mb-3">
                    <?php echo $subtitle ?>
                </h4>
                <h2 class="desc-title mb-4">
                    <?php echo $heading ?>
                </h2>

                <div class="owl-carousel owl-theme row owl-nav-box cols-1" data-owl-options="{
                                'items': 1,
                                'nav': false,
                                'dots': false,
                                'autoplay': true,
                                'loop': true,
                                'margin': 20,
                                'responsive': {
                                    '0': {
                                        'nav': false
                                    },
                                    '1600': {
                                        'nav': true
                                    }
                                }
                            }">
                    <?php if (have_rows('slider_columns')): ?>
                    <?php while (have_rows('slider_columns')): the_row(); ?>
                    <?php   $poster = get_sub_field('poster'); ?>
                    <?php   $description = get_sub_field('description'); ?>
                    <?php   $client_name = get_sub_field('client_name'); ?>
                    <?php   $client_type = get_sub_field('client_type'); ?>
                    <div class="testimonial testimonial-centered with-double-quote pt-2">
                        <blockquote>
                            <?php if($poster): ?>
                            <figure class="testimonial-author-thumbnail">
                                <img src="<?php echo $poster['url'] ?>" alt="<?php echo $poster['alt']; ?>" />
                            </figure>
                            <?php endif; ?>
                            <div>
                                <?php echo $description; ?>
                            </div>
                            <div class="testimonial-info">
                                <cite class="text-black">
                                    <?php echo $client_name; ?>
                                    <span> <?php echo $client_type; ?></span>
                                </cite>
                            </div>
                        </blockquote>
                    </div>

                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </section>
        <div class="container">
            <section class="text-center pb-10 pt-10 mb-6">
                <?php if( have_rows('group_5') ): ?>
                <?php while( have_rows('group_5') ): the_row(); ?>
                <?php $subtitle = get_sub_field('subtitle'); ?>
                <?php $heading = get_sub_field('heading'); ?>
                <h4 class="text-uppercase text-body font-weight-normal ls-1 mt-7 mb-3">
                    <?php echo $subtitle ?>
                </h4>
                <h2 class="desc-title mb-9">
                    <?php echo $heading ?>
                </h2>
                <div class="owl-carousel owl-theme row cols-lg-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                            'items': 3,
                            'margin': 30,
                            'dots': true,
                            'autoplay': false,
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
                                    'items': 3
                                }
                            }
                        }">
                    <?php if (have_rows('staff_columns')): ?>
                    <?php while (have_rows('staff_columns')): the_row(); ?>
                    <?php   $poster = get_sub_field('poster'); ?>
                    <?php   $name = get_sub_field('name'); ?>
                    <?php   $description = get_sub_field('description'); ?>
                    <div class="image-box overlay-effect3">
                        <?php if($poster): ?>
                        <figure>
                            <img src="<?php echo $poster['url'] ?>" alt="<?php echo $poster['alt']; ?>"
                                style="background-color: #575816;" />
                        </figure>
                        <?php endif; ?>
                        <div class="image-box-content">
                            <h3 class="title ">
                                <?php echo $name; ?>
                            </h3>
                            <div class="content">
                                <?php echo $description; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php endif; ?>

                </div>
                <?php endwhile; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>
<?php get_template_part( 'sidebar'); ?>

<?php
get_footer();

?>

