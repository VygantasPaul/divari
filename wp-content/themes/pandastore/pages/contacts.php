<?php

/* Template Name: Contacts page */

get_header();



?>

<main class="main">
    <div class="page-content contact-page">
        <div class="container">
            <?php if (have_rows('contact_information')) : ?>
            <?php while (have_rows('contact_information')) : the_row(); ?>
            <?php $heading = get_sub_field('heading'); ?>
            <section class="mt-10 pt-8">
                <h2 class="title title-center mb-8">
                    <?php echo $heading ?>
                </h2>
                <div class="owl-carousel owl-theme row cols-lg-4 cols-md-3 cols-sm-2 cols-1 mb-10" data-owl-options="{
                                'nav': false,
                                'dots': true,
                                'loop': false,
                                'margin': 20,
                                'autoplay': true,
                                'responsive': {
                                    '0': {
                                        'items': 1,
                                        'autoplay': true
                                    },
                                    '576': {
                                        'items': 2
                                    },
                                    '768': {
                                        'items': 3
                                    },
                                    '992': {
                                        'items': 4,
                                        'autoplay': false
                                    }
                                }
                            }">
                    <?php if (have_rows('contact_column')) : ?>
                    <?php while (have_rows('contact_column')) : the_row(); ?>
                    <?php $icon = get_sub_field('icon'); ?>
                    <?php $title = get_sub_field('title'); ?>
                    <?php $additional_info = get_sub_field('additional_info'); ?>
                    <div class="icon-box text-center">
                        <span class="icon-box-icon mb-4">
                            <i class="<?php echo $icon ?>"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title">
                                <?php echo $title ?>
                            </h4>
                            <p class="text-dim">
                                <?php echo $additional_info ?>
                            </p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <hr>
            </section>
            <?php endwhile; ?>
            <?php endif; ?>
            <?php if (have_rows('contact_form')) : ?>
            <?php while (have_rows('contact_form')) : the_row(); ?>
            <?php $poster = get_sub_field('poster'); ?>
            <?php $cantact_form_title = get_sub_field('cantact_form_title'); ?>
            <?php $contact_form_subtitle = get_sub_field('contact_form_subtitle'); ?>
            <?php $contact_form = get_sub_field('contact_form'); ?>
            <section class="mt-10 pt-2 mb-10 pb-8">
                <div class="row align-items-center  align-items-center">
                    <div class="col-md-6">
                        <?php if ($poster) : ?>
                        <figure>
                            <img src="<?php echo $poster['url'] ?>" alt="<?php echo $poster['alt'] ?>" />
                        </figure>
                        <?php endif; ?>
                    </div>
                    <div class=" col-md-6 pl-md-4 mt-8 mt-md-0 pt-3">
                        <h2 class="title mb-1">
                            <?php echo $cantact_form_title ?>
                        </h2>
                        <p class="mb-2"> <?php echo $contact_form_subtitle ?> </p>
                        <?php echo $contact_form ?>
                    </div>
                </div>
            </section>
            <?php endwhile; ?>
            <?php endif; ?>

        </div>

    </div>
</main>
<?php get_template_part('sidebar'); ?>

<?php
get_footer();

?>
<script>
jQuery(document).ready(function() {
    
    jQuery('.wpcf7-form').on('submit', function(event) {
        var $form = jQuery(this); // Store a reference to the form element

        $form.find('.wpcf7-submit').attr('disabled', true);

        setTimeout(function() {
            $form.find('.wpcf7-submit').attr('disabled', false);
        }, 5000); // Adjust timeout duration as needed (in milliseconds)
    });

});
</script>
