<?php


/* Initialisation de la variable que je souhaites récupérer */

function wpd_add_query_vars( $qvars ) {
    $qvars[] = 'edition';
    $qvars[] = 'type';
    return $qvars;
}
add_filter( 'query_vars', 'wpd_add_query_vars' );

/* Initialisation du rewriting de l'URL */

function wpd_page_rewrite(){
add_rewrite_rule( '^guests/([^/]*)/([^/]*)/?', 'index.php?pagename=guests&edition=$matches[1]&type=$matches[2]', 'top' );
}
add_action( 'init', 'wpd_page_rewrite' );

$variable1 = get_query_var('edition');
$variable2 = get_query_var('type');

function theme_register_assets(){
    wp_register_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css');
    wp_deregister_script('jquery');
    wp_register_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
    wp_enqueue_style('stylecss', get_stylesheet_uri());
}



// Exit if accessed directly XD
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'twenty-twenty-one-style','twenty-twenty-one-style','twenty-twenty-one-print-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );
add_action('wp_enqueue_scripts','theme_register_assets');

// END ENQUEUE PARENT ACTION

// CODE AJOUT POST VIA CSV //

/**
 * Ajout du bouton "insert Post" pour admin
 */
add_action("admin_notices", function () {
    echo "<div class='updated'>";
    echo "<p>";
    echo "To insert the posts into the database, click the button to the right.";
    echo "<a class='button button-primary' style='margin:0.25em 1em' href='{$_SERVER["REQUEST_URI"]}&insertion_csv_post'>Insert Posts</a>";
    echo "</p>";
    echo "</div>";
});


if (!function_exists('wp_dump')) :
    function wp_dump()
    {
        if (func_num_args() === 1) {
            $a = func_get_args();
            echo '<pre>', var_dump($a[0]), '</pre><hr>';
        } else if (func_num_args() > 1)
            echo '<pre>', var_dump(func_get_args()), '</pre><hr>';
        else
            throw Exception('You must provide at least one argument to this function.');
    }
endif;


/* Initialisation de la variable que je souhaites récupérer */
/**
function wpd_add_query_vars($qvars)
{
    $qvars[] = 'edition';
    return $qvars;
}
add_filter('query_vars', 'wpd_add_query_vars');
**/
/* Initialisation du rewriting de l'URL */
/**
function wpd_page_rewrite()
{
    add_rewrite_rule('^films/([^/]*)?', 'index.php?pagename=films&edition=$matches[1]', 'top');
}
add_action('init', 'wpd_page_rewrite');

$variable = get_query_var('edition');
**/


/**
 * Creation et insertion des posts depuis fichiers CSV
 */
