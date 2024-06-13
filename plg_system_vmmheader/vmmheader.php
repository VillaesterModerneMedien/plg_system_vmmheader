<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.log
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die;

/**
 * Joomla! System Logging Plugin.
 *
 * @since  1.5
 */
class PlgSystemVmmheader extends CMSPlugin
{


    public function onAfterRender()
    {
        $app = Factory::getApplication();

        if($app->isClient('administrator')){
            return;
        }

        $bodyContent = $app->getBody();

        $params = $this->params;

        $headerCode = $params->get('head');
        $bodyCode = $params->get('body');
        $footerCode = $params->get('footer');

        $updatedHtmlContentHead = preg_replace('/(<head[^>]*>)/i', '$1' . $headerCode, $bodyContent, 1);

        $updatedHtmlContentBody = preg_replace('/(<body[^>]*>)/i', '$1' . $bodyCode, $updatedHtmlContentHead);

        $updatedHtmlContentFooter = preg_replace('/(<\/body>)/i', $footerCode . '$1', $updatedHtmlContentBody);

        $app->setBody($updatedHtmlContentFooter);

    }
}
