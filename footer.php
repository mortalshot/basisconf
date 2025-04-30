<?php 
		echo '<footer class="footer">';
			echo '<div class="footer__container">';
				$socials = get_field('socials', 'options');
				$socials_caption = $socials['socials_caption'];
				$socials_items = $socials['socials_items'];

				echo $socials_caption != '' ? '<div class="footer__caption">'. $socials_caption .'</div>' : '';

				if ($socials_items) :
					echo '<div class="footer__socials socials">';
						foreach ($socials_items as $item) :
							$item_link = $item['item_link'];
							$item_image = $item['item_image'];

							echo '<a href="'. $item_link['url'] .'" target="'. $item_link['target'] .'" class="socials__item">';
								echo '<img src="'. $item_image['url'] .'" alt="'. $item_image['alt'] .'" loading="lazy">';
							echo '</a>';
						endforeach;
					echo '</div>';
				endif;
			echo '</div>';
		echo '</footer>';

		echo '<div class="modals">';
			echo '<div id="video" aria-hidden="true" class="popup popup_video">';
				echo '<div class="popup__wrapper">';
					echo '<div class="popup__content">';
						echo '<button data-close type="button" class="popup__close"> <img src="'. get_template_directory_uri() .'/dist/img/icons/close.svg" alt="" loading="lazy"> </button>';
						echo '<div data-youtube-place class="popup__text"></div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '<div id="registration" aria-hidden="true" class="popup popup_reg">';
				echo '<div class="popup__wrapper">';
					echo '<div class="popup__content">';
						echo '<button data-close type="button" class="popup__close"> <img src="'. get_template_directory_uri() .'/dist/img/icons/close.svg" alt="" loading="lazy"> </button>';
						echo '<div class="popup__text">';
							echo '<div class="form">';
								echo do_shortcode('[contact-form-7 id="0f3a0d8" title="Форма регистрации"]');
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';


		echo '</div>';


		wp_footer();
	echo '</body>';
echo '</html>';
