<?php

function smarty_function_style($params, &$smarty) {
     // <link rel="stylesheet" type="text/css" href="print.css" media="print">
    $src = null;

    try {
        if (!isset($params['src']) || !$params['src']) {
            throw new Exception('Could not add style: no src parameter provided');
        }
        $src = $params['src'];

        if (!isset($params['media'])) {
            $media = 'all';
        } else {
            $media = $params['media'];
        }

        $app = $smarty->getTemplateVars('app');
        if (!isset($app['minifier']['styles'])) {
            $app['minifier']['styles'] = array($media => array());
        } elseif (!isset($app['minifier']['styles'][$media])) {
            $app['minifier']['styles'][$media] = array();
        }

        $app['minifier']['styles'][$media][$src] = true;

        $smarty->assign('app', $app);
    } catch (Exception $exception) {
        $app = $smarty->getTemplateVars('app');
        if (isset($app['system'])) {
            $log = $app['system']->getDependencyInjector()->get('ride\\library\\log\\Log');
            $log->logException($exception);
        }
    }

    return;
}
