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

    foreach ($app['minifier']['scripts'] as $script => $dummy) {
        if (substr($script, 0, 7) == 'http://' || substr($script, 0, 8) == 'https://' || substr($script, 0, 2) == '//') {
            $tags[$script] = '<script type="text/javascript" src="' . $script . '"></script>';
        } elseif (substr($script, 0, 7) == '<script') {
            $tags[$script] = $script;
        } else {
            $minifierScripts[$script] = true;
        }
    }

    if ($minifierScripts) {
        $config = $dependencyInjector->get('ride\\library\\config\\Config');
        $disabled = $config->get('minifier.disabled', true);

        if ($disabled) {
            $baseUrl = $app['url']['base'] . '/';

            foreach ($minifierScripts as $script => $dummy) {
                $tags[$script] = '<script type="text/javascript" src="' . $baseUrl . $script . '"></script>';
            }
        } else {
            $fileBrowser = $app['system']->getFileBrowser();
            $log = $dependencyInjector->get('ride\\library\\log\\Log');
            $minifier = $dependencyInjector->get('ride\\library\\minifier\\Minifier', 'js');

            $log->logDebug('Rendering minified script');
            foreach ($minifierScripts as $script => $dummy) {
                $log->logDebug('- ' . $script);
            }

            $minifiedScript = $minifier->minify(array_keys($minifierScripts));
            $minifiedScript = $fileBrowser->getRelativeFile($minifiedScript, true);

            $log->logDebug('Rendered minified script ' . $minifiedScript);

            $minifiedScript = $app['url']['base'] . '/' . $minifiedScript;

            $tags[$script] = '<script type="text/javascript" src="' . $minifiedScript . '"></script>';
        }
    }

    return implode("\n        ", $tags);
}
