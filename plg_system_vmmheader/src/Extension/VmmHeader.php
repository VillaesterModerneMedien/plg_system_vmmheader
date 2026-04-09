<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.vmmheader
 *
 * @copyright   Copyright (C) VillaesterModerneMedien. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VillaesterModerneMedien\Plugin\System\VmmHeader\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

final class VmmHeader extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onAfterRender' => 'onAfterRender',
        ];
    }

    public function onAfterRender(Event $event): void
    {
        $app = $this->getApplication();

        if ($app->isClient('administrator')) {
            return;
        }

        $document = $app->getDocument();

        if ($document->getType() !== 'html') {
            return;
        }

        $input = $app->getInput();

        if (
            $input->get('option') === 'com_ajax'
            || $input->get('p') === 'customizer'
            || $input->post->get('customizer_session')
            || $input->post->get('customizer')
        ) {
            return;
        }

        $body = $app->getBody();

        $headerCode = $this->params->get('head', '');
        $bodyCode   = $this->params->get('body', '');
        $footerCode = $this->params->get('footer', '');

        if ($headerCode) {
            $body = preg_replace('/(<head[^>]*>)/i', '$1' . $headerCode, $body, 1);
        }

        if ($bodyCode) {
            $body = preg_replace('/(<body[^>]*>)/i', '$1' . $bodyCode, $body, 1);
        }

        if ($footerCode) {
            $body = preg_replace('/(<\/body>)/i', $footerCode . '$1', $body, 1);
        }

        $app->setBody($body);
    }
}
