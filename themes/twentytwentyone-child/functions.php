<?php

function theme_register_assets(){
    wp_register_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css');
    wp_deregister_script('jquery');
    wp_register_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
	wp_enqueue_style( 'stylecss', get_stylesheet_uri() ); 
}

/**
function capitaine_rewrite_url() {

    add_rewrite_tag( '%film%','([^&]+)' );
    add_rewrite_tag( '%guest%','([^&]+)' );

    add_rewrite_rule(
        'edition/([^/]+)/([^/]+)/([^/]+)',
        'index.php?post_type=edition&guest=$matches[1],&film=$matches[2]', 'top'
    );
}
add_action( 'init', 'capitaine_rewrite_url' );
**/
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


if(!function_exists('wp_dump')) :
    function wp_dump(){
        if(func_num_args() === 1)
        {
            $a = func_get_args();
            echo '<pre>', var_dump( $a[0] ), '</pre><hr>';
        }
        else if(func_num_args() > 1)
            echo '<pre>', var_dump( func_get_args() ), '</pre><hr>';
        else
            throw Exception('You must provide at least one argument to this function.');
    }
endif;


/* Initialisation de la variable que je souhaites récupérer */
function wpd_add_query_vars( $qvars ) {
	$qvars[] = 'edition';
	return $qvars;
	
  }
  add_filter( 'query_vars', 'wpd_add_query_vars' );
  
  /* Initialisation du rewriting de l'URL */
  function wpd_page_rewrite(){
	add_rewrite_rule( '^films/([^/]*)?', 'index.php?pagename=films&edition=$matches[1]', 'top' );
  }
  add_action( 'init', 'wpd_page_rewrite' );
  
  $variable = get_query_var('edition');


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
		
		
/*		$idGenres = array (); 
		//a:3:{i:0;s:2:"70";i:1;s:2:"29";i:2;s:2:"72";}
		$genres = array (
			"action" => "70",
			"adventure" => "29",
			"animation" => "72",
			"black comedy" => "57",
			"crime" => "58",
			"disaster" => "66",
			"documentary"=>"69",
			"dystopia"=>"64",
			"end of the world" => "54",
			"fantasy" => "77",
			"fairytale" => "68",
			"film noir" => "74",
			"ghost movie" => "65",
			"gore" => "51",
			"horror" => "50",
			"martial arts" => "71",
			"monster movie" => "55",
			"mystery" => "59",
			"parody" => "76",
			"post-apocalyptic" => "75",
			"science-fiction" => "60",
			"serial killer" => "52",
			"slasher" => "53",
			"supernatural" => "61",
			"surreal" => "63",
			"thriller" => "56",
			"time travel" => "67",
			"vampire" => "73",
			"zombie" => "62"
		);
		
		

		$genreString = 'a:3:{';
		
		foreach($explodeGenre as $k => $g){
			
			$genreString .= 'i:'.$k.';s:2:"'.$genres[$g].'";';
			$idGenres[] = $genres[$g];
		}
		$genreString .= '}';

		//var_dump($idGenres);
*/		
	
	
		$genres_dyn=get_terms("genre");
		
		$genres=array();
		foreach($genres_dyn as $gdyn){
			$genres[$gdyn->name]=$gdyn->term_id;
		}
		
		$idGenres=array();
		foreach($explodeGenre as $g){
			
			if (array_key_exists($g, $genres)){
				array_push($idGenres, $genres[$g]);
			} else {
				//the taxonomy does not exist --> create it
				$newid=wp_insert_term($g, "genre", sanitize_title($g));
				wp_dump($newid);
				array_push($idGenres, $newid["term_id"]);
			}
		}
		
		wp_dump($idGenres);
		
		//DELETE FROM `wp_posts` WHERE `wp_posts`.`ID` > 300;	
				
						// Add Featured Image to Post
		$image_url        = $post["images"]; // Define the image URL here
		$image_name       = preg_replace( '/[^a-z0-9]/i', '', $post["post_name"])."_poster.jpg";
		$upload_dir       = wp_upload_dir(); // Set upload folder
		$image_data       = file_get_contents($image_url); // Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
		$filename         = basename( $unique_file_name ); // Create image file name

		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		// Create the image  file on the server
		file_put_contents( $file, $image_data );

		// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );

		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post["ID"] );

		// Include image.php
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );

		// And finally assign featured image to post
		set_post_thumbnail( $post["ID"], $attach_id );		
			

		// Insertion du post dans la database
		$post["ID"] = wp_insert_post(array(
			"post_title" => $post["post_name"],	
			//permet de remove le 2015| de 2015|movie	
			//"product_cat" => substr(strrchr($post["tax:product_cat"],"|"), 1), A VOIR PLUS TARD
			"post_content" =>$post["post_content"],
			"post_type" => $insert_post["custom-post-type"],
			//"attribute:pa_cast" => $post["attribute:pa_cast"],
			//"attribute:pa_genre" => $idGenres,			
			"post_status" => "publish"
		));
		

		// Update post's custom field
		// var_dump($post);

		update_field('titre_original', $post["post_title"], $post["ID"]);
		update_field('entry-content', $post["post_content"], $post["ID"]);
		update_field('casting', $post["attribute:pa_cast"], $post["ID"]);
		
		update_field( 'field_60364d57c8199', $idGenres, $post["ID"] );
		
		
		//update_field('field_60364d57c8199',$idGenres, $post["ID"]);
	}

	//Redirection pour clear l'url du &insertion_csv_post afin d'eviter le lancement de la fonction à chaque refresh
	$url = "http://localhost/wikibifff/wp-admin";
	//wp_redirect($url);
	exit;
});