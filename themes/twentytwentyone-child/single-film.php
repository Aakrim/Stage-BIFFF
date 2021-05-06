<?php get_header() ?>


<div class="singleFilmContainer">

    <div class="singleFilmLeft">
        <img class="singleFilmImg" src="<?php the_post_thumbnail(); ?>

        <div class="singleFilmButtonBox">
        <a href="#" class="singleFilmButton">WATCH TRAILER</a>
        <div class="singleFilmButton"> <?php the_terms(get_the_ID(), 'category'); ?> MOVIE LIST</div>
        <a href="http://localhost/wikibifff/films/" class="singleFilmButton">BIFFF MOVIE LIST</a>

        </div>

    </div>

    <div class="singleFilmRight">

        <div class="singleFilmRightDesc">
            <h1><?php the_field('titre_original');?></h1>
            <p> <?php the_field('entry-content');?></p>
            <p>Pays : <?php the_terms(get_the_ID(), 'pays'); ?></p>

            <p>Casting : <?php the_field('casting');?></p>
            <p>Audio : <?php the_field('audio');?></p>
            <p>Sous-titres : <?php the_field('sous-titres');?></p>
            <p>Producteur :  <?php the_field('producteur');?></p>
            <p>Réalisateur : <?php the_field('realisateur');?></p>
            <p>Scénariste : <?php the_field('scenariste');?></p>
            <p>Bande-originale : <?php the_field('bande_originale');?></p>
            <p>Distributeur : <?php the_field('distributeur');?></p>




               <?php
                $categoryTest = get_the_category();
               // var_dump($categoryTest);
                $loop = new WP_Query(array('post_type' => 'edition-post' , 'category_name'=> $categoryTest[0]->name));
               // var_dump($categoryTest[0]->name);


                while ($loop->have_posts()) :
                $loop->the_post();

                ?> <p>Edition : <a href="<?php the_permalink(); ?>"> <?php echo strip_tags($categoryTest[0]->name) ?></a> </p>

                <?php endwhile ?>









        </div>


    </div>


</div>

<?php get_footer(); ?>
