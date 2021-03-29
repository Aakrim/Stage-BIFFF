<!-- http://localhost/wikibifff/edition-post/  -->

<?php get_header() ?>
<?php 
      $term = get_queried_object();

      $children = get_terms( 'category', array(
          'annee'    => $term->term_id,
          'hide_empty' => false
      ) );
  
   //  echo '<li>'. $children .'</li>';
   //var_dump($children);

?>

<div class="container align-items-center">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>      
   
            <div class="row p-5">
                <div class="col-sm content">   
                    <?php 
                      if(intval(the_terms( get_the_ID() , 'category')) % 2 === 0)  {
                          ?>
                    <div class="boxLeft mb-5"><h4 class="fst-italic"><?php the_field('nom'); ?></h4> </div>
                    <?php } ?>

                </div>
                <div class="col-sm-auto">
                    <div class="timeline-bar"></div>
                    <div class="years"><?php the_terms( get_the_ID() , 'category'); ?></div>
                    <div class="years"><?php the_terms( get_the_ID() , 'category'); ?></div>
                </div>  
                <div class="col-sm content">
                <?php 
                      if( intval(the_terms( get_the_ID() , 'category')) % 2 !== 0)  {
                          ?>
                    <div class="boxLeft mb-5"><h4 class="fst-italic"><?php the_field('nom'); ?></h4> </div>
                    <?php } ?>
                   
                </div>
            </div>

        <?php endwhile; ?>
    <?php endif ?>
</div>










<?php get_footer() ?>