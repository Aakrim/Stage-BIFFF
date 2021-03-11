<?php
/**
 * Template Name: Edition Model 1
 * Template Post Type: post,page,edition-post,guest,film
 */


/**
global $wp_query;

$edition = $wp_query->query_vars['film'];
$guest = $wp_query->query_vars['guest'];
**/

get_header();

include('edition-entete.php');
include('edition-milieu.php');
include('edition-bas.php');

get_footer();