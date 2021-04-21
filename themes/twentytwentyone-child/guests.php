<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://use.fontawesome.com/826a7e3dce.js"></script>
</head>

<h1>Invités:</h1>

<div class="englobe">
    <div class="customPrevBtn"><i class="fas fa-chevron-circle-left fa-2x"></i></div>
    <div class="carousel-wrap">
        <div class="owl-carousel">
            <?php
                /**
                    afficher les invités par edition et par type
                **/
            $edition = get_query_var('edition');
            $type_guest = get_query_var('type');
            if ($type_guest==='') {
                $loop = new WP_Query(array('post_type' => 'guest ', 'posts_per_page' => 5));
            } else {
                $loop = new WP_Query(array(
                        'post_type' => 'guest',
                        'meta_key'   => 'edition',
                         'meta_value' => $edition,
                        'meta_compare'=> 'LIKE',
                        'posts_per_page' => 5,
                        'tax_query' => [
                    [
                        'taxonomy' => 'guest_type',
                        'field' => 'slug',
                        'terms' => $type_guest,
                    ]
                ]
                       ));
            }
            ?>
            <?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <div class="item">
                <span class="titreFilm"> <?php the_title(); ?></span>
                <a href="<?php the_permalink(); ?>">
                    <img style="width:360px; height:500px;" src="<?php the_post_thumbnail(); ?>
          </a>

          </div>
<?php endwhile; ?>

    </div>
  </div>
  <div class=" customNextBtn"><i class="fas fa-chevron-circle-right fa-2x"></i>
            </div>
        </div>


        <script>
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                autoplay: false,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            })

            var owl = $('.owl-carousel');
            owl.owlCarousel();
            // Go to the next item
            $('.customNextBtn').click(function () {
                owl.trigger('next.owl.carousel');
            })
            // Go to the previous item
            $('.customPrevBtn').click(function () {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                owl.trigger('prev.owl.carousel', [300]);
            });
        </script>