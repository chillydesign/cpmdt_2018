<?php $gallery = get_field('slider'); ?>

<?php if ($gallery): ?>


    <ul class="frontpage_slider">
        <?php foreach ($gallery as $image) : ?>
            <li style="background-image:url('<?php echo $image['sizes']['large']; ?>');">


            </li>
        <?php endforeach; ?>
    </div>


<?php endif; ?>
