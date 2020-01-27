<!DOCTYPE html>
<html lang="fr">
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
    <div class="container">
      <a href="<?php echo home_url(); ?>" id="branding">CPMDT</a>
      <a id="prenav-toggle" href="#">MENU </a>
      <div class="headermenus">
        <div class="topnav">
          <?php  wp_nav_menu(
              array(
                  'theme_location' => 'prenav-menu',
                  'menu_class' => 'links-list'
              ));
          ?>

          <!-- Search in the nav links, right side of the header -->
          <div class="search-nav search-menu">
              <form role="search" action="<?php echo site_url('/'); ?>" method="get">
                  <input type="search" name="s" placeholder=""/>
                  <input type="submit" alt="Search" value="OK" />
              </form>
          </div>
        </div>

          <nav class="bottomnav">
            <?php  wp_nav_menu(
                array(
                    'theme_location' => 'header-menu',
                    'menu_class'  => 'nav navbar-nav'
                ));
            ?>
          </div>
      </div>
    </div>
  </header>
