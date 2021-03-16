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
add_rewrite_rule( '^guests/([^/]*)?', 'index.php?pagename=guests&edition=$matches[1]&type=$matches[2]', 'top' );
}
add_action( 'init', 'wpd_page_rewrite' );

$variable1 = get_query_var('edition');
$variable2 = get_query_var('type');

/**
 * @param WP_Query $query
 */
/**
function fun_pre_get_posts ($query) {
    if(is_admin() || !is_home() || !$query->is_main_query()){
        return;
    }
    if(get_query_var('guest_type')===1){
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => guest_typeMetaBox::META_KEY,
            'compare' => 'EXISTS',
        ];
        $query->set('meta_query',$meta_query);
    }

}
function montheme_query_vars($param){
    $param[] = 'guest_type';
    return $param;
}
add_action('pre_get_posts','fun_pre_get_posts');
add_filter('query_vars','montheme_query_vars');
**/
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


	

	//On vérifie si le post existe déjà dans la db	
	$post_exists = function ($post_name) use ($wpdb, $insert_post) {

		//on recup un tableau de tous les posts dans notre custom post type
		$posts = $wpdb->get_col("SELECT post_name FROM {$wpdb->posts} WHERE post_type = '{$insert_post["custom-post-type"]}'");				

		//on vérifie si le titre existe dans le tableau
		return in_array($post_name, $posts);
	};
	
	foreach ($posts() as $post) {

		// Si le post existe déjà , on skip ce post et on passe au suivant
		if ($post_exists($post["post_name"])) {
			continue;
			// en cas d'update, ici <-
			//si pas d'update, impossible de rajouter des champs, car le test des doublons "continue" le code et skip l'entrée
		}
	
		// Insertion du post dans la database
		$post["ID"] = wp_insert_post(array(
			"post_title" => $post["post_name"],	
			//permet de remove le 2015| de 2015|movie	
			//"product_cat" => substr(strrchr($post["tax:product_cat"],"|"), 1), A VOIR PLUS TARD
			"post_content" =>$post["post_content"],
			"post_type" => $insert_post["custom-post-type"],
			"attribute:pa_cast" => $post["attribute:pa_cast"],
			"attribute:pa_genre" => $post["attribute:pa_genre"],			
			"post_status" => "publish"
		));

		// Update post's custom field
		// var_dump($post);

		update_field('titre_original', $post["post_title"], $post["ID"]);
		update_field('entry-content', $post["post_content"], $post["ID"]);
		update_field('casting', $post["attribute:pa_cast"], $post["ID"]);
		update_field('field_60364d57c8199', array(50), $post["ID"]);
	}

	//Redirection pour clear l'url du &insertion_csv_post afin d'eviter le lancement de la fonction à chaque refresh

	$url = "http://localhost/PHP/wikibisLocal/wp-admin/edit.php?post_type=film";
	wp_redirect($url);
	exit;
});
