<?php
/**
 * WordPress Customizer — all business content, Serbian labels.
 *
 * Path in admin: Izgled → Prilagodi  (Appearance → Customize)
 * Panel: "Sin Vuk — Podešavanja sajta"
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a simple text / textarea / url control.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 * @param string               $id           Setting id.
 * @param string               $section      Section id.
 * @param string               $label        Serbian label.
 * @param string               $type         text, textarea, url, email.
 * @param string               $description  Optional description.
 */
function sinvuk_register_text( $wp_customize, $id, $section, $label, $type = 'text', $description = '' ) {
	$defaults = sinvuk_defaults();
	$default  = isset( $defaults[ $id ] ) ? $defaults[ $id ] : '';

	$sanitize = 'sanitize_text_field';
	if ( 'textarea' === $type ) {
		$sanitize = 'sanitize_textarea_field';
	} elseif ( 'url' === $type ) {
		$sanitize = 'esc_url_raw';
	} elseif ( 'email' === $type ) {
		$sanitize = 'sanitize_email';
	}

	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		)
	);

	$control = array(
		'label'   => $label,
		'section' => $section,
		'type'    => $type,
	);
	if ( $description ) {
		$control['description'] = $description;
	}
	$wp_customize->add_control( $id, $control );
}

/**
 * Register Customizer panel, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function sinvuk_customize_register( $wp_customize ) {
	$defaults = sinvuk_defaults();

	$wp_customize->add_panel(
		'sinvuk_panel',
		array(
			'title'       => 'Sin Vuk — Podešavanja sajta',
			'description' => 'Ovde menjate sve tekstove, cene, kontakt i radno vreme, bez diranja koda. Posle izmene kliknite „Objavi“.',
			'priority'    => 10,
		)
	);

	/* --- Hero --- */
	$wp_customize->add_section(
		'sinvuk_hero',
		array(
			'title' => 'Naslovna (hero)',
			'panel' => 'sinvuk_panel',
			'priority' => 10,
		)
	);
	sinvuk_register_text( $wp_customize, 'company_name', 'sinvuk_hero', 'Naziv firme' );
	sinvuk_register_text( $wp_customize, 'logo_text', 'sinvuk_hero', 'Tekst logotipa (npr. SIN VUK)' );
	sinvuk_register_text( $wp_customize, 'logo_tagline', 'sinvuk_hero', 'Podnaslov pored logotipa' );
	sinvuk_register_text( $wp_customize, 'hero_eyebrow', 'sinvuk_hero', 'Mala linija iznad naslova' );
	sinvuk_register_text( $wp_customize, 'hero_title', 'sinvuk_hero', 'Naslov — prvi red' );
	sinvuk_register_text( $wp_customize, 'hero_title_accent', 'sinvuk_hero', 'Naslov — drugi red (kurziv)' );
	sinvuk_register_text( $wp_customize, 'hero_subtitle', 'sinvuk_hero', 'Podnaslov ispod naslova', 'textarea' );
	sinvuk_register_text( $wp_customize, 'cta_primary', 'sinvuk_hero', 'Tekst prvog dugmeta (Pozovite nas)' );
	sinvuk_register_text( $wp_customize, 'cta_secondary', 'sinvuk_hero', 'Tekst drugog dugmeta (Zakažite termin)' );
	$wp_customize->add_setting(
		'cta_secondary_url',
		array(
			'default'           => $defaults['cta_secondary_url'],
			'sanitize_callback' => 'sinvuk_sanitize_url_or_anchor',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'cta_secondary_url',
		array(
			'label'       => 'Link drugog dugmeta',
			'description' => 'Podrazumevano vodi na #kontakt. Možete staviti i drugi link.',
			'section'     => 'sinvuk_hero',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hero_image',
			array(
				'label'       => 'Pozadinska slika naslovne',
				'description' => 'Ako je prazno, koristi se slika iz teme.',
				'section'     => 'sinvuk_hero',
			)
		)
	);

	/* --- Kontakt --- */
	$wp_customize->add_section(
		'sinvuk_contact',
		array(
			'title'    => 'Kontakt',
			'panel'    => 'sinvuk_panel',
			'priority' => 20,
		)
	);
	sinvuk_register_text( $wp_customize, 'phone', 'sinvuk_contact', 'Telefon', 'text', 'Prikazuje se u zaglavlju, kontaktu i na plutajućem dugmetu za poziv.' );
	sinvuk_register_text( $wp_customize, 'email', 'sinvuk_contact', 'Email', 'email' );
	sinvuk_register_text( $wp_customize, 'address', 'sinvuk_contact', 'Adresa' );
	sinvuk_register_text( $wp_customize, 'map_query', 'sinvuk_contact', 'Upit za Google mapu', 'text', 'Npr. „Auto Perionica Sin Vuk, Beograd“ ili tačna ulica. Od ovoga se pravi mapa.' );

	/* --- Radno vreme --- */
	$wp_customize->add_section(
		'sinvuk_hours',
		array(
			'title'    => 'Radno vreme',
			'panel'    => 'sinvuk_panel',
			'priority' => 30,
		)
	);
	sinvuk_register_text( $wp_customize, 'hours_weekdays_label', 'sinvuk_hours', 'Prva linija — dani (npr. Ponedeljak – Subota)' );
	sinvuk_register_text( $wp_customize, 'hours_weekdays', 'sinvuk_hours', 'Prva linija — vreme (npr. 08:00 – 20:00)' );
	sinvuk_register_text( $wp_customize, 'hours_sunday_label', 'sinvuk_hours', 'Druga linija — dani (npr. Nedelja)' );
	sinvuk_register_text( $wp_customize, 'hours_sunday', 'sinvuk_hours', 'Druga linija — vreme (npr. 09:00 – 15:00)' );
	sinvuk_register_text( $wp_customize, 'hours_note', 'sinvuk_hours', 'Napomena (opciono)', 'textarea' );

	/* --- Društvene mreže --- */
	$wp_customize->add_section(
		'sinvuk_social',
		array(
			'title'    => 'Društvene mreže',
			'panel'    => 'sinvuk_panel',
			'priority' => 40,
		)
	);
	sinvuk_register_text( $wp_customize, 'instagram', 'sinvuk_social', 'Instagram link', 'url', 'Ostavi prazno ako još nemate nalog — ikonica se tada ne prikazuje.' );
	sinvuk_register_text( $wp_customize, 'facebook', 'sinvuk_social', 'Facebook link', 'url', 'Ostavi prazno ako još nemate nalog — ikonica se tada ne prikazuje.' );

	/* --- SEO --- */
	$wp_customize->add_section(
		'sinvuk_seo',
		array(
			'title'    => 'SEO i deljenje',
			'panel'    => 'sinvuk_panel',
			'priority' => 50,
		)
	);
	sinvuk_register_text( $wp_customize, 'seo_title', 'sinvuk_seo', 'Naslov stranice (title)', 'text', 'Prikazuje se u kartici pregledača i na Google-u.' );
	sinvuk_register_text( $wp_customize, 'seo_description', 'sinvuk_seo', 'Meta opis', 'textarea', 'Kratak opis sajta, oko 150 karaktera.' );

	/* --- Usluge (8 slots) --- */
	$wp_customize->add_section(
		'sinvuk_services',
		array(
			'title'       => 'Usluge i cene',
			'description' => 'Osam mesta za usluge. Isključite „Prikaži“ da sakrijete uslugu. Promenite cenu ovde kad je dobijete — nije potreban kod.',
			'panel'       => 'sinvuk_panel',
			'priority'    => 15,
		)
	);

	for ( $i = 1; $i <= 8; $i++ ) {
		$show_id  = 'service_' . $i . '_show';
		$name_id  = 'service_' . $i . '_name';
		$desc_id  = 'service_' . $i . '_desc';
		$price_id = 'service_' . $i . '_price';

		$wp_customize->add_setting(
			$show_id,
			array(
				'default'           => isset( $defaults[ $show_id ] ) ? $defaults[ $show_id ] : false,
				'sanitize_callback' => 'sinvuk_sanitize_checkbox',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$show_id,
			array(
				'label'   => sprintf( 'Usluga %d — prikaži na sajtu', $i ),
				'section' => 'sinvuk_services',
				'type'    => 'checkbox',
			)
		);

		sinvuk_register_text( $wp_customize, $name_id, 'sinvuk_services', sprintf( 'Usluga %d — naziv', $i ) );
		sinvuk_register_text( $wp_customize, $desc_id, 'sinvuk_services', sprintf( 'Usluga %d — opis', $i ), 'textarea' );
		sinvuk_register_text( $wp_customize, $price_id, 'sinvuk_services', sprintf( 'Usluga %d — cena (npr. od 1.500 RSD)', $i ) );
	}

	/* --- Galerija --- */
	$wp_customize->add_section(
		'sinvuk_gallery',
		array(
			'title'       => 'Galerija',
			'description' => 'Do 24 slike. Prikazuju se samo popunjena polja, redom. Ako su sva prazna, koriste se slike iz teme. Alt tekst se uzima iz Medija.',
			'panel'       => 'sinvuk_panel',
			'priority'    => 35,
		)
	);
	$gallery_slots = defined( 'SINVUK_GALLERY_SLOTS' ) ? SINVUK_GALLERY_SLOTS : 24;
	for ( $i = 1; $i <= $gallery_slots; $i++ ) {
		$id = 'gallery_' . $i;
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$id,
				array(
					'label'   => sprintf( 'Slika %d', $i ),
					'section' => 'sinvuk_gallery',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sinvuk_customize_register' );
