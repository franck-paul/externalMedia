<?php
/**
 * @brief featuredMedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Olivier Meunier and contributors
 *
 * @copyright Olivier Meunier
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'External Media',
    'Insert external media from Internet',
    'Olivier Meunier, Franck Paul and contributors',
    '2.0',
    [
        'requires'    => [['core', '2.24']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'     => 'plugin',
        'priority' => 1001,
        'settings' => [
            'self' => false,
            'blog' => '#params.external_media',
        ],

        'details'    => 'https://open-time.net/?q=externalMedia',
        'support'    => 'https://github.com/franck-paul/externalMedia',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/externalMedia/master/dcstore.xml',
    ]
);
