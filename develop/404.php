<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tintin
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="bg-cover bg-no-repeat bg-fixed" style="background-image: url(<?php echo esc_url( get_template_directory_uri());?>/assets/img/404/bg.jpg);">
			<div class="container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri());?>/assets/img/404/404.svg" alt="404" class="w-full md:w-[90%] py-16 object-contain mx-auto">
				</a>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
