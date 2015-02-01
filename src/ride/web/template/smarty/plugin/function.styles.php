<?php

function smarty_function_styles($params, &$smarty) {
    if (!isset($params['media'])) {
        $media = null;
    } else {
        $media = $params['media'];
    }

    $app = $smarty->getTemplateVars('app');
    if (!isset($app['system'])) {
        return '<span style="color: red;">Could render the minified styles: system is not available in the app variable.</span>';
    } elseif (!isset($app['minifier']['styles']) || ($media && !isset($app['minifier']['styles'][$media]))) {
        return;
    }

    if ($media) {
        $styles = array($media => $app['minifier']['styles'][$media]);
    } else {
        $styles = $app['minifier']['styles'];
    }

    $tags = array();

    $fileBrowser = $app['system']->getFileBrowser();
    $dependencyInjector = $app['system']->getDependencyInjector();
    $log = $dependencyInjector->get('ride\\library\\log\\Log');
    $minifier = $dependencyInjector->get('ride\\library\\minifier\\Minifier', 'css');
    foreach ($styles as $media => $mediaStyles) {
        $minifierStyles = array();

        foreach ($mediaStyles as $style => $dummy) {
            if (substr($style, 0, 7) == 'http://' || substr($style, 0, 8) == 'https://' || substr($style, 0, 2) == '//') {
                $tags[$style] = '<link rel="stylesheet" type="text/css" href="' . $style . '" media="' . $media . '">';
            } else {
                $minifierStyles[$style] = true;
            }
        }

        if (!$minifierStyles) {
            continue;
        }

        $log->logDebug('Rendering minified style');
        foreach ($minifierStyles as $style => $dummy) {
            $log->logDebug('- ' . $style);
        }

        $minifiedStyle = $minifier->minify(array_keys($minifierStyles));
        $minifiedStyle = $fileBrowser->getRelativeFile($minifiedStyle, true);

        $log->logDebug('Rendered minified style ' . $minifiedStyle);

        $minifiedStyle = $app['url']['base'] . '/' . $minifiedStyle;

        $tags[$style] = '<link rel="stylesheet" type="text/css" href="' . $minifiedStyle . '" media="' . $media . '">';
    }

    return implode("\n        ", $tags);
}
