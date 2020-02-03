<?php $gallery = get_field('slider'); ?>

<?php if ($gallery): ?>

<?php if( count( $gallery ) > 1) : ?>
    <ul class="front-page_slider">
        <?php foreach ($gallery as $image) : ?>
            <li class="frontpage_image" style="background-image:url('<?php echo $image['sizes']['large']; ?>');">  </li>
        <?php endforeach; ?>
    </ul>
    <div class="container">
      <div class="hometitle">
        <h1>Musique, Danse, Théâtre</h1>
        <h2>Trois arts de la scène réunis dans une même école</h2>
      </div>
    </div>
<?php else: ?>
  <div class="frontpage_image"style="background-image:url('<?php echo $gallery[0]['sizes']['large']; ?>');">
    <div class="container">
      <div class="hometitle">
        <h1>Musique, Danse, Théâtre</h1>
        <h2>Trois arts de la scène réunis dans une même école</h2>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php endif; ?>
