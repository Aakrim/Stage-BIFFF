<?php get_header() ?>
<?php
/**
 * Menu des compétitions
 */
?>
<?php $competitions = get_terms(['taxonomy' => 'competition']); ?>
<ul class="nav nav-pills my-4">
    <?php foreach ($competitions as $competition): ?>
        <li class="nav-item">
            <a class="nav-link"
               href="<?= get_term_link($competition) ?>" <?= is_tax('competition', $competition->term_id) ? 'active' : '' ?>
            "><?= $competition->name ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
/**
 * Filtrer les compétitions par numéro ode l'édition
 */
$compt = get_query_var('competition');
$id = get_query_var('edition');
$loop = new WP_Query(array(
    'post_type' => 'film',
    'meta_key' => 'edition',
    'meta_value' => $id,
    'meta_compare' => 'LIKE',
    'posts_per_page' => 5,
    'tax_query' => [
        [
            'taxonomy' => 'competition',
            'field' => 'slug',
            'terms' => $compt,
        ]
    ]
));

/**
 * Afficher les films
 */
?>
<?php if (have_posts()) : ?>
    <h1><?= get_queried_object()->name ?></h1>
    <div class="row">
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
        <div class="col-md-4">
            <div class="card-group">
                <div class="card">
                    <img class="card-img-top" style="width: 350px;height: 300px"
                         src="<?php the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']); ?>
                    <div class=" card-body">
                    <h5 class="card-title"><?php the_field('titre_original'); ?></h5>
                    <p class="card-text"><?php the_excerpt(); ?></p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?php the_field('realisateur'); ?></small>
                </div>
                <div class="card-footer">
                    <?php if (get_field('participations_aux_competitions')) : ?>
                        <small class="text-muted">Prix : <?php the_terms(get_the_ID(), 'prix'); ?></small>
                    <?php endif ?>
                </div>
            </div>
        </div>
        </div>
    <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>


<?php
/**
 * Les invités
 */
$query = new WP_Query([
    'post_type' => 'edition-post',
    'posts_per_page' => 5,
]);
?>
<h1>
    Les invités de l'édition:
</h1>
<div class="row">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <?php $guests = get_field('invites');
        if (is_array($guests)) {
            foreach ($guests as $guest) { ?>
                <div class="col-md-4">
                    <div class="card-group">
                        <div class="card">
                            <a <?php the_permalink(); ?>> <img class="card-img-top" style="width:350px ; height:300px;"
                                                               src="<?php echo get_the_post_thumbnail_url($guest->ID, 'thumbnail') ?>"/></a>
                            <div class=" card-body">
                            </div>
                            <div class="card-footer">
                                <a href="<?php the_permalink(); ?>"><h5
                                            class="card-title"> <?php echo $guest->post_title; ?></h5></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    <?php endwhile;
    wp_reset_postdata(); ?>
</div>
