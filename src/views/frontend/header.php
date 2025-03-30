<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo danupe()->config()->get('core.meta.title'); ?></title>
    <meta name="description" content="<?php echo danupe()->config()->get('core.meta.description'); ?>">
    <meta name="keywords" content="<?php echo danupe()->config()->get('core.meta.keywords'); ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/<?php echo danupe()->plugin('user', 'admin')->getPrefix(); ?>/css/tailwind.output.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />


    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.js"></script> -->

    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer></script>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">