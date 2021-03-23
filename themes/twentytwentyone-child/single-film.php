<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://use.fontawesome.com/826a7e3dce.js"></script>
</head>

<?php get_header() ?>

<main class="container">

    <div class="mb-2 row">

        <div class="col-md-4">
            <div class="p-4 mb-3 ">
                <?php if (have_posts()): while (have_posts()) :
                the_post(); ?>
                <h4 class="fst-italic"><?php the_field('titre_original'); ?></h4>
                <img style="width:400px ; height:550px;"
                     src="https://archives.bifff.net/wp-content/uploads/2015/02/bloodmoon_poster.jpg">
            </div>
            <?php endwhile; ?>
            <?php endif ?>
            <div class="p-4">
                <div class="bouton">
                    <ul>
                        <li><a href="#">Bande d'annoce</a></li>
                        <li><a href="#">Liste des invités</a></li>
                        <li><a href="#">Liste des prix</a></li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-4 overflow-hidden border rounded shadow-sm row g-0 flex-md-row h-md-250 position-relative">
                <div class="p-4 col d-flex flex-column position-static">
                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                        <h2 class="mb-0" style="text-align: center"><?php the_field('titre_original'); ?> </h2>
                        <p class="mb-auto"><?php the_content(); ?></p>
                    <?php endwhile; ?>
                    <?php endif ?>
                </div>
                <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                    <h3 class="fst-italic" ><p style="text-align: center">Titre: <?php the_field('titre_original'); ?></p></h3>
                    <h3 class="fst-italic"><p style="text-align: center">Les acteurs: <?php the_field('casting'); ?></p></h3>
                    <h3 class="fst-italic"><p style="text-align: center">Le genre: <?php the_terms(get_the_ID(), 'genre'); ?></p></h3>
                    <h3 class="fst-italic"><p style="text-align: center">Le réalisateur: <?php the_field('realisateur'); ?></p></h3>
                <?php endwhile; ?>
                <?php endif ?>
                <?php

                /**
                 * afficher les invités par edition et par type
                 **/

                $loop = new WP_Query(array(
                    'post_type' => 'film',
                    'posts_per_page' => 3,
                ));
                ?>

                <div>
                    <h3>Article Relatifs: </h3>
                </div>
                <?php while ($loop->have_posts()):
                    $loop->the_post(); ?>

                    <div class="col-md-4">
                        <h4><?php the_title() ?></h4>
                        <p><img style="width:170px; height:200px;" src="<?php the_post_thumbnail(); ?>"></p>
                    </div>
                <?php endwhile; ?>
            </div>


        </div>

        <div class=" col-md-2">
            <div class="p-4 mb-3 rounded bg-light">
                <h4 class="fst-italic">2021 Edition 39</h4>
                <p class="mb-0">Saw you downtown singing the Blues. Watch you circle the drain. Why don't you
                    let me
                    stop by? Heavy is the head that <em>wears the crown</em>. Yes, we make angels cry, raining
                    down on
                    earth from up above.</p>
            </div>

            <div class="p-4">
                <h4 class="fst-italic">Archives</h4>
                <ol class="mb-0 list-unstyled">
                    <li><a href="#">March 2014</a></li>
                    <li><a href="#">February 2014</a></li>
                    <li><a href="#">January 2014</a></li>
                    <li><a href="#">December 2013</a></li>
                    <li><a href="#">November 2013</a></li>
                    <li><a href="#">October 2013</a></li>
                    <li><a href="#">September 2013</a></li>
                    <li><a href="#">August 2013</a></li>
                    <li><a href="#">July 2013</a></li>
                    <li><a href="#">June 2013</a></li>
                    <li><a href="#">May 2013</a></li>
                    <li><a href="#">April 2013</a></li>
                </ol>
            </div>


        </div>

    </div>

</main><!-- /.container -->

<?php get_footer(); ?>
