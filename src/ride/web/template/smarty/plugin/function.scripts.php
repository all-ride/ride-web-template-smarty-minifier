<?php

function smarty_function_scripts($params, &$smarty) {
    $app = $smarty->getTemplateVars('app');
    if (!isset($app['system'])) {
        return '<span style="color: red;">Could render the minified scripts: system is not available in the app variable.</span>';
    } elseif (!isset($app['minifier']['scripts'])) {
        return;
    }

    $tags = array();

    $dependencyInjector = $app['system']->getDependencyInjector();
    $service = $dependencyInjector->get('ride\\service\\MinifierService');

    $minifiedScripts = $service->minifyJs(array_keys($app['minifier']['scripts']));
    foreach ($minifiedScripts as $minifiedScript) {
        if (strpos($minifiedScript, '<script') === 0) {
            $tags[] = $minifiedScript;
        } else {
            $tags[] = '<script type="text/javascript" src="' . $minifiedScript . '"></script>';
        }
    }

    return implode("\n        ", $tags);
}
