
<main class="container">

    <div class="mb-2 row">

        <div class="col-md-3">
            <div class="p-4 mb-3 rounded bg-light">
                <h4 class="fst-italic"><?php the_terms(get_the_ID(), 'category'); ?>
                    -<?php the_field('nom'); ?></h4>
                <p class="mb-0"><?php the_field('description'); ?></p>
            </div>

            <div class="p-4">

                <a href="#" class="singleFilmButton">WATCH TRAILER</a>
                <div class="singleFilmButton"> <?php the_terms(get_the_ID(), 'category'); ?> MOVIE LIST</div>
                <a href="http://localhost/wikibifff/films/" class="singleFilmButton">BIFFF MOVIE LIST</a>
            </div>

            <div class="p-4">
                <h4 class="fst-italic">Elsewhere</h4>
                <ol class="list-unstyled">
                    <li><a href="#">Watch Triller</a></li>
                    <li><a href="#">Liste des films</a></li>
                    <li><a href="#">Liste des invité</a></li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-4 overflow-hidden border rounded shadow-sm row g-0 flex-md-row h-md-250 position-relative">
                <div class="p-4 col d-flex flex-column position-static">
                <?php while(have_posts()) : the_post();?>
                <h2 class="mb-0"><?php the_title(); ?> </h2>
                        <?php the_post_thumbnail('medium'); ?>
                        <p class="mb-auto">
                            <?php the_field('description'); ?>
                        </p>
                    <?php endwhile;?>
                </div>
            </div>
            <div class="mb-6 row">
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                    </ol>
                </div>
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                    </ol>
                </div>
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                    </ol>
                </div>
            </div>

            <div class="mb-6 row">
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Film d'ouverture</a></li>
                    </ol>
                    <h5>Image Image Image</h5>
                    <h5>Image Image Image</h5>
                    <h5>Image Image Image</h5>
                </div>
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Film de cloture</a></li>
                    </ol>
                    <h5>Image Image Image</h5>
                    <h5>Image Image Image</h5>
                    <h5>Image Image Image</h5>
                </div>
                <div class="col-md-4">
                    <ol>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                        <li><a href="#">Watch Triller</a></li>
                        <li><a href="#">Liste des films</a></li>
                        <li><a href="#">Liste des invité</a></li>
                    </ol>
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <div class="p-4 mb-3 rounded bg-light">
                <h4 class="fst-italic"><?php the_terms(get_the_ID(), 'category'); ?>
                    -<?php the_field('nom'); ?></h4>
                <p class="mb-0"><?php the_field('description'); ?></p>
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
