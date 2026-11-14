<?php
/**
 * Sin Vuk Premium theme.
 *
 * @package SinVuk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SINVUK_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/defaults.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/seo.php';

/**
 * Theme setup.
 */
function sinvuk_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'sinvuk_setup' );

/**
 * Force html lang="sr" as required for this site.
 *
 * @param string $output Language attributes.
 * @return string
 */
function sinvuk_language_attributes( $output ) {
	$output = preg_replace( '/lang="[^"]*"/', 'lang="sr"', $output );
	if ( false === strpos( $output, 'lang=' ) ) {
		$output .= ' lang="sr"';
	}
	return $output;
}
add_filter( 'language_attributes', 'sinvuk_language_attributes' );

/**
 * Enqueue styles and scripts.
 */
function sinvuk_assets() {
	$ver = SINVUK_VERSION;
	$path = get_template_directory() . '/style.css';
	if ( file_exists( $path ) ) {
		$ver = (string) filemtime( $path );
	}
	wp_enqueue_style( 'sinvuk-style', get_stylesheet_uri(), array(), $ver );
	wp_enqueue_script(
		'sinvuk-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'sinvuk_assets' );

/**
 * Get a theme_mod value with the theme's built-in default.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function sinvuk_mod( $key ) {
	$defaults = sinvuk_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( $key, $default );
}

/**
 * Visible services (enabled slots with a name).
 *
 * @return array
 */
function sinvuk_get_services() {
	$services = array();
	for ( $i = 1; $i <= 8; $i++ ) {
		$show = sinvuk_mod( 'service_' . $i . '_show' );
		$name = trim( (string) sinvuk_mod( 'service_' . $i . '_name' ) );
		if ( ! $show || '' === $name ) {
			continue;
		}
		$services[] = array(
			'name'  => $name,
			'desc'  => sinvuk_mod( 'service_' . $i . '_desc' ),
			'price' => sinvuk_mod( 'service_' . $i . '_price' ),
		);
	}
	return $services;
}

/**
 * Tel: href from a display phone number.
 *
 * @param string $phone Phone number.
 * @return string
 */
function sinvuk_tel_href( $phone ) {
	$cleaned = preg_replace( '/[^\d+]/', '', (string) $phone );
	return 'tel:' . $cleaned;
}

/**
 * Hero background image URL.
 *
 * @return string
 */
function sinvuk_hero_image_url() {
	$custom = sinvuk_mod( 'hero_image' );
	if ( is_string( $custom ) && $custom !== '' ) {
		return $custom;
	}
	return get_template_directory_uri() . '/assets/img/hero.jpg';
}

/**
 * Default favicon when no Site Icon is set.
 */
function sinvuk_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$dir = get_template_directory_uri() . '/assets/img';
	echo '<link rel="icon" href="' . esc_url( $dir . '/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $dir . '/favicon-32.png' ) . '" sizes="32x32" type="image/png">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $dir . '/apple-touch-icon.png' ) . '">' . "\n";
}
add_action( 'wp_head', 'sinvuk_favicon', 2 );

/**
 * Sanitize checkbox.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function sinvuk_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Inline SVG icons (stroke, 24 viewBox).
 *
 * @param string $name Icon name.
 * @return string
 */
function sinvuk_icon( $name ) {
	$icons = array(
		'phone'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'mail'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>',
		'pin'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s7-7.2 7-12a7 7 0 1 0-14 0c0 4.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.4"/></svg>',
		'hand'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 11V6.5A1.5 1.5 0 0 1 8.5 5h0A1.5 1.5 0 0 1 10 6.5V11"/><path d="M10 10V5.5A1.5 1.5 0 0 1 11.5 4h0A1.5 1.5 0 0 1 13 5.5V11"/><path d="M13 9.5V6.5A1.5 1.5 0 0 1 14.5 5h0A1.5 1.5 0 0 1 16 6.5V13"/><path d="M16 11v-.5A1.5 1.5 0 0 1 17.5 9h0A1.5 1.5 0 0 1 19 10.5V15c0 3.5-2.2 6-6 6h-1c-3 0-5.5-1.8-6.7-4.5L4 13.5a1.6 1.6 0 0 1 2.7-1.7L8 14"/></svg>',
		'flask'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 3h6"/><path d="M10 3v5.4L5.2 17a3.2 3.2 0 0 0 2.7 4.8h8.2A3.2 3.2 0 0 0 18.8 17L14 8.4V3"/><path d="M8.2 14h7.6"/></svg>',
		'spark'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/><path d="m6.2 6.2 2 2M15.8 15.8l2 2M17.8 6.2l-2 2M8.2 15.8l-2 2"/><circle cx="12" cy="12" r="3.2"/></svg>',
		'shield'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 5 6.2v5.4C5 16.3 8 19.8 12 21c4-1.2 7-4.7 7-9.4V6.2L12 3z"/><path d="m9 12 2 2 4-4"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

if ( ! defined( 'SINVUK_GALLERY_SLOTS' ) ) {
	define( 'SINVUK_GALLERY_SLOTS', 24 );
}

/**
 * Gallery items.
 *
 * If any Customizer gallery slot is filled, only the filled slots are shown
 * (in slot order). Otherwise the six theme default images are shown.
 * Alt text is taken from the Media Library when the image is an attachment.
 *
 * @return array
 */
function sinvuk_get_gallery() {
	$alts = array(
		1 => 'Ručno pranje sunđerom i penom',
		2 => 'Pranje vetrobrana luksuznog automobila',
		3 => 'Sušenje i nega sjajnog crnog laka',
		4 => 'Detaljno čišćenje vetrobrana',
		5 => 'Ručno pranje crnog vozila',
		6 => 'Radni prostor auto perionice',
	);
	$items = array();
	for ( $i = 1; $i <= SINVUK_GALLERY_SLOTS; $i++ ) {
		$custom = sinvuk_mod( 'gallery_' . $i );
		if ( ! is_string( $custom ) || '' === $custom ) {
			continue;
		}
		$alt = '';
		$id  = attachment_url_to_postid( $custom );
		if ( $id ) {
			$alt = trim( (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) );
		}
		$items[] = array(
			'url' => $custom,
			'alt' => '' !== $alt ? $alt : 'Auto Perionica Sin Vuk — naš rad',
		);
	}
	if ( empty( $items ) ) {
		$base = get_template_directory_uri() . '/assets/img';
		for ( $i = 1; $i <= 6; $i++ ) {
			$items[] = array(
				'url' => $base . '/gallery-' . $i . '.jpg',
				'alt' => $alts[ $i ],
			);
		}
	}
	// Fill the last row of the 4-column desktop grid (first item spans 2x2).
	$n = count( $items );
	foreach ( $items as $k => $item ) {
		$items[ $k ]['class'] = '';
	}
	if ( $n > 1 ) {
		$r = ( $n + 3 ) % 4;
		if ( 1 === $r ) {
			$items[ $n - 1 ]['class'] = 'is-full';
		} elseif ( 2 === $r ) {
			$items[ $n - 1 ]['class'] = 'is-wide';
			$items[ $n - 2 ]['class'] = 'is-wide';
		} elseif ( 3 === $r ) {
			$items[ $n - 1 ]['class'] = 'is-wide';
		}
	}
	return $items;
}

/**
 * Allow a full URL or a same-page anchor such as #kontakt.
 *
 * @param string $value Raw value.
 * @return string
 */
function sinvuk_sanitize_url_or_anchor( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	if ( '#' === substr( $value, 0, 1 ) ) {
		return sanitize_text_field( $value );
	}
	return esc_url_raw( $value );
}
