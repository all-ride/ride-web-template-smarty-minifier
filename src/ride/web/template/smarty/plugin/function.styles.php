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

    $dependencyInjector = $app['system']->getDependencyInjector();
    $service = $dependencyInjector->get('ride\\service\\MinifierService');

    foreach ($styles as $media => $mediaStyles) {
        $minifiedStyles = $service->minifyCss(array_keys($mediaStyles));
        foreach ($minifiedStyles as $minifiedStyle) {
            $tags[] = '<link rel="stylesheet" type="text/css" href="' . $minifiedStyle . '" media="' . $media . '">';
        }
    }

    return implode("\n        ", $tags);
}
