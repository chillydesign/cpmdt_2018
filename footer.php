<?php $tdu = get_template_directory_uri(); ?>

		<footer class="col-xs-12 col-sm-12">

			<!--Logo Display  -->
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-1' ); ?>
						<?php endif; ?>
						<hr>
						<?php echo do_shortcode('[mc4wp_form id="494"]'); ?>
						<ul class="share-buttons">
							<?php
								$facebook = get_theme_mod( 'er-facebook' );
								if($facebook){
									$result = '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
									echo $result;
								}
							?>
							<?php
								$insta = get_theme_mod( 'er-insta' );
								if($insta){
									$result = '<li><a href="'.$insta.'"><i class="fa fa-instagram"></i></a></li>';
									echo $result;
								}
							?>
							<?php
								$youtube = get_theme_mod( 'er-youtube' );
								if($youtube){
									$result = '<li><a href="'.$youtube.'"><i class="fa fa-youtube"></i></a></li>';
									echo $result;
								}
							?>
						</ul>
						<p>Le Conservatoire populaire de musique, danse et théâtre, école accréditée par le département de l'instruction publique, de la formation et de la jeunesse, bénéficie du soutien de la République et canton de Genève.</p>


					</div>
					<div class="col-sm-3 col-xs-12">
						<img src="<?php echo $tdu; ?>/assets/footer-image_03.png" alt="">

						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
							<?php dynamic_sidebar( 'footer-2' ); ?>
						<?php endif; ?>
						<p style="margin-bottom:0;">IBAN : CH73 0900 0000 1200 5505 3</p>
						<p>BIC : POFICHBEXXX</p>
						<hr>
						<img style="height:40px;margin-right:10px;" src="<?php echo $tdu; ?>/assets/footer-image_01.png" alt="">
						<img style="height:40px;" src="<?php echo $tdu; ?>/assets/footer-image_02.png" alt="">
					</div>


                    <div class="col-sm-5 col-sm-push-1 col-xs-12 googlemaps-footerview">
                        <h4>les centres d’enseignements</h4>
                        <?php $centers = get_posts(array('post_type' => 'location' , 'posts_per_page' => -1)); ?>
                        <select name="locations" class="locations_dropdown" style="margin-bottom: 20px">
                            <?php foreach ($centers as $center) : ?>
                                <option value="<?php echo $center->guid; ?>"><?php echo $center->post_title; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php get_template_part('locations-map'); ?>



					</div>
				</div>
			</div>
		</footer>

		<!-- Scripts -->
		<?php wp_footer(); ?>

		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxQfqRqtPLAW4BolFMCxTiv9y--R8CXdU"></script>


		<script>
			jQuery('.program').on("touchstart", function (e) {
			'use strict'; //satisfy code inspectors
			var link = jQuery(this); //preselect the link
			if (link.hasClass('hover')) {
				return true;
			}
			else {
				link.addClass('hover');
				jQuery('.program').not(this).removeClass('hover');
				e.preventDefault();
				return false; //extra, and to make sure the function has consistent return points
			}
			});
		</script>
	</body>
</html>
