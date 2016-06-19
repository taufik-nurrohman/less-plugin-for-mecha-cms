<?php

function do_auto_compile_less($input, $output) {
    global $less;
    $cache = CACHE . DS . 'less' . DS . File::B($input) . '.cache';
    if(File::exist($cache)) {
        $c = File::open($cache)->unserialize();
    } else {
        $c = $input;
    }
    $n = $less->cachedCompile($c);
    if( ! is_array($c) || $n['updated'] > $c['updated']) {
        File::serialize($n)->saveTo($cache);
        File::write($n['compiled'])->saveTo($output);
    }
}

Asset::plug('less', function($path, $addon = "", $merge = false) {
    $path_less = is_string($path) ? explode(' ', $path) : (array) $path;
    $path_css = array();
    foreach($path_less as $p) {
        $p = Asset::path($p);
        if(substr($p, -4) === '.css') {
            $path_css[] = $p;
            continue;
        }
        $s = str_replace('.less' . X, '.css', $p . X);
        do_auto_compile_less($p, $s);
        $path_css[] = $s;
    }
    return Asset::stylesheet($path_css, $addon, $merge);
});