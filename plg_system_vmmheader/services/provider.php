<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.vmmheader
 *
 * @copyright   Copyright (C) VillaesterModerneMedien. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use VillaesterModerneMedien\Plugin\System\VmmHeader\Extension\VmmHeader;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin = new VmmHeader(
                    $container->get(DispatcherInterface::class),
                    (array) PluginHelper::getPlugin('system', 'vmmheader')
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
