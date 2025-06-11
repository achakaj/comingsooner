<?php
/**
 * Coming Soon custom header
 */
status_header(503);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> | Coming Soon</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('cs-default-template'); ?>>

