<?php

/**
 * Template Name: Films
 * Template Post Type: post,page,edition-post,guest,film
 */

get_header(); ?>

<?php $loop = new WP_Query( array( 'post_type' => 'films', 'posts_per_page' => 5, 'paged' => $paged) ); ?>

 <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

 <?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); ?>

 <div class="entry-content">
 <?php the_content() ; ?>
 </div>

 <?php endwhile ; ?>
<?php get_footer(); ?>
