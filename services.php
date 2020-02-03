<?php $services = get_field('images_musique_danse_theatre'); ?>
<?php if($services) : ?>
  <div class="services">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
        <a class="musique-service" href="<?php echo get_home_url(); ?>/musique">
            <div class="service_image" style="background-image:url(<?php echo $services['image_musique']['sizes']['medium']; ?>);"></div>
            <h2>Musique</h2>
        </a>
        </div>
        <div class="col-sm-4">
        <a class="danse-service" href="<?php echo get_home_url(); ?>/danse">
            <div class="service_image" style="background-image:url(<?php echo $services['image_danse']['sizes']['medium']; ?>);"></div>
            <h2>Danse</h2>
        </a>
        </div>
        <div class="col-sm-4">
        <a class="theatre-service" href="<?php echo get_home_url(); ?>/theatre">
            <div class="service_image" style="background-image:url(<?php echo $services['image_theatre']['sizes']['medium']; ?>);"></div>
            <h2>Théâtre</h2>
        </a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
