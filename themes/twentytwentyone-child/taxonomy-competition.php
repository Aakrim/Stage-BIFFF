<?php get_header()?>

<?php $competitions = get_terms(['taxonomy'=> 'competition']); ?>
<ul class="nav nav-pills my-4">
    <?php foreach ($competitions as $competition): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= get_term_link($competition)?>" <?= is_tax('competition',$competition->term_id) ? 'active' : '' ?>"><?= $competition->name ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<?php if(have_posts()) : ?>
    <h1><?= get_queried_object()->name?></h1>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
        <div class="col-md-4">
            <div class="card-group">
                <div class="card">
                    <img class="card-img-top" style="width: 350px;height: 300px" src="<?php the_post_thumbnail('post-thumbnail',['class'=>'card-img-top','alt'=>'','style'=>'height: auto;']); ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_field('titre_original'); ?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><?php the_field('realisateur'); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
<?php endif;?>























<?php get_footer()?>

