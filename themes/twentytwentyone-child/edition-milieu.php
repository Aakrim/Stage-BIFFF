<main class="container">
    <div><h2>COMPETITION WINNERS</h2></div>
    <div class="mb-2 row" text-white rounded bg-dark>
        <!--
            * afficher les winners films d'une edition
            * problème d'image réglé
            * faut encore afficher les la compéttion(taxonomy) et le prix(taxonomy)
        -->
        <?php
        $posts = get_field('film');
        if ($posts): ?>
        <ul>
            <div class="row">
                <?php foreach ($posts as $post): ?>
                <div class="col-md-3">
                    <?php if (get_field('participations_aux_competitions')) : ?>
                    <?php setup_postdata($post); ?>
                    <div class="mb-4 overflow-hidden border rounded shadow-sm row g-0 flex-md-row h-md-250 position-relative">
                        <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
                        <img style="width:200px ; height:200px;" src="<?php the_post_thumbnail(); ?>
                                 <h5> Competition :   <?php the_terms(get_the_ID(), 'competition'); ?></h5>
                                 <h5> Prix :   <?php the_terms(get_the_ID(), 'prix'); ?></h5>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
        <div class="invites">
                        <ol class="mb-0 list-unstyled">
                            <li><a>Lien vers la liste des films winners de l'édition</a></li>
                        </ol>
                    </div>
                </div>

                <!--Invités-->

                <!--
                        * afficher les invités de l'édition avec le nom, prenom et type d'invitation(taxonomy)
                 -->
                <div><h2>JURE PRESIDENTS AND GUESTS OF HONNOR</h2></div>
                <div class="mb-2 row" text-white rounded bg-dark>
                    <?php
                    $posts = get_field('invites');
                    if ($posts): ?>
                    <ul>
                        <div class="row">
                            <?php foreach ($posts as $post):; ?>
                            <div class="col-md-3">
                                <?php setup_postdata($post); ?>
                                <div class="mb-4 overflow-hidden border rounded shadow-sm row g-0 flex-md-row h-md-250 position-relative">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                        <img style="width:200px ; height:200px;" src="<?php the_post_thumbnail(); ?>
                                        <p><?php the_field('nom'); ?></p>
                                        <p><?php the_field('prenom'); ?></p>
                                        <h5> Type d'invitation :   <?php the_terms(get_the_ID(), 'guest_type'); ?></h5>
                                    </a>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
    <div class="invites">
                                        <ol class="mb-0 list-unstyled">
                                            <li><a>Lien vers la liste des invités</a></li>
                                        </ol>
                                </div>
</main><!-- /.container -->