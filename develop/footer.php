<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tintin
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="container py-0">
			<div id="footer-splide" class="splide py-8 border-b-2 custom-border" data-splide='{
				"type": "loop",
				"perPage": 4,
				"perMove": 1,
				"gap": "2vw",
				"pagination": false,
				"arrows": false,
				"pauseOnHover": true,
				"autoplay": true,
				"breakpoints": {
					"1200": {"perPage": 3},
					"880": {"perPage": 2},
					"680": {"perPage": 1}
				}
				}'>
				<div class="splide__track">
					<ul class="splide__list">
						<?php if (have_rows('footer_slide_item', 'option')): ?>
							<?php while (have_rows('footer_slide_item', 'option')): the_row(); 
								$icon = get_sub_field('footer_slide_icon');
								$text = get_sub_field('footer_slide_text');
								$link = get_sub_field('footer_slide_link');
								$popup = get_sub_field('link_to_student_discount_popup');
							?>
								<li class="splide__slide flex gap-x-4 items-center justify-center">
									<?php if ($icon): ?>
										<img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
									<?php endif; ?>
									<?php if ($link && !$popup): ?>
										<a href="<?php echo esc_url($link['url']); ?>" class="p-one text-shop-front-blue font-semibold">
											<?php echo esc_html($text); ?>
										</a>
									<?php elseif ($popup): ?>
										<a class="p-one text-shop-front-blue font-semibold" href="#" onclick="Fancybox.show([{ src: '#popup-content-2', type: 'inline' }]); return false;">
											<?php echo esc_html($text); ?>
										</a>
									<?php else: ?>
										<p class="p-one text-shop-front-blue font-semibold">
											<?php echo esc_html($text); ?>
										</p>
									<?php endif; ?>
								</li>
							<?php endwhile; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<div class="container text-shop-front-blue py-10 lg:py-20">
			
			<div class="flex flex-col xl:flex-row justify-between gap-x-24">
				<div class="flex flex-col md:flex-row justify-between md:border-b-2 custom-border xl:border-none pb-0 md:pb-10 xl:pb-0 flex-grow">
					<div class="flex md:gap-x-8 pb-10 lg:pb-0 border-b-2 custom-border md:border-none w-auto md:w-[55vw] xl:w-auto md:justify-between xl:justify-start">
						<div class="flex flex-col flex-shrink-0">
							<img class="hidden md:block w-auto object-contain h-[94px]  md:h-[163px] xl:h-[227px]" src="<?php echo esc_url( get_template_directory_uri());?>/assets/img/logos/logo.jpeg" alt="Tintin Logo">
						</div>

						<?php
						// Check if ACF function exists
						if ( function_exists('get_field') ) {
							// Retrieve the ACF fields from the options page
							$address = get_field('visit_us_address', 'option');
							$phone = get_field('visit_us_phone', 'option');
							$email = get_field('visit_us_email', 'option');
							?>

							<div class="flex flex-col gap-y-5">
								<h5 class="heading-five">Visit us</h5>

								<?php if ( $address ): ?>
									<p class="p-one font-semibold"><?php echo nl2br(esc_html($address)); ?></p>
								<?php endif; ?>

								<div class="flex flex-col">
								<?php if ( $phone ): 
									// Remove spaces and special characters from the phone number for the link
									$phone_link = preg_replace('/[^0-9+]/', '', $phone);
								?>
									<a href="tel:<?php echo esc_attr($phone_link); ?>" class="p-one font-semibold"><?php echo esc_html($phone); ?></a>
								<?php endif; ?>

									<?php if ( $email ): ?>
										<a href="mailto:<?php echo esc_attr($email); ?>" class="p-one font-semibold"><?php echo esc_html($email); ?></a>
									<?php endif; ?>
								</div>
							</div>

							<?php
						}
						?>
					</div>
				
					<div class="flex flex-col gap-y-5 py-10 md:py-0 border-b-2 custom-border md:border-none">
					<?php
						// Check if ACF function exists and if the 'opening_times' repeater has rows
						if ( function_exists('have_rows') && have_rows('opening_times', 'option') ):
							?>
							
								<h5 class="heading-five">Opening Times</h5>
								<div class="flex flex-col justify-between gap-y-1 max-w-sm">
									<?php 
									// Loop through the rows of data
									while ( have_rows('opening_times', 'option') ) : the_row();
										$day = get_sub_field('day');
										$hours = get_sub_field('hours');
										?>
										<div class="flex justify-between gap-x-10">
											<p class="p-one font-semibold"><?php echo esc_html($day); ?></p>
											<p class="p-one"><?php echo esc_html($hours); ?></p>
										</div>
									<?php
									endwhile;
									?>
								</div>
							
							<?php
						endif;
						?>

					</div>
				</div>
				<div class="flex flex-col gap-y-9">

					<?php
						// Check if the ACF function exists to prevent errors in case ACF is not active
						if ( function_exists('get_field') ) {
							// Get the newsletter form shortcode from the ACF options page
							$newsletter_form_shortcode = get_field('newletter_from_shortcode', 'option');
						?>
					
							<div id="footer-newsletter" class="flex flex-col gap-y-5 py-10 xl:py-0 border-b-2 custom-border xl:border-none">
								<h5 class="heading-five">Newsletter signup</h5>
								<?php

									// Check if the shortcode exists
									if ( !empty($newsletter_form_shortcode) ) {
										// Execute the shortcode
										echo do_shortcode($newsletter_form_shortcode);
									}
								
								?>
							</div>
					<?php } ?>
					
					<?php
					// Check if ACF function exists
					if ( function_exists('get_field') ) {
						// Fetching social media links from ACF fields in the options page
						$facebook_link = get_field('facebook', 'option');
						$twitter_link = get_field('twitter', 'option');
						$pinterest_link = get_field('pinterest', 'option');
						$instagram_link = get_field('instagram', 'option');

						// Check if at least one social media link exists
						if ( $facebook_link || $twitter_link || $pinterest_link || $instagram_link ) {
							?>
							<div class="flex items-center gap-x-3 pb-10 xl:pb-0 border-b-2 custom-border xl:border-none">
								<h5 class="heading-five mr-3">Follow us</h5>
								<?php if ( $facebook_link ): ?>
									<a href="<?php echo esc_url( $facebook_link['url'] ); ?>" target="_blank" class="h-[37px] w-[37px] bg-covers-orange rounded-full flex items-center justify-center flex-shrink-0">
										<?php include(locate_template('assets/img/social/fb.svg')); ?>
									</a>
								<?php endif; ?>
								<?php if ( $twitter_link ): ?>
									<a href="<?php echo esc_url( $twitter_link['url'] ); ?>" target="_blank" class="h-[37px] w-[37px] bg-covers-orange rounded-full flex items-center justify-center flex-shrink-0">
										<?php include(locate_template('assets/img/social/x.svg')); ?>
									</a>
								<?php endif; ?>
								<?php if ( $pinterest_link ): ?>
									<a href="<?php echo esc_url( $pinterest_link['url'] ); ?>" target="_blank" class="h-[37px] w-[37px] bg-covers-orange rounded-full flex items-center justify-center flex-shrink-0">
										<?php include(locate_template('assets/img/social/pinterest.svg')); ?>
									</a>
								<?php endif; ?>
								<?php if ( $instagram_link ): ?>
									<a href="<?php echo esc_url( $instagram_link['url'] ); ?>" target="_blank" class="h-[37px] w-[37px] bg-covers-orange rounded-full flex items-center justify-center flex-shrink-0">
										<?php include(locate_template('assets/img/social/insta.svg')); ?>
									</a>
								<?php endif; ?>
							</div>
							<?php
						}
					}
					?>

					
					<div class="flex gap-x-5 items-center justify-center xl:justify-start hidden">
						<?php include(locate_template('assets/img/payments/paypal.svg'));?>
						<?php include(locate_template('assets/img/payments/apple.svg'));?>
						<?php include(locate_template('assets/img/payments/google.svg'));?>
					</div>
					
				</div>
			</div>
		</div>

		<div class="container max-w-none py-0 bg-shop-front-blue items-center self-stretch hidden lg:grid grid-cols-12 justify-between gap-5 text-white h-20">
			<div class="col-span-5 flex items-center gap-x-6">
				<?php
				// Check if ACF function exists and if the 'bottom_links' repeater has rows
				if ( function_exists('have_rows') && have_rows('bottom_links', 'option') ):
					// Loop through the rows of data
					while ( have_rows('bottom_links', 'option') ) : the_row();

						// Get the post object
						$link_to_page = get_sub_field('link_to_page');
						if ( $link_to_page ):
							// Generate the link
							?>
							<a href="<?php echo esc_url(get_permalink($link_to_page->ID)); ?>" class="p-one font-semibold">
								<?php echo esc_html($link_to_page->post_title); ?>
							</a>
							<?php
						endif;
					endwhile;
				endif;
				?>
			</div>
			<div class="col-span-2 flex justify-center !mt-0 self-end">
				<img class="object-contain object-center w-[80px] overflow-hidden shrink-0 max-w-full -mt-4 self-start" src="<?php echo esc_url( get_template_directory_uri());?>/assets/img/logos/tintin2.png" alt="Tintin Logo">
			</div>
			<div class="col-span-5 flex items-center gap-x-6 justify-end !mt-0">
				<p class="p-one">© Hergé-Tintinimaginatio 2024.</p>
				<p class="p-one font-semibold">Website by <a class="underline" href="https://www.greenwich-design.co.uk/" target="_blank">Greenwich Design</a></p>
			</div>
		</div>

		<div class="container py-10 bg-shop-front-blue items-center self-stretch  lg:hidden flex flex-col justify-between gap-5 text-white">
			<div class="flex items-center gap-x-7 border-b-2 border-white border-dashed pb-10 w-full justify-center">
				<img class="w-[120px]" src="<?php echo esc_url( get_template_directory_uri());?>/assets/img/logos/tintin2.png" alt="Tintin Logo">
				<div class="flex flex-col gap-y-2">
					<?php
					// Check if ACF function exists and if the 'bottom_links' repeater has rows
					if ( function_exists('have_rows') && have_rows('bottom_links', 'option') ):
						// Loop through the rows of data
						while ( have_rows('bottom_links', 'option') ) : the_row();

							// Get the post object
							$link_to_page = get_sub_field('link_to_page');
							if ( $link_to_page ):
								// Generate the link
								?>
								<a href="<?php echo esc_url(get_permalink($link_to_page->ID)); ?>" class="p-one font-semibold">
									<?php echo esc_html($link_to_page->post_title); ?>
								</a>
								<?php
							endif;
						endwhile;
					endif;
					?>
				</div>
			</div>
			<div>
				<p class="p-one font-semibold text-center lg:text-left">© Hergé-Tintinimaginatio <?php echo date('Y'); ?>.</p>
				<p class="p-one font-semibold text-center lg:text-left">Website by <a class="underline" href="https://www.greenwich-design.co.uk/" target="_blank">Greenwich Design</a></p>
			</div>
		</div>


		<div id="lightbox" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-shop-front-blue bg-opacity-95">
			<!-- Close button outside the video container -->
			<span class="absolute top-32 right-4 text-white text-4xl font-bold cursor-pointer z-60 lightbox-close">&times;</span>
			
			<div class="relative w-full max-w-[90vw]" style="padding-top: 56.25%;">
				<iframe id="lightbox-video" class="absolute top-0 left-0 w-full h-full z-50" allowfullscreen></iframe>
			</div>
		</div>


	</footer><!-- #colophon -->
</div><!-- #page -->

<?php get_template_part('template-parts/popup'); ?>
<?php get_template_part('template-parts/search'); ?>

<?php wp_footer(); ?>

</body>
</html>
