<?php

require_once ABSPATH . "vendor/tracy/tracy/src/Tracy/Bar/IBarPanel.php";

class CachePanel implements \Tracy\IBarPanel
{

    function getTab(): string
    {
        return '<span title="tooltip">
	                <span class="tracy-label">Cache</span>
                </span>';
    }

    function getPanel(): string
    {
        global $optionCache;
        $cached = $optionCache->get_cache();

        $r = '<h1>Cache</h1>
                <div class="tracy-inner">
                    <div class="tracy-inner-container">
                             <h2>Cache directory</h2>
	                   <table class="tracy-sortable">
                            <tbody>
                            <tr><td>Smarty Cache</td><td>' . self::format_bytes(self::get_directory_size(ABSPATH . "smarty/cache")) . '</td></tr>                        
                            <tr><td>Smarty Compiled</td><td>' . self::format_bytes(self::get_directory_size(ABSPATH . "smarty/compile")) . '</td></tr>
                            </tbody>
                            </table>
                    <h2>
                    <a class="tracy-toggle tracy-collapsed" data-tracy-ref="^div .tracy-CachePanel-packages">Options (' . sizeof($cached) . ')</a>
</h2>
<div class="tracy-CachePanel-packages tracy-collapsed">
	                   <table class="tracy-sortable">
                            <tbody>';
        foreach ($cached as $name => $value) {
            $r .= "<tr><td>" . $name . "</td><td>" . $value . "</td></tr>";
        }

        $r .= '</tbody>
                        </table>
                        </div>
                    </div>
                </div>';
        return $r;
    }

    static function get_directory_size($path)
    {
        $bytesTotal = 0;
        $path = realpath($path);
        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $bytesTotal += $object->getSize();
            }
        }
        return $bytesTotal;
    }

    static function format_bytes($bytes, $precision = 2)
    {
        if ($bytes < 1) {
            return "0 B";
        }
        $base = log($bytes, 1024);
        $suffixes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}