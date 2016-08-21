<?php if($config->ajax): ?>

<?php else: ?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $headline; ?></title>
        <meta name="description" content="<?php echo $site_meta_description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicons -->
        <?php @include("./dist/favicons/favicons.html"); ?>

        <!-- Styles -->
        <?php echo versioned_stylesheet($config->urls->templates.'dist/css/main.css'); ?>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php echo renderPartial('manager-bar'); ?>

        <div id="top-bar">
          <?php /*echo getLinkForPage('template=login'); ?> | <?php echo getLinkForPage('template=logout');*/ ?>
        </div>
        
        <div id="main-bar">
          <div id="main-menu">
            <?php echo renderPartial('main-menu', array(
              'root' => $pages->get('/')
            )); ?>
          </div>
        </div>

        <?php echo renderPartial('messages'); ?>

        <div id="content" class="wrapper">
          <?php echo $bodycopy; ?>
        </div>

        <footer id="bottom-bar">

        </footer>

        <!-- Scripts -->
        <?php echo versioned_javascript($config->urls->templates.'dist/js/vendor.js'); ?>
        <?php echo versioned_javascript($config->urls->templates.'dist/js/main.js'); ?>
    </body>
</html>

<?php endif; ?>
