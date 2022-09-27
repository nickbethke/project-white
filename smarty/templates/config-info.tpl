<!doctype html>
<html lang="{$lang_code}">
<head>
    {include file='blocks/head.block.tpl'}
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

{include file='blocks/sidenav.block.tpl'}

<main class="ml-72 px-4 pt-4">
    <div class="border p-4 bg-white">
        <h1 class="text-2xl">System Information</h1>
    </div>
    <div class="border p-4 bg-white">
        <div class="grid grid-cols-3">
            <table class="table table-auto border-collapse">
                <tr class="border-b">
                    <td class="p-4">Project White Version</td>
                    <td class="p-4">{$pw_version}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4">PHP Version</td>
                    <td class="p-4">{phpversion()}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4">Smarty Version</td>
                    <td class="p-4">{$smarty.version}</td>
                </tr>
                <tr>
                    <td class="p-4">MySQLi Version</td>
                    <td class="p-4">{$db_server_version} (Client: {$db_client_version})</td>
                </tr>
            </table>
            <div class="grid grid-cols-2">

            </div>
            <div class="grid grid-cols-2">

            </div>
        </div>
    </div>
</main>

</body>