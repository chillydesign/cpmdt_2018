<?php $grey_box_text = get_field('grey_box_text'); ?>
<?php $grey_box_link = get_field('grey_box_link'); ?>
<?php if ($grey_box_text) : ?>

    <div class="container">
        <a href="<?php echo $grey_box_link; ?>" class="grey_box_link">

            <?php echo $grey_box_text; ?>
        </a>
    </div>
<?php endif; ?>