add_action("admin_init", function () {
    global $wpdb;

    if (!isset($_GET["insertion_csv_post"])) {
        return;
    }


    $insert_post = array(
        "custom-field" => "post_attachment",
        "custom-post-type" => "film"
    );

    // Récupération des datas des CSV
    $posts = function () {
        $data = array();
        $errors = array();

        //tableau des fichiers CSV
        $files = glob(__DIR__ . "/data/exportwiki.csv");

        foreach ($files as $file) {

            // On tente de changer la permission si pas readable
            if (!is_readable($file)) {
                chmod($file, 0744);
            }

            //On check si le fichier est writable, puis on l'ouvre en mode 'read only'
            if (is_readable($file) && $_file = fopen($file, "r")) {

                // To sum this part up, all it really does is go row by
                //  row, column by column, saving all the data
                $post = array();

                // On recup la premiere ligne du csv (headers)
                $header = fgetcsv($_file);

                while ($row = fgetcsv($_file)) {

                    foreach ($header as $i => $key) {
                        $post[$key] = $row[$i];
                    }

                    $data[] = $post;
                }

                fclose($_file);
            } else {
                $errors[] = "File '$file' could not be opened. Check the file's permissions to make sure it's readable by your server.";
            }
        }

        if (!empty($errors)) {
            echo $errors;
        }

        return $data;
    };




    //On vérifie si le post existe déjà dans la db
    $post_exists = function ($post_name) use ($wpdb, $insert_post) {

        //on recup un tableau de tous les posts dans notre custom post type
        $posts = $wpdb->get_col("SELECT post_name FROM {$wpdb->posts} WHERE post_type = '{$insert_post["custom-post-type"]}'");

        //on vérifie si le titre existe dans le tableau
        return in_array($post_name, $posts);
    };

    //die(var_dump($posts()));

    foreach ($posts() as $post) {

        // Si le post existe déjà , on skip ce post et on passe au suivant
        if ($post_exists($post["post_name"])) {
            continue;
            // en cas d'update, ici <-
            //si pas d'update, impossible de rajouter des champs, car le test des doublons "continue" le code et skip l'entrée
        }

        $explodeGenre = explode("|", $post["attribute:pa_genre"]);
        //var_dump($explodeGenre);
        $genres_dyn = get_terms(
            'genre',
            array(
                'hide_empty' => false
            )
        );
        $genres = array();
        foreach ($genres_dyn as $gdyn) {
            $genres[$gdyn->name] = $gdyn->term_id;
        }

        $idGenres = array();
        foreach ($explodeGenre as $g) {
            //var_dump($g, $genres);
            if (array_key_exists($g, $genres)) {
                array_push($idGenres, $genres[$g]);
            } else {
                //the taxonomy does not exist --> create it
                $newid = wp_insert_term($g, "genre", sanitize_title($g));
                wp_dump($newid);
                array_push($idGenres, $newid["term_id"]);
            }
        }

        $explodePays = explode("|", $post["attribute:pa_country"]);
        var_dump($explodePays);
        $pays_dyn = get_terms(
            'pays',
            array(
                'hide_empty' => false
            )
        );

        $pays = array();
        foreach ($pays_dyn as $pdyn) {
            $pays[$pdyn->name] = $pdyn->term_id;
        }

        $idPays = array();
        foreach ($explodePays as $p) {
            //var_dump($g, $genres);
            if (array_key_exists($p, $pays)) {
                array_push($idPays, $pays[$p]);
            } else {
                //the taxonomy does not exist --> create it
                $newid4 = wp_insert_term($p, "pays", sanitize_title($p));
                //wp_dump($newid4);
                array_push($idPays, $newid4["term_id"]);
            }
        }



        //$explodeAnnee = explode ("|", $post["tax:product_cat"]);

        $CompetitionAttr = $post["attribute:pa_competitions"];

        $competition_dyn = get_terms(
            'competition',
            array(
                'hide_empty' => false
            )
        );

        $competition = array();
        foreach ($competition_dyn as $cdyn) {
            $competition[$cdyn->name] = $cdyn->term_id;
        }

        //var_dump($CompetitionAttr);

        $idCompetitions = array();
        if ($CompetitionAttr !== '') {
            if (array_key_exists($CompetitionAttr, $competition)) {
                array_push($idCompetitions, $competition[$CompetitionAttr]);
            } else {
                //the taxonomy does not exist --> create it
                $newid2 = wp_insert_term($CompetitionAttr, "competition", sanitize_title($CompetitionAttr));
                array_push($idCompetitions, $newid2["term_id"]);
            }
        }
        //var_dump($CompetitionAttr);

        //var_dump($explodeGenre);


        $year = explode("|movie", $post["tax:product_cat"]);
        //var_dump($year[0]);
        $editionPost = new WP_Query(array('post_type' => 'edition-post'));

        $edition_dyn = get_terms(
            'category',
            array(
                'hide_empty' => false
            )
        );
        //var_dump($edition_dyn);

        $edition = array();
        foreach ($edition_dyn as $medyn) {
            $edition[$medyn->name] = $medyn->term_id;
        }
        //var_dump($edition);
        $mapEdition = array();



        if ($editionPost->have_posts()) {
            while ($editionPost->have_posts()) {
                $editionPost->the_post();
                $postCourant = get_the_ID();
                $CategoryAllStats = (get_the_category($postCourant));
                //var_dump($CategoryAllStats);

                if (!empty($CategoryAllStats)) {
                    $yearCourant =  $CategoryAllStats[0]->cat_name;
                    // array_push($mapEdition, $postCourant, $yearCourant);
                    $mapEdition[$yearCourant] = $postCourant;
                }
                wp_reset_postdata();
            }
        }

        //DELETE FROM `wp_posts` WHERE `wp_posts`.`ID` > 380;

        // Add Featured Image to Post
        $image_url        = $post["images"]; // Define the image URL here
        $image_name       = preg_replace('/[^a-z0-9]/i', '', $post["post_name"]) . "_poster.jpg";
        $upload_dir       = wp_upload_dir(); // Set upload folder
        $image_data       = file_get_contents($image_url); // Get image data
        $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name
        $filename         = basename($unique_file_name); // Create image file name

        // Check folder permission and define file location
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }

        // Create the image  file on the server
        file_put_contents($file, $image_data);

        // Check image file type
        $wp_filetype = wp_check_filetype($filename, null);

        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => sanitize_file_name($filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Create the attachment

        $attach_id = wp_insert_attachment($attachment, $file, $post["ID"]);
        // var_dump($post["ID"]);

        // Include image.php
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);

        // Assign metadata to attachment
        wp_update_attachment_metadata($attach_id, $attach_data);

        // Insertion du post dans la database
        $post["ID"] = wp_insert_post(array(
            "post_title" => $post["post_name"],
            "post_content" => $post["post_content"],
            "post_type" => $insert_post["custom-post-type"],
            "attribute:pa_cast" => $post["attribute:pa_cast"],
            //"images" => $image_name,
            "post_status" => "publish"
        ));

        //test si l'année existe dans $mapEdition
        //si existe pas, creer nouveau post de type edition
        //associé l'année (setCategory sur le post edition)
        //ce nouveau post edition aura un ID que je devrais utiliser dans le update field


        set_post_thumbnail($post["ID"], $attach_id);

        // Update post's custom field

        //modif des "|" en ","
        $castingModif = str_replace("|",", ",$post["attribute:pa_cast"]);
        $directorModif = str_replace("|",", ",$post["attribute:pa_director"]);
        $distributorModif = str_replace("|",", ",$post["attribute:pa_distributor"]);
        $producerModif = str_replace("|",", ",$post["attribute:pa_producer"]);
        $screenplayModif = str_replace("|",", ",$post["attribute:pa_screenplay"]);
        $soundtracksModif = str_replace("|",", ",$post["attribute:pa_soundtracks"]);
        $subtitlesModif = str_replace("|",", ",$post["attribute:pa_subtitles"]);



        update_field('titre_original', $post["post_title"], $post["ID"]);
        update_field('entry-content', $post["post_content"], $post["ID"]);
        update_field('casting', $castingModif, $post["ID"]);
        update_field('field_603f90e6ce939', $directorModif, $post["ID"]);
        update_field('field_603f94b779937', $distributorModif, $post["ID"]);
        update_field('field_60587cba53381', $producerModif, $post["ID"]);
        update_field('field_60589719eb1b7', $screenplayModif, $post["ID"]);
        update_field('field_6058996df07e8', $soundtracksModif, $post["ID"]);
        update_field('field_603f8eda0fa62', $subtitlesModif, $post["ID"]);
        update_field('field_603f87eedc557', $post["attribute:pa_audience"], $post["ID"]);
        update_field('field_605895fd5de54', $post["attribute:pa_audio"], $post["ID"]);
        update_field('field_603f868edc555', $post["attribute:pa_premiere"], $post["ID"]);
        update_field('field_603f871fdc556', $idPays, $post["ID"]);

        update_field('field_60364d57c8199', $idGenres, $post["ID"]);

        //var_dump($mapEdition[$year]);
        //var_dump($mapEdition);
        //var_dump($year);

        if (!array_key_exists($year[0], $mapEdition)) {
            $newEditionID = wp_insert_post(array(
                "post_title" => "Edition" . $year[0],
                "post_type" => "edition-post",
                "post_status" => "publish"
            ));
            if (get_cat_ID($year[0]) == 0) {
                $newid3 = wp_insert_term($year[0], 'category', $args = array(
                    'parent' => 40
                ));
                // var_dump($newid3);
                // array_push($mapEdition, $newid3["term_id"]);
                wp_set_post_categories($newEditionID, array($newid3));
            } else {
                wp_set_post_categories($newEditionID, array(get_cat_ID($year[0])));
            }

            $mapEdition[$year[0]] = $newEditionID;
        }



        update_field('field_603f921144457', $mapEdition[$year[0]], $post["ID"]);
        $arrayCat = array(get_cat_ID($year[0]));
        //var_dump($arrayCat);
        wp_set_post_categories($post["ID"], $arrayCat);



        // update_field('field_6040fa15c7638', $year, $post["ID"]);
        // $repeaterBis = 'field_603f921144457';
        // $value = array(
        // 	array(
        // 		'field_603f921144457' => $year,
        // 	),
        // );
        // update_field($repeaterBis, $value, $post["ID"]);

        $repeater = 'field_6041fb8035075';
        $value = array(
            array(
                'field_6041fb9f35076' => $idCompetitions,
            ),

        );
        update_field($repeater, $value, $post["ID"]);
    }

    //Redirection pour clear l'url du &insertion_csv_post afin d'eviter le lancement de la fonction à chaque refresh
    $url = "http://localhost/wikibifff/wp-admin";
    //wp_redirect($url);
    exit;
});
