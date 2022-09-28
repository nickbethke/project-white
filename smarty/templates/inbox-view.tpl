<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="lg:ml-72 px-4 pt-4">
    <div class="border bg-white p-4 flex align-middle items-center leading-[1] font-normal">
        <div class="text-sm  px-2">{$notification->getDateTime()|date_format:"%d.%m.%Y %H:%M:%S"}</div>
    </div>
    <div class="border border-t-0 bg-white px-4 py-8">
        <div class="container mx-auto">
            <div class="font-bold">
                {if $notification->getFrom()->getId() == $user->getId()}
                    Project White
                {else}
                    {$notification->getFrom()->getFirstname()} {$notification->getFrom()->getSurname()}
                {/if}</div>
            <div class="text-2xl font-bold my-4">{$notification->getTitle()}</div>
            <div>{$notification->getContent()|nl2br}</div>
        </div>
    </div>
</main>

</body>