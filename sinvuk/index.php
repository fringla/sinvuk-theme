<?php
/**
 * Fallback template.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="sadrzaj" class="page-main">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="page-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article>
				<h1>Nema sadržaja</h1>
				<p class="section-lead">Ova stranica je prazna.</p>
				<p class="error-actions"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Nazad na početnu</a></p>
			</article>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
