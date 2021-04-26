<!-- http://localhost/wikibifff/edition-post/  -->

<?php get_header() ?>

<div class="container-fluid align-items-center">
    <?php $i = 1; ?>
    <?php query_posts($query_string . '&orderby=title&order=DESC');?>
    <?php if (have_posts()) : while (have_posts()) : the_post();
            $i++;  ?>

            <?php if ($i % 2 == 0) { ?>
            
                <div class="row mainRow">
                    <div class="col-sm content">
                        <div class="boxLeft mb-3">
                       <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 184.06 129.84" style="enable-background:new 0 0 184.06 129.84;" xml:space="preserve" class="svgTriangle">
                                        <defs>
                                        <filter id="shadow1">
                                                <feDropShadow dx="4" dy="-5" stdDeviation="5" floodColor="#000000" floodOpacity="0.5" />
                                            </filter>
                                            <filter id="shadow2">
                                                <feDropShadow dx="4" dy="5" stdDeviation="5" floodColor="#000000" floodOpacity="0.5" />
                                            </filter>
                                        </defs>
                                        <polygon  points="190,19.54 80.4,64.77 190,110" />
                                    </svg>
            
                            <div class="box-container p-2">
                                <div class="box-img">
                                    <img src=<?php the_post_thumbnail('full', array('class' => 'imgHeight')); ?> >
                                </div>
                                <div class="box-descr">
                           

                                    <h4 class="fst yearNom"><?php the_terms(get_the_ID(), 'category'); ?>-<?php the_field('nom'); ?></h4>
                                    <p><?php the_field('description'); ?></p>
                                    <a href="#" class="box-button">CTA</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto text-center d-flex justify-content-center flex-wrap">
                        <div class="timeline-bar"></div>
                        <div class="years">
                            <?php the_terms(get_the_ID(), 'category'); ?>
                        </div>

                    <?php } ?>

                    <?php if ($i % 2 !== 0) { ?>

                        <div class="years">
                            <?php the_terms(get_the_ID(), 'category'); ?>
                        </div>
                    </div>


                    <div class="col-sm content">
                        <div class="boxRight mb-5">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 184.06 129.84" style="enable-background:new 0 0 184.06 129.84;" xml:space="preserve" class="svgTriangle2">
                                        <defs>
                                            <filter id="shadow1">
                                                <feDropShadow dx="4" dy="-5" stdDeviation="2" floodColor="#000000" floodOpacity="0.5" />
                                            </filter>
                                            <filter id="shadow2">
                                                <feDropShadow dx="4" dy="5" stdDeviation="2" floodColor="#000000" floodOpacity="0.5" />
                                            </filter>
                                        </defs>
                                        <polygon  points="190,19.54 80.4,64.77 190,110" />
                                    </svg>
            
                            <div class="box-container p-2">
                                <div class="box-img">
                                <img src=<?php the_post_thumbnail('full', array('class' => 'imgHeight')); ?>
                                </div>
                                <div class="box-descr">

                                    <h4 class="fst yearNom"><?php the_terms(get_the_ID(), 'category'); ?>-<?php the_field('nom'); ?></h4>
                                    <p><?php the_field('description'); ?></p>
                                    <a href="#" class="box-button">CTA</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php }  ?>

        <?php endwhile; ?>
    <?php endif ?>
    <?php wp_reset_query(); ?>
</div>










<?php get_footer() ?>