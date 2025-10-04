<!DOCTYPE html>
<html lang="tr">

<head>
    <title><?php wp_title(''); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <?php do_action('wp_head'); ?>
</head>

<body <?php body_class(); ?>>
    <noscript class="noscript">This site requires JavaScript to be enabled. Please enable JavaScript in your browser settings</noscript>