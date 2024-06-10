<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.log
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
    use Joomla\Utilities\ArrayHelper;

    defined('_JEXEC') or die;

/**
 * Joomla! System Logging Plugin.
 *
 * @since  1.5
 */
class PlgSystemVmmheader extends JPlugin
{

    protected $app;
    protected $document;


    public function onAfterRender()
    {
        $app = Factory::getApplication();

        if ($app->isClient('site')) {
            $params = $this->params;

            $headerCode = $params->get('head');
            $bodyCode = $params->get('body');
            $footerCode = $params->get('footer');

            $updatedHtmlContentHead = preg_replace('/(<head[^>]*>)/i', '$1' . $headerCode, $app->getBody(), 1);

            $updatedHtmlContentBody = preg_replace('/(<body[^>]*>)/i', '$1' . $bodyCode, $updatedHtmlContentHead);

            $updatedHtmlContentFooter = preg_replace('/(<\/body>)/i', $footerCode . '$1', $updatedHtmlContentBody);

            $app->setBody($updatedHtmlContentFooter);
        }
    }
}
