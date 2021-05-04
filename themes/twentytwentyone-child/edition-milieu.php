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
                <?php foreach ($posts

                as $post): ?>

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




                    <section id="guestos">
                    <div class="container my-3 py-5 text-center">
                        <div class="row mb-5">
                            <div class="col">
                                <h1>JURE PRESIDENTS AND GUESTS OF HONNOR</h1>
                                <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet
                                    doloremque doloribus ea eos illum, labore molestias mollitia quam quas
                                    similique.</p>
                            </div>
                        </div>

                        <div class="row">
                            <?php


                       //     $loop = new WP_Query(array('post_type' => 'guest', 'tax_query' => [
                        //        'taxonomy' => 'category',
                         //       'field'=>'annee',
                         //       'terms'=>'2021'
                          //  ]

                           // ));
                            $anneeGuest =  strip_tags((get_the_term_list(get_the_ID(), 'category')));

                            $loop = new WP_Query(array('post_type' => 'guest' , 'category_name'=> $anneeGuest

                             ));

                            while ($loop->have_posts()) :
                            $loop->the_post();

                            //$loop = new WP_Query(array('post_type' => 'guest'));

                            //var_dump($loop);
                            ?>


                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="https://via.placeholder.com/150x150" alt=""
                                             class="img-fluid rounded-circle w-50 mb-3 m-auto">
                                        <h3><?php the_field('nom'); the_field('prenom')?> </h3>
                                        <h5><?php
                                        $idGuest = get_the_ID();
                                        $nameGuest = get_the_terms($idGuest,'guest_type');
                                        echo $nameGuest[0]->name;
                                        ?></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, reiciendis.</p>
                                        <hr/>
                                        <a href="#" style="text-decoration:none;color:red;"><h3>MORE INFO</h3></a>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile ?>
                        </div>
                    </div>

                    <a href="#" class="juryGuestListBar">2020 JURY/GUESTS LIST</a>
                </section>


                <div class="mb-2 row" text-white rounded bg-dark>
                    <?php
                    $posts = get_field('invites');
                    if ($posts): ?>
                    <ul>
                        <div class="row">
                            <?php foreach ($posts

                            as $post):; ?>
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

</main><!-- /.container -->