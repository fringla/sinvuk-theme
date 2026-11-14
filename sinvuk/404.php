<?php
/**
 * 404 template.
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
		<article>
			<p class="eyebrow">Greška 404</p>
			<h1>Stranica nije pronađena</h1>
			<p class="section-lead">Ova adresa ne postoji. Vratite se na početnu i pronađite usluge, cene i kontakt.</p>
			<p class="error-actions"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Nazad na početnu</a></p>
		</article>
	</div>
</main>
<?php
get_footer();
