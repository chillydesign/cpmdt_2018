<!DOCTYPE html>
<html lang="en">
<head>
   <!--  <meta charset="UTF-8"> -->

    <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Scaled for Responsivity -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Blog Title -->
    <title> <?php wp_title( ' - ', true, 'right'); ?> <?php bloginfo('name'); ?>  </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('er_favicon')); ?>" />
    <!-- /*Theme was developed & Designed by Edon Rexhepi, www.edonrexhepi.com*/ -->
    <!-- Stylesheets -->
    <?php wp_head(); ?>
    <?php setlocale(LC_TIME, "fr_FR"); ?>
</head>
<body <?php body_class(); ?>>

    <header>
        <div class="navbar-pre">
            <div class="container">
                    <?php  wp_nav_menu(
                        array(
                            'theme_location' => 'prenav-menu',
                            'menu_class' => 'links-list'
                        ));
                    ?>
            </div>
        </div>
        <a id="prenav-toggle" href="#">MENU </a>
        <nav class="navbar navbar-default">
            <div class="container flex-container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Brand -->
                        <a class="navbar-brand" href="<?php echo site_url(); ?>">
                            <span class="hidden-gap"></span>
                            <?php if ( get_theme_mod( 'er-logo_change' ) ) : ?>
                                <img
                                    src='<?php echo esc_url( get_theme_mod( 'er-logo_change' ) ); ?>'
                                    alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>

                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse flex-align-bottom" id="menu-collapse">
                        <?php  wp_nav_menu(
                            array(
                                'theme_location' => 'header-menu',
                                'menu_class'  => 'nav navbar-nav'
                            ));
                        ?>
                    </div><!-- /.navbar-collapse -->

                    <!-- Search in the nav links, right side of the header -->
                    <div class="search-nav search-menu">
                        <form role="search" action="<?php echo site_url('/'); ?>" method="get">
                            <input type="search" name="s" placeholder=""/>
                            <input type="submit" alt="Search" value="OK" />
                        </form>
                    </div>

            </div><!-- /.container-fluid -->
        </nav>
    </header>

    <div class="program-categories font-bold  fixed text-uppercase">
        <div class="arrow toggle-categories">
            <i class="background-primary"></i>
        </div>
        <div class="background-primary header toggle-categories">
            <span>inscription</span>
        </div>
        <div class="background-music links">
            <ul>
                <li><a href="<?php echo get_home_url(); ?>/inscription-pour-les-enfants-4-7-ans-et-formation-musicale/">COURS 4-7 ANS ET FORMATION MUSICALE</a></li>
                <li><a href="<?php echo get_home_url(); ?>/inscription-en-instrument-chant-et-formation-musicale-fm/">Instruments/Chant et Formation musicale</a></li>
                <li><a href="<?php echo get_home_url(); ?>/inscription-adultes/">Offre adultes</a></li>
                <li><a target="_blank" href="http://courscomplementaires.ch/">Cours complémentaires</a></li>
            </ul>
        </div>
        <a class="background-dance" href="<?php echo get_home_url(); ?>/inscription-danse/">Danse</a>
        <a class="background-theatre" href="<?php echo get_home_url(); ?>/inscription-theatre/">Théâtre</a>
    </div>
