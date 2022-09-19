<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="ml-72 px-4 pt-4">
<div class="border p-4 bg-white">
    {$user->getFirstname()} {$user->getSurname()}
</div>
</main>

<script src="/content/js/menu.js"></script>

</body>