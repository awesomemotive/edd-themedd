<?php
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'themedd_site_before' ); ?>

<div id="page" class="hfeed site">

	<?php do_action( 'themedd_header' ); ?>

	<div id="content" class="site-content">

	<?php do_action( 'themedd_content_start' ); ?>
