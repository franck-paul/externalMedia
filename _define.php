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

if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
    "External Media",                                // Name
    "Insert external media from Internet",           // Description
    "Olivier Meunier, Franck Paul and contributors", // Author
    '1.4',                                           // Version
    [
        'requires'    => [['core', '2.17']],                             // Dependencies
        'permissions' => 'usage,contentadmin',                           // Permissions
        'type'        => 'plugin',                                       // Type
        'priority'    => 1001,                                           // Priority
        'support'     => 'https://github.com/franck-paul/externalMedia', // Support URL
        'settings'    => [
            'self' => false,
            'blog' => '#params.external_media'
        ]
    ]
);
