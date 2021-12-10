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
    'External Media',                                // Name
    'Insert external media from Internet',           // Description
    'Olivier Meunier, Franck Paul and contributors', // Author
    '1.5',                                           // Version
    [
        'requires'    => [['core', '2.19']],                             // Dependencies
        'permissions' => 'usage,contentadmin',                           // Permissions
        'type'        => 'plugin',                                       // Type
        'priority'    => 1001,                                           // Priority
        'settings'    => [
            'self' => false,
            'blog' => '#params.external_media',
        ],

        'details'    => 'https://open-time.net/?q=externalMedia',       // Details URL
        'support'    => 'https://github.com/franck-paul/externalMedia', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/externalMedia/master/dcstore.xml',
    ]
);
