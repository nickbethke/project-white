<?php

namespace CLI;

abstract class Runnable
{
    const INFO = 'color_10';
    const DEFAULT = 'color_15';
    const WARNING = 'color_220';
    const TODO = 'color_14';

    abstract public static function run(mixed $args): void;

    public static function prompt($msg): bool
    {
        echo $msg . " (N)o|(y)es: ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return trim($line) == 'yes' || trim($line) == 'y' || trim($line) == 'Y' || trim($line) == 'Yes';

    }

    public static function input($msg): string
    {
        echo $msg . ": ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return trim($line);

    }

    public static function header($html = false): string
    {
        if ($html) {
            return "<div style='font-family: monospace'><br/>██████╗&nbsp;██████╗&nbsp;&nbsp;██████╗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██╗███████╗&nbsp;██████╗████████╗&nbsp;&nbsp;&nbsp;&nbsp;██╗&nbsp;&nbsp;&nbsp;&nbsp;██╗██╗&nbsp;&nbsp;██╗██╗████████╗███████╗
<br/>██╔══██╗██╔══██╗██╔═══██╗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║██╔════╝██╔════╝╚══██╔══╝&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;██║██║&nbsp;&nbsp;██║██║╚══██╔══╝██╔════╝
<br/>██████╔╝██████╔╝██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║█████╗&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;█╗&nbsp;██║███████║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;█████╗&nbsp;&nbsp;
<br/>██╔═══╝&nbsp;██╔══██╗██║&nbsp;&nbsp;&nbsp;██║██&nbsp;&nbsp;&nbsp;██║██╔══╝&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║███╗██║██╔══██║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;██╔══╝&nbsp;&nbsp;
<br/>██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;██║╚██████╔╝╚█████╔╝███████╗╚██████╗&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚███╔███╔╝██║&nbsp;&nbsp;██║██║&nbsp;&nbsp;&nbsp;██║&nbsp;&nbsp;&nbsp;███████╗
<br/>╚═╝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;╚═╝&nbsp;╚═════╝&nbsp;&nbsp;╚════╝&nbsp;╚══════╝&nbsp;╚═════╝&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;╚══╝╚══╝&nbsp;╚═╝&nbsp;&nbsp;╚═╝╚═╝&nbsp;&nbsp;&nbsp;╚═╝&nbsp;&nbsp;&nbsp;╚══════╝</div><br/><br/>";
        } else {
            return "\n\t██████╗ ██████╗  ██████╗      ██╗███████╗ ██████╗████████╗    ██╗    ██╗██╗  ██╗██╗████████╗███████╗
\t██╔══██╗██╔══██╗██╔═══██╗     ██║██╔════╝██╔════╝╚══██╔══╝    ██║    ██║██║  ██║██║╚══██╔══╝██╔════╝
\t██████╔╝██████╔╝██║   ██║     ██║█████╗  ██║        ██║       ██║ █╗ ██║███████║██║   ██║   █████╗  
\t██╔═══╝ ██╔══██╗██║   ██║██   ██║██╔══╝  ██║        ██║       ██║███╗██║██╔══██║██║   ██║   ██╔══╝  
\t██║     ██║  ██║╚██████╔╝╚█████╔╝███████╗╚██████╗   ██║       ╚███╔███╔╝██║  ██║██║   ██║   ███████╗
\t╚═╝     ╚═╝  ╚═╝ ╚═════╝  ╚════╝ ╚══════╝ ╚═════╝   ╚═╝        ╚══╝╚══╝ ╚═╝  ╚═╝╚═╝   ╚═╝   ╚══════╝\n\n";
        }
    }
}