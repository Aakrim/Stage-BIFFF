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
                <img style="width:400px ; height:450px;"
                     src="<?php the_post_thumbnail(); ?>
            </div>
            <?php endwhile; ?>
            <?php endif ?>
                <div class=" bouton">
                <ul>
                    <li><a href="#">Bande d'annoce</a></li>
                    <li><a href="#">Liste des invités</a></li>
                    <li><a href="#">Liste des prix</a></li>
                </ul>
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

                    <?php        $editions = get_field('edition');
                    var_dump($editions); ?>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Edition</th>
                            <th scope="col">Casting</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Compétition</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php the_field('titre_original'); ?></td>
                            <td>
                                <?php
                                $editions = get_field('edition');

                                foreach ($editions as $edition) {
                                    $edition_name = $edition->post_title;
                                    echo $edition_name;
                                }
                                ?>
                            </td>
                            <td><?php the_field('casting'); ?></td>
                            <td><?php the_terms(get_the_ID(), 'genre'); ?></td>
                            <td><?php the_terms(get_the_ID(), 'competition'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                <?php endwhile; ?>
                <?php endif ?>
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
    <div class="mb-2 row">
        <div class="col-md-6">

        </div>
        <?php $loop = new WP_Query(array('post_type' => 'film', 'posts_per_page' => 3,)); ?>
        <div class="ab-label">
            <h3>Article Relatifs: </h3>
        </div>
        <?php while ($loop->have_posts()):
        $loop->the_post(); ?>
        <div class="col-md-4">
            <div class="card-group">
                <div class="card">
                    <img class="card-img-top" style="width: 350px;height: 300px"
                         src="<?php the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']); ?>
                    <div class=" card-body">
                    <h5 class="card-title"><?php the_field('titre_original'); ?></h5>
                    <p class="card-text"><?php the_excerpt(); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
    </div>
    </div>
</main><!-- /.container -->

<?php get_footer(); ?>
