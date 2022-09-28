<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="lg:ml-72 px-4 pt-4">
    <div class="border p-4 bg-white mb-4">
        <h1 class="text-2xl">Modules</h1>
    </div>
    <div class="grid grid-cols-4 gap-4">
        {foreach $available_modules as $module}
            {if $module->getPath()|in_array:$active_modules}
                {assign var="module_active" value="true"}
            {else}
                {assign var="module_active" value="false"}
            {/if}
            <div class="border bg-white">
                <div class="p-4">
                    <div class="flex justify-between items-baseline mb-4">
                        {if $module_active=="true"}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-6 h-6 text-green">
                                <path fill-rule="evenodd"
                                      d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z"
                                      clip-rule="evenodd"/>
                            </svg>
                        {else}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-6 h-6">
                                <path fill-rule="evenodd"
                                      d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm6-2.438c0-.724.588-1.312 1.313-1.312h4.874c.725 0 1.313.588 1.313 1.313v4.874c0 .725-.588 1.313-1.313 1.313H9.564a1.312 1.312 0 01-1.313-1.313V9.564z"
                                      clip-rule="evenodd"/>
                            </svg>
                        {/if}
                        <p class="font-bold text-xl">{$module->getName()}</p>
                        <span class="text-sm font-bold">{$module->getVersion()}</span>
                    </div>
                    <p class="text-sm"><a href="{$module->getAuthorUri()}">{$module->getAuthor()}</a></p>
                    <p class="italic mt-4">{$module->getDescriptionTrim()}</p>
                </div>
                <div class="grid grid-cols-2 border-t text-center">
                    <a class="border-r p-2 text-sm transition duration-200 hover:bg-gray-50 hover:cursor-pointer"
                       href="{$home_url}configuration/modules.php?config={$module->getPath()}">Configuration</a>
                    <a class="p-2 text-sm transition duration-200 hover:bg-gray-50 hover:cursor-pointer"
                       href="{$home_url}configuration/modules.php?{if $module_active=="true"}deactivate{else}activate{/if}={$module->getPath()}">{if $module_active=="true"}Deactivate{else}Activate{/if}</a>
                </div>
            </div>
            {assign var="module_active" value="false"}
        {/foreach}
    </div>
</main>

</body>