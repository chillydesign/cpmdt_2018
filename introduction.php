<?php $introduction = get_field('introduction'); ?>
<?php if($introduction): ?>
  <div class="introduction">
    <div class="container"><?php echo $introduction; ?></div>
  </div>
<?php endif; ?>
