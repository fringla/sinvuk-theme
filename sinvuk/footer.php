<?php
/**
 * Theme footer.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company   = sinvuk_mod( 'company_name' );
$phone     = sinvuk_mod( 'phone' );
$instagram = sinvuk_mod( 'instagram' );
$facebook  = sinvuk_mod( 'facebook' );
$year      = gmdate( 'Y' );
?>

<footer class="site-footer" role="contentinfo">
	<div class="container footer-inner">
		<p class="footer-copy">&copy; <?php echo esc_html( $year ); ?> <?php echo esc_html( $company ); ?></p>
		<?php if ( $instagram || $facebook ) : ?>
			<nav class="footer-social" aria-label="Društvene mreže">
				<?php if ( $instagram ) : ?>
					<a href="<?php echo esc_url( $instagram ); ?>" rel="noopener noreferrer" target="_blank">Instagram</a>
				<?php endif; ?>
				<?php if ( $facebook ) : ?>
					<a href="<?php echo esc_url( $facebook ); ?>" rel="noopener noreferrer" target="_blank">Facebook</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</div>
</footer>

<?php if ( $phone ) : ?>
	<a class="float-call" href="<?php echo esc_url( sinvuk_tel_href( $phone ) ); ?>" aria-label="<?php echo esc_attr( 'Pozovite nas: ' . $phone ); ?>">
		<?php echo sinvuk_icon( 'phone' ); ?>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
