<?php
/**
 * One-page front template.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$company     = sinvuk_mod( 'company_name' );
$eyebrow     = sinvuk_mod( 'hero_eyebrow' );
$title       = sinvuk_mod( 'hero_title' );
$accent      = sinvuk_mod( 'hero_title_accent' );
$subtitle    = sinvuk_mod( 'hero_subtitle' );
$cta1        = sinvuk_mod( 'cta_primary' );
$cta2        = sinvuk_mod( 'cta_secondary' );
$cta2_url    = sinvuk_mod( 'cta_secondary_url' );
$phone       = sinvuk_mod( 'phone' );
$email       = sinvuk_mod( 'email' );
$address     = sinvuk_mod( 'address' );
$map_query   = sinvuk_mod( 'map_query' );
$hero_img    = sinvuk_hero_image_url();
$services    = sinvuk_get_services();
$gallery     = sinvuk_get_gallery();
$h_wd_label  = sinvuk_mod( 'hours_weekdays_label' );
$h_wd        = sinvuk_mod( 'hours_weekdays' );
$h_sun_label = sinvuk_mod( 'hours_sunday_label' );
$h_sun       = sinvuk_mod( 'hours_sunday' );
$h_note      = sinvuk_mod( 'hours_note' );

$map_src = 'https://maps.google.com/maps?q=' . rawurlencode( $map_query ) . '&hl=sr&z=17&output=embed';

$why = array(
	array(
		'icon'  => 'hand',
		'title' => 'Ručno pranje',
		'text'  => 'Bez automatskih četkica. Svu prljavštinu skidamo rukama, mekanim sunđerima i pravilnom tehnikom.',
	),
	array(
		'icon'  => 'flask',
		'title' => 'Premium hemija',
		'text'  => 'Koristimo profesionalna sredstva koja čiste temeljno, a štite lak, gumu i plastiku.',
	),
	array(
		'icon'  => 'spark',
		'title' => 'Pažnja na detalje',
		'text'  => 'Felne, pragovi, slivnici i ivice vrata — tamo gde se razlikuje dobro od odličnog.',
	),
	array(
		'icon'  => 'shield',
		'title' => 'Sigurnost za lak',
		'text'  => 'Bez agresivnih četkica i grubih krpa. Radimo tako da lak ostane čist i netaknut.',
	),
);

$steps = array(
	array(
		'title' => 'Zakazivanje',
		'text'  => 'Dogovorimo termin koji vama odgovara i pripremimo mesto za vaše vozilo.',
	),
	array(
		'title' => 'Pregled vozila',
		'text'  => 'Zajedno procenimo stanje i predložimo uslugu koja je vozilu zaista potrebna.',
	),
	array(
		'title' => 'Ručna obrada',
		'text'  => 'Peremo i čistimo korak po korak, ručno i bez žurbe.',
	),
	array(
		'title' => 'Završna kontrola',
		'text'  => 'Pre predaje proveravamo svaki detalj, da izađete sa sjajem koji očekujete.',
	),
);
?>

<main id="sadrzaj">

	<section id="pocetak" class="hero" aria-label="<?php echo esc_attr( $company ); ?>">
		<div class="hero-bg" style="--hero-image: url('<?php echo esc_url( $hero_img ); ?>');">
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="" role="presentation" width="2200" height="1237">
		</div>
		<div class="hero-overlay" aria-hidden="true"></div>
		<div class="hero-corners" aria-hidden="true">
			<span></span><span></span><span></span><span></span>
		</div>
		<div class="container hero-content">
			<?php if ( $eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h1 class="hero-title">
				<span class="hero-title-main"><?php echo esc_html( $title ); ?></span>
				<?php if ( $accent ) : ?>
					<span class="hero-title-accent"><?php echo esc_html( $accent ); ?></span>
				<?php endif; ?>
			</h1>
			<?php if ( $subtitle ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
			<div class="hero-actions">
				<?php if ( $cta1 && $phone ) : ?>
					<a class="btn btn-primary" href="<?php echo esc_url( sinvuk_tel_href( $phone ) ); ?>">
						<?php echo sinvuk_icon( 'phone' ); ?>
						<?php echo esc_html( $cta1 ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $cta2 ) : ?>
					<a class="btn btn-ghost" href="<?php echo esc_url( $cta2_url ? $cta2_url : '#kontakt' ); ?>">
						<?php echo esc_html( $cta2 ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="scroll-hint" aria-hidden="true">
			<span>Nadole</span>
			<span class="scroll-hint-line"></span>
		</div>
	</section>

	<section id="zasto-mi" class="section section-why">
		<div class="container">
			<header class="section-head">
				<p class="eyebrow">Zašto mi</p>
				<h2 class="section-title">Kvalitet se vidi u detaljima</h2>
				<p class="section-lead">Ne jurimo minute. Svako vozilo peremo rukama, pažljivo i sa poštovanjem prema laku.</p>
			</header>
			<div class="why-grid">
				<?php foreach ( $why as $item ) : ?>
					<article class="why-card">
						<div class="why-icon"><?php echo sinvuk_icon( $item['icon'] ); ?></div>
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="usluge" class="section section-services">
		<div class="container">
			<header class="section-head">
				<p class="eyebrow">Usluge i cene</p>
				<h2 class="section-title">Šta radimo za vaše vozilo</h2>
				<p class="section-lead">Pažljivo ručno pranje, dubinsko čišćenje i zaštita laka — prema stanju i veličini vozila.</p>
			</header>
			<?php if ( $services ) : ?>
				<div class="services-grid">
					<?php foreach ( $services as $i => $svc ) : ?>
						<article class="service-card">
							<span class="service-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<h3><?php echo esc_html( $svc['name'] ); ?></h3>
							<?php if ( $svc['desc'] ) : ?>
								<p><?php echo esc_html( $svc['desc'] ); ?></p>
							<?php endif; ?>
							<?php if ( $svc['price'] ) : ?>
								<div class="service-price"><?php echo esc_html( $svc['price'] ); ?></div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<p class="services-note" style="margin-top:32px;font-size:14px;opacity:.75;">Napomena: sva prljavija i neredovno održavana vozila mogu biti naplaćena i više od 50% od redovne cene pranja.</p>
		</div>
	</section>

	<section id="kako-radimo" class="section section-steps">
		<div class="container">
			<header class="section-head">
				<p class="eyebrow">Kako radimo</p>
				<h2 class="section-title">Četiri koraka do sjaja</h2>
				<p class="section-lead">Jednostavan postupak, od dogovora do predaje vozila.</p>
			</header>
			<div class="steps-grid">
				<?php foreach ( $steps as $i => $step ) : ?>
					<article class="step">
						<div class="step-num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
						<h3><?php echo esc_html( $step['title'] ); ?></h3>
						<p><?php echo esc_html( $step['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="galerija" class="section section-gallery">
		<div class="container">
			<header class="section-head">
				<p class="eyebrow">Galerija</p>
				<h2 class="section-title">Naš rad</h2>
				<p class="section-lead">Svaki detalj, svaki potez — ručno i bez žurbe.</p>
			</header>
			<div class="gallery-grid">
				<?php foreach ( $gallery as $item ) : ?>
					<a class="gallery-item<?php echo ! empty( $item['class'] ) ? ' ' . esc_attr( $item['class'] ) : ''; ?>" href="<?php echo esc_url( $item['url'] ); ?>">
						<img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" loading="lazy" width="1600" height="1100">
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="kontakt" class="section section-contact">
		<div class="container">
			<div class="contact-grid">
				<div class="contact-info">
					<header class="section-head">
						<p class="eyebrow">Kontakt</p>
						<h2 class="section-title">Dođite ili nas pozovite</h2>
						<p class="section-lead">Zakažite termin telefonom — javimo se i dogovorimo vreme koje vama odgovara.</p>
					</header>

					<div class="contact-list">
						<?php if ( $phone ) : ?>
							<a class="contact-item" href="<?php echo esc_url( sinvuk_tel_href( $phone ) ); ?>">
								<?php echo sinvuk_icon( 'phone' ); ?>
								<span>
									<span class="label">Telefon</span>
									<span class="value"><?php echo esc_html( $phone ); ?></span>
								</span>
							</a>
						<?php endif; ?>
						<?php if ( $email ) : ?>
							<a class="contact-item" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
								<?php echo sinvuk_icon( 'mail' ); ?>
								<span>
									<span class="label">Email</span>
									<span class="value"><?php echo esc_html( $email ); ?></span>
								</span>
							</a>
						<?php endif; ?>
						<?php if ( $address ) : ?>
							<div class="contact-item">
								<?php echo sinvuk_icon( 'pin' ); ?>
								<span>
									<span class="label">Adresa</span>
									<span class="value"><?php echo esc_html( $address ); ?></span>
								</span>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( $h_wd || $h_sun ) : ?>
						<div class="hours-box">
							<h3>Radno vreme</h3>
							<dl>
								<?php if ( $h_wd_label || $h_wd ) : ?>
									<div class="hours-row">
										<dt><?php echo esc_html( $h_wd_label ); ?></dt>
										<dd><?php echo esc_html( $h_wd ); ?></dd>
									</div>
								<?php endif; ?>
								<?php if ( $h_sun_label || $h_sun ) : ?>
									<div class="hours-row">
										<dt><?php echo esc_html( $h_sun_label ); ?></dt>
										<dd><?php echo esc_html( $h_sun ); ?></dd>
									</div>
								<?php endif; ?>
							</dl>
							<?php if ( $h_note ) : ?>
								<p class="hours-note"><?php echo esc_html( $h_note ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="contact-map">
					<iframe
						src="<?php echo esc_url( $map_src ); ?>"
						title="<?php echo esc_attr( 'Mapa — ' . $company . ', ' . $address ); ?>"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						allowfullscreen
					></iframe>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
