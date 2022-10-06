<?php

function guess_url(): string
{
    $abspath_fix = str_replace('\\', '/', ABSPATH);
    $script_filename_dir = dirname($_SERVER['SCRIPT_FILENAME']);

    if ($script_filename_dir . '/' === $abspath_fix) {
        $path = preg_replace('#/[^/]*$#i', '', $_SERVER['PHP_SELF']);

    } else {
        if (str_contains($_SERVER['SCRIPT_FILENAME'], $abspath_fix)) {
            $directory = str_replace(ABSPATH, '', $script_filename_dir);
            $path = preg_replace('#/' . preg_quote($directory, '#') . '/[^/]*$#i', '', $_SERVER['REQUEST_URI']);
        } elseif (str_contains($abspath_fix, $script_filename_dir)) {
            $subdirectory = substr($abspath_fix, strpos($abspath_fix, $script_filename_dir) + strlen($script_filename_dir));
            $path = preg_replace('#/[^/]*$#i', '', $_SERVER['REQUEST_URI']) . $subdirectory;
        } else {
            $path = $_SERVER['REQUEST_URI'];
        }
    }
    $schema = is_ssl() ? 'https://' : 'http://';
    $url = $schema . $_SERVER['HTTP_HOST'] . $path;
    return rtrim($url, '/');
}

function is_ssl(): bool
{
    if (isset($_SERVER['HTTPS'])) {
        if ('on' === strtolower($_SERVER['HTTPS'])) {
            return true;
        }

        if ('1' == $_SERVER['HTTPS']) {
            return true;
        }
    } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
        return true;
    }
    return false;
}

function get_option(string $option, mixed $default = false): mixed
{
    if (class_exists('Options')) {
        return Options::get_option($option, $default);
    } else {
        return $default;
    }
}

function update_option(string $name, mixed $value): bool
{
    return Options::update_option($name, $value);
}

function get_post_vars(): bool|array|null
{
    return filter_input_array(INPUT_POST);
}

function favicon(): string
{
    return '<link rel="apple-touch-icon" sizes="180x180" href="' . get_option('home_url', "/") . 'content/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="' . get_option('home_url', "/") . 'content/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="' . get_option('home_url', "/") . 'content/img/favicon/favicon-16x16.png">
<link rel="manifest" href="' . get_option('home_url', "/") . 'content/img/favicon/site.webmanifest" crossorigin="use-credentials">
<link rel="mask-icon" href="' . get_option('home_url', "/") . 'content/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="' . get_option('home_url', "/") . 'content/img/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#603cba">
<meta name="msapplication-config" content="' . get_option('home_url', "/") . 'content/img/favicon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<meta name = "description" content = "The perfect project-management tool for all your projects." >
<meta property = "og:url" content = "' . get_option('home_url', "/") . '" >
<meta property = "og:type" content = "website" >
<meta property = "og:title" content = "Project White" >
<meta property = "og:description" content = "The perfect project-management tool for all your projects." >
<meta property = "og:image" content = "' . get_option('home_url', "/") . 'content/img/og-image.png" >
<meta name = "twitter:card" content = "summary_large_image" >
<meta property = "twitter:domain" content = "project-white.ntk-music.de" >
<meta property = "twitter:url" content = "' . get_option('home_url', "/") . '" >
<meta name = "twitter:title" content = "Project White" >
<meta name = "twitter:description" content = "The perfect project-management tool for all your projects." >
<meta name = "twitter:image" content = "' . get_option('home_url', "/") . 'content/img/og-image.png" >
';
}

function is_installed(): bool
{
    return file_exists(ABSPATH . "_public/install.php");
}