<?php

function theme_register_assets(){
    wp_register_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css');
    wp_deregister_script('jquery');
    wp_register_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
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


	//****** Partie problematique, l'ajout se fait même si le post existe déjà ******

	//On vérifie si le post existe déjà dans la db	
	$post_exists = function ($post_title) use ($wpdb, $insert_post) {

		//on recup un tableau de tous les posts dans notre custom post type
		$posts = $wpdb->get_col("SELECT post_title FROM {$wpdb->posts} WHERE post_type = '{$insert_post["custom-post-type"]}'");

		//on vérifie si le titre existe dans le tableau
		return in_array($post_title, $posts);
	};

	foreach ($posts() as $post) {
		// Si le post existe déjà , on skip ce post et on passe au suivant
		if ($post_exists($post["post_title"])) {
			continue;
		}

		//****** Fin partie problematique ******




		// Insertion du post dans la database
		$post["ID"] = wp_insert_post(array(
			"post_title" => $post["post_name"],
			//	"product_cat"=>$post["post_cat"],
			//	"post_content" => $post["post_content"],
			"post_type" => $insert_post["custom-post-type"],
			"post_status" => "publish"
		));


		// Update post's custom field
		// var_dump($post);

		update_field('titre_original', $post["post_title"], $post["ID"]);
	}

	//Redirection pour clear l'url du &insertion_csv_post afin d'eviter le lancement de la fonction à chaque refresh
	
	$url = "http://localhost/PHP/wikibiffLocal/wp-admin/edit.php?post_type=film";
	wp_redirect($url);
	exit;
});