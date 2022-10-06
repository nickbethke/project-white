<?php
require_once "../functions.php";
require_once "../version.php";


$step = filter_input(INPUT_GET, 'step', FILTER_SANITIZE_NUMBER_INT);
$step = !$step ? 0 : $step;

function menu_point(string $title, int $active): void
{
    global $step;
    $menuCurrentClasses = "p-4 bg-gray-800 text-white border-r";
    $menuNotCurrentClasses = "p-4 border-r";
    $menuNotCurrentDoneClasses = "p-4 border-r";
    ?>
    <div class="<?php echo $step == $active ? $menuCurrentClasses : ($step > $active ? $menuNotCurrentDoneClasses : $menuNotCurrentClasses) ?>">
        <?php echo $title ?>
        <?php echo $step > $active ? "<span class='font-black text-green'>✓</span>" : "" ?>
    </div>
    <?php
}

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Project White - Installer</title>
    <?php
    echo favicon();
    ?>
    <link rel="stylesheet" href="content/css/main.out.css">
</head>
<body class="bg-gray-800 min-h-full font-sans antialiased font-normal text-base leading-default text-slate-500">
<div class="container mx-auto bg-white min-h-full">
    <div class="bg-gray-200 py-8 px-4">
        <h1 class="text-4xl font-thin">Project White - Installer <span class="text-sm"><?php echo pw_version ?></span>
        </h1>
    </div>
    <div class="bg-gray-50 text-center border-t grid grid-flow-col auto-cols-fr">
        <?php
        menu_point("Welcome", 0);
        menu_point("System Check", 1);
        menu_point("Database Connection", 2);
        menu_point(" Optional Options", 3);
        menu_point("Admin User", 4);
        ?>
    </div>
</div>
</body>
</html>