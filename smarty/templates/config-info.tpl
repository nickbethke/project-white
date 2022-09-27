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
        <div class="grid grid-cols-3 gap-8">
            <div class="w-full">
                <h2 class="text-xl p-4">System</h2>
                <table class="w-full table table-auto border-collapse">
                    <tr class="border-b">
                        <td class="p-4 font-bold">Project White Version</td>
                        <td class="p-4">{$pw_version}</td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-4 font-bold">PHP Version</td>
                        <td class="p-4">{phpversion()}</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold">MySQLi Version</td>
                        <td class="p-4">{$db_server_version} (Client: {$db_client_version})</td>
                    </tr>
                </table>
            </div>
            <div class="w-full">
                <h2 class="text-xl p-4">Composer <p class="text-sm" >{$composer_version}</p></h2>
                <table class="w-full table table-auto border-collapse">
                    <tr class="border-b">
                        <td class="p-4 font-bold">smarty/smarty</td>
                        <td class="p-4">{$smarty_version}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-4 font-bold">tracy/tracy</td>
                        <td class="p-4">{$tracy_version}</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold">phpmailer/phpmailer</td>
                        <td class="p-4">{$phpmailer_version}</td>
                    </tr>
                </table>
            </div>
            <div class="w-full">
                <h2 class="text-xl p-4">Server</h2>
                <table class="w-full table border-collapse">
                    <tr>
                        <td class="p-4 font-bold">Server</td>
                        <td class="p-4">{php_uname("s")} {php_uname("r")}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main>

</body>