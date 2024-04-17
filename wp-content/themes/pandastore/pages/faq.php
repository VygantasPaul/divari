<?php

/* Template Name: FAQ page */

get_header()
?>



<main class="main">
    <div class="page-content faq-page">
        <main class="main">
            <?php if (have_rows('repeater_sections')) : ?>
                <?php $section_counter = 0; ?>
                <?php while (have_rows('repeater_sections')) : the_row(); ?>
                    <?php $heading = get_sub_field('heading'); ?>
                    <section class=" pt-7 mt-10 pb-7 mb-10 <?php echo ($section_counter % 2 === 0) ? 'even-section' : 'odd-section'; ?>" >  
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                            <h2 class="title text-capitalize justify-content-center text-center mb-4">
                            <?php echo $heading ?>
                        </h2>
                        <div class="accordion accordion-simple">
                            <?php if (have_rows('content')) : ?>
                                <?php $counter = 0; ?>
                                <?php while (have_rows('content')) : the_row(); ?>
                                    <?php $subtitle = get_sub_field('subtitle'); ?>
                                    <?php $content = get_sub_field('content'); ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#<?php echo sanitize_title($subtitle); ?>" class="<?php echo ($counter) === 0 ? 'collapse' : 'expand' ?>"><?php echo $subtitle ?></a>
                                        </div>
                                        <div id="<?php echo sanitize_title($subtitle); ?>" class="card-body <?php echo ($counter) === 0 ? 'expanded' : 'collapsed' ?>">
                                            <?php echo $content ?>
                                        </div>
                                    </div>
                                    <?php $counter++; ?>    
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                            </div>
                        </div>
                 
                        </div>
                    </section>
                    <?php $section_counter++; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </main>
    </div>
</main>
<?php get_template_part('sidebar'); ?>

<?php
get_footer();

?>

