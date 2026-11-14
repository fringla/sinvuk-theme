<?php
/**
 * Theme header.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone    = sinvuk_mod( 'phone' );
$logo     = sinvuk_mod( 'logo_text' );
$tagline  = sinvuk_mod( 'logo_tagline' );
$company  = sinvuk_mod( 'company_name' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#sadrzaj">Preskoči na sadržaj</a>

<header class="site-header" role="banner">
	<div class="container header-inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $company ); ?>">
			<?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="logo-mark"><?php echo esc_html( $logo ); ?></span>
				<?php if ( $tagline ) : ?>
					<span class="logo-tag"><?php echo esc_html( $tagline ); ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</a>

		<nav class="site-nav" id="site-nav" aria-label="Glavna navigacija">
			<a href="<?php echo esc_url( home_url( '/#pocetak' ) ); ?>">Početak</a>
			<a href="<?php echo esc_url( home_url( '/#zasto-mi' ) ); ?>">Zašto mi</a>
			<a href="<?php echo esc_url( home_url( '/#usluge' ) ); ?>">Usluge</a>
			<a href="<?php echo esc_url( home_url( '/#galerija' ) ); ?>">Galerija</a>
			<a href="<?php echo esc_url( home_url( '/#kontakt' ) ); ?>">Kontakt</a>
		</nav>

		<?php if ( $phone ) : ?>
			<a class="header-phone" href="<?php echo esc_url( sinvuk_tel_href( $phone ) ); ?>">
				<?php echo sinvuk_icon( 'phone' ); ?>
				<span><?php echo esc_html( $phone ); ?></span>
			</a>
		<?php endif; ?>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Otvori meni">
			<span class="nav-toggle-bar"></span>
		</button>
	</div>
</header>
