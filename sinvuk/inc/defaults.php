<?php
/**
 * Default (seed) content for Customizer fields.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All theme_mod defaults. These make the site look complete on first activation.
 *
 * @return array
 */
function sinvuk_defaults() {
	return array(
		'company_name'         => 'Auto Perionica Sin Vuk',
		'logo_text'            => 'SIN VUK',
		'logo_tagline'         => 'Auto perionica',
		'hero_eyebrow'         => 'Premium ručno pranje',
		'hero_title'           => 'Ručno pranje.',
		'hero_title_accent'    => 'Bez kompromisa.',
		'hero_subtitle'        => 'Pažljivo ručno pranje i nega vozila za one koji drže do kvaliteta. Premium hemija, strpljenje i sjaj koji se pamti.',
		'cta_primary'          => 'Pozovite nas',
		'cta_secondary'        => 'Zakažite termin',
		'cta_secondary_url'    => '#kontakt',
		'hero_image'           => '',
		'phone'                => '+381 60 000 0000',
		'email'                => 'info@autoperionicasinvuk.rs',
		'address'              => 'Beograd',
		'map_query'            => 'Beograd',
		'hours_weekdays_label' => 'Ponedeljak – Subota',
		'hours_weekdays'       => '08:00 – 20:00',
		'hours_sunday_label'   => 'Nedelja',
		'hours_sunday'         => '09:00 – 15:00',
		'hours_note'           => '',
		'instagram'            => '',
		'facebook'             => '',
		'seo_title'            => 'Auto Perionica Sin Vuk | Premium ručno pranje automobila, Beograd',
		'seo_description'      => 'Auto Perionica Sin Vuk u Beogradu — premium ručno pranje i nega vozila. Pažljiv rad, profesionalna hemija i sjaj bez kompromisa.',

		'service_1_show'  => true,
		'service_1_name'  => 'Spoljno ručno pranje',
		'service_1_desc'  => 'Pažljivo ručno pranje karoserije, felni i stakala, bez automatskih četkica koje ogrebu lak.',
		'service_1_price' => 'od 1.500 RSD',

		'service_2_show'  => true,
		'service_2_name'  => 'Kompletno pranje (unutra i spolja)',
		'service_2_desc'  => 'Spoljno ručno pranje uz temeljno čišćenje kabine, podnih patosnica i stakala.',
		'service_2_price' => 'od 2.500 RSD',

		'service_3_show'  => true,
		'service_3_name'  => 'Dubinsko čišćenje enterijera',
		'service_3_desc'  => 'Dubinsko pranje sedišta, tepiha i plafona — vraća svežinu unutrašnjosti vozila.',
		'service_3_price' => 'od 8.000 RSD',

		'service_4_show'  => true,
		'service_4_name'  => 'Poliranje i zaštita laka',
		'service_4_desc'  => 'Uklanjanje holograma i zaštita laka voskom ili sealantom, za dugotrajan sjaj.',
		'service_4_price' => 'od 12.000 RSD',

		'service_5_show'  => true,
		'service_5_name'  => 'Pranje motora',
		'service_5_desc'  => 'Bezbedno pranje motornog prostora, uz zaštitu elektronike i pažnju na detalje.',
		'service_5_price' => 'od 2.000 RSD',

		'service_6_show'  => true,
		'service_6_name'  => 'Doplata za SUV i kombi',
		'service_6_desc'  => 'Dodatak na izabranu uslugu za veća vozila — SUV, terence i kombije.',
		'service_6_price' => '+500 RSD',

		'service_7_show'  => false,
		'service_7_name'  => '',
		'service_7_desc'  => '',
		'service_7_price' => '',

		'service_8_show'  => false,
		'service_8_name'  => '',
		'service_8_desc'  => '',
		'service_8_price' => '',

		'gallery_1' => '',
		'gallery_2' => '',
		'gallery_3' => '',
		'gallery_4' => '',
		'gallery_5' => '',
		'gallery_6' => '',
	);
}
