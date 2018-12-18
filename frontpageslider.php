<?php $gallery = get_field('slider'); ?>

<?php if ($gallery): ?>


    <ul class="frontpage_slider">
        <?php foreach ($gallery as $image) : ?>
            <li style="background-image:url('<?php echo $image['sizes']['large']; ?>');">

                <?php if ($image['caption']): ?>
                        <h3><?php echo $image['caption']; ?></h3>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>


<?php endif; ?>
