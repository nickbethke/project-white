<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="ml-72 px-4 pt-4">
    <div class="bg-white border flex justify-start items-center p-4 mb-4 hover:bg-gray-100 hover:cursor-pointer"
         data-collapse-toggle="dropdown-index-overview">
        <h2>Overview</h2>
        <div class="ml-auto">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 closeable-indicator-open">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 closeable-indicator-closed">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </div>

    </div>
    <div id="dropdown-index-overview" class="grid xl:grid-cols-4 lg:grid-cols-3 grid-cols-1 gap-4">
        <div class="bg-white border flex justify-start items-center">
            <div class="p-4 w-full">
                <h3 class="text-xl">Project Status</h3>
                <div class="h-80 w-full">
                    <div id="time-flow"></div>
                </div>
            </div>
        </div>
        <div class="bg-white border flex justify-start items-center">
            <div class="p-4 w-full">
                <h3 class="text-xl">Team Status</h3>
                <div class="h-80 w-full">
                    <div id="team-flow"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    requirejs(['home']);
</script>
</body>