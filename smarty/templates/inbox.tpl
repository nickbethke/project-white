<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="lg:ml-72 px-4 pt-4">
    <div class="bg-white border flex justify-start items-center">
        <div class="h-14 border-r">
            <div class="p-4 pl-5 leading-[16px]">
                <input type="checkbox"
                       class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2"/>
            </div>
        </div>
        <div class="border-r h-14">
            <input type="search"
                   class="lg:w-[500px] p-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="Search..."/>
        </div>
        <a class="p-4 hover:bg-gray-50 border-r" href="{$home_url}/inbox.php?action=create">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>

        </a>
        <div class="py-4 px-2 hover:bg-gray-50 hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
            </svg>

        </div>
        <div class="py-4 px-2 hover:bg-gray-50 hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
        </div>
        <div class="py-4 px-2 hover:bg-gray-50 border-r hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
        </div>
    </div>
    <div>
        {if $notification_repo->length() < 1}
            <div class="relative bg-white border border-t-0 leading-4 flex justify-start items-center p-4 pl-5">
                -- no notifications --
            </div>
        {else}
            {foreach $notification_repo as $not}
                <a href="{$home_url}/inbox.php?view={$not->getID()}">
                    <div class="relative bg-white border border-t-0 leading-4 flex justify-start items-center hover:bg-gray-50 hover:cursor-pointer relative {if $not->getStatus() eq 0}font-bold{/if}">
                        <div class="absolute w-1 h-full {if $not->getStatus() eq 0}bg-green-400{/if}"></div>
                        <div class="p-4 pl-5 border-r h-full">
                            <input type="checkbox"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 leading-4"/>
                        </div>
                        <div class="p-4 leading-4 hidden lg:block lg:w-64 border-r">
                            {if $not->getFrom()->getId() == $user->getId()}
                                Project White
                            {else}
                                {$not->getFrom()->getFirstname()} {$not->getFrom()->getSurname()}
                            {/if}
                        </div>
                        <div class="p-4 w-[300px] lg:w-auto leading-4">
                            {$not->getTitle()}
                        </div>
                        <div class="p-4 ml-auto border-l">
                            {$not->getDateTime()|date_format:"%d.%m.%Y %H:%M:%S"}
                        </div>
                    </div>
                </a>
            {/foreach}
        {/if}
    </div>
</main>
</body>