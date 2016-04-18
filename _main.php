<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $headline; ?> - <?php echo $site_name; ?> - <?php echo $site_title; ?></title>
        <meta name="description" content="<?php echo $site_meta_description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicons -->
        <?php @include("./dist/favicons/favicons.html"); ?>

        <!-- Styles -->
        <?php echo versioned_stylesheet($config->urls->templates.'dist/css/main.css'); ?>

        <!-- Fonts -->
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php include('_adminbar.php'); ?>

        <div id="top-bar">
          <header class="wrapper">
            <div id="main-nav">
              <?php
                echo renderPartial('mainmenu', array(
                  'class' => 'horizontal-menu'
                ));
              ?>
            </div>
            <div id="social-bar">
              <ul class="horizontal-menu">
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Flickr</a></li>
                <li><a href="#">Instagram</a></li>
              </ul>
            </div>
          </header>
        </div>

        <?php #echo renderMenu($menu, 1041); ?>

        <div id="content">
          <h1><?php echo $page->get('title|name'); ?></h1>
          <?php echo $bodycopy; ?>
        </div>

        <footer id="bottom-bar">
          Footer
        </footer>

        <!-- Scripts -->
        <?php echo versioned_javascript($config->urls->templates.'dist/js/vendor.js'); ?>
        <?php echo versioned_javascript($config->urls->templates.'dist/js/main.js'); ?>
    </body>
</html>
