<!-- http://localhost/wikibifff/home/ -->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php wp_head(); ?>
    </head>
    <title>Document</title>
</html>
<body>

<div class="containerHome">
    <div class="left">
        <div class="leftInnerImg">
            <img src="https://www.bifff.net/wp-content/uploads/2016/03/cropped-bifff-favicon.png" alt="">
        </div>
        <div class="leftInnerTxt">
            <h1 class="bifffh1">BIFFF</h1>
            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius eligendi exercitationem facilis id impedit provident quae quas reprehenderit suscipit voluptate!</p>
        </div>

    </div>

    <a href="http://localhost/wikibifff/bifff-history/" class="buttonLeft">BIFFF HISTORY</a>
    <div class="right">

        <div class="rightTop">
            <h1 class="zombieTxt">I DON'T LIKE ZOMBIE MOVIES!</h1>
            <a href="http://localhost/wikibifff/films/" class="buttonRight">MOVIE LIST</a>
        </div>

        <div class="rightBot">
            <h1 class="SearchBarRightBot">SEARCH OUR MOVIE DATABASE:</h1>
            <?php get_search_form(); ?>
        </div>

    </div>
</div>



</body>
</html>