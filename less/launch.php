<?php

require __DIR__ . DS . 'workers' . DS . 'less-php' . DS . 'lessc.inc.php';

$c_less = $config->states->{'plugin_' . md5(File::B(__DIR__))};

$less = new lessc;
$less->setFormatter($c_less->formatterName);
$less->setPreserveComments(isset($c_less->preserveComments));

function do_less_compile($content, $header) {
    global $less;
    $header = (object) $header;
    if(isset($header->fields->less_disable)) {
        return $content;
    }
    if(strpos($content, '</style>') !== false) {
        return preg_replace_callback('#(<style(?:>| .*?>)\s*)([\s\S]+?)(\s*<\/style>)#', function($m) use($less) {
            return $m[1] . $less->compile($m[2]) . $m[3];
        }, $content);
    }
    return $less->compile($content);
}

Filter::add('custom:css', 'do_less_compile', 1);

require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'asset.php';