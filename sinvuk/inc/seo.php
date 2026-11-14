<?php
/**
 * SEO: document title, meta description, Open Graph, JSON-LD.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-page document title from Customizer.
 *
 * @param string $title Existing title.
 * @return string
 */
function sinvuk_document_title( $title ) {
	if ( is_front_page() ) {
		$custom = trim( (string) sinvuk_mod( 'seo_title' ) );
		if ( $custom !== '' ) {
			return $custom;
		}
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'sinvuk_document_title' );

/**
 * Parse "08:00 – 20:00" into opens/closes for schema.
 *
 * @param string $value Hours string.
 * @return array|null
 */
function sinvuk_parse_hours( $value ) {
	if ( preg_match( '/(\d{1,2}:\d{2})\s*[–\-—]\s*(\d{1,2}:\d{2})/u', (string) $value, $m ) ) {
		return array( $m[1], $m[2] );
	}
	return null;
}

/**
 * Meta description, Open Graph, Twitter, JSON-LD.
 */
function sinvuk_head_meta() {
	$desc     = sinvuk_mod( 'seo_description' );
	$title    = sinvuk_mod( 'seo_title' );
	$company  = sinvuk_mod( 'company_name' );
	$phone    = sinvuk_mod( 'phone' );
	$email    = sinvuk_mod( 'email' );
	$address  = sinvuk_mod( 'address' );
	$url      = home_url( '/' );
	$image    = sinvuk_hero_image_url();
	$og_image = get_template_directory_uri() . '/assets/img/og-image.jpg';
	if ( sinvuk_mod( 'hero_image' ) ) {
		$og_image = sinvuk_mod( 'hero_image' );
	}

	if ( ! is_front_page() && ! is_home() ) {
		if ( is_singular() ) {
			$post_title = wp_strip_all_tags( get_the_title() );
			$title      = $post_title . ' | ' . $company;
			$excerpt    = get_the_excerpt();
			if ( $excerpt ) {
				$desc = wp_strip_all_tags( $excerpt );
			}
			if ( has_post_thumbnail() ) {
				$og_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			}
		}
	}

	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:locale" content="sr_RS">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $company ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";

	$tel_clean = preg_replace( '/[^\d+]/', '', (string) $phone );

	$schema = array(
		'@context'  => 'https://schema.org',
		'@type'     => array( 'LocalBusiness', 'AutoWash' ),
		'@id'       => $url . '#business',
		'name'      => $company,
		'image'     => $image,
		'url'       => $url,
		'description' => $desc,
		'priceRange'  => '$$',
	);
	if ( $tel_clean ) {
		$schema['telephone'] = $tel_clean;
	}
	if ( $email ) {
		$schema['email'] = $email;
	}
	if ( $address ) {
		$schema['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => $address,
			'addressCountry'  => 'RS',
		);
		$schema['areaServed'] = array(
			'@type' => 'City',
			'name'  => $address,
		);
	}

	$hours_spec = array();
	$wd = sinvuk_parse_hours( sinvuk_mod( 'hours_weekdays' ) );
	if ( $wd ) {
		$hours_spec[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
			'opens'     => $wd[0],
			'closes'    => $wd[1],
		);
	}
	$sun = sinvuk_parse_hours( sinvuk_mod( 'hours_sunday' ) );
	if ( $sun ) {
		$hours_spec[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => 'Sunday',
			'opens'     => $sun[0],
			'closes'    => $sun[1],
		);
	}
	if ( $hours_spec ) {
		$schema['openingHoursSpecification'] = $hours_spec;
	}

	$same = array();
	if ( sinvuk_mod( 'instagram' ) ) {
		$same[] = sinvuk_mod( 'instagram' );
	}
	if ( sinvuk_mod( 'facebook' ) ) {
		$same[] = sinvuk_mod( 'facebook' );
	}
	if ( $same ) {
		$schema['sameAs'] = $same;
	}

	$services = sinvuk_get_services();
	if ( $services ) {
		$offers = array();
		foreach ( $services as $svc ) {
			$offers[] = array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'       => 'Service',
					'name'        => $svc['name'],
					'description' => $svc['desc'],
				),
				'priceSpecification' => array(
					'@type'    => 'PriceSpecification',
					'price'    => $svc['price'],
					'priceCurrency' => 'RSD',
				),
			);
		}
		$schema['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Usluge',
			'itemListElement' => $offers,
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS ) . '</script>' . "\n";
}
add_action( 'wp_head', 'sinvuk_head_meta', 5 );
