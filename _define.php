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
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'External Media',
        'Insert external media from Internet',
        'Olivier Meunier, Franck Paul and contributors',
        '7.0',
        [
            'date'        => '2026-08-03T09:55:24+0200',
            'requires'    => [['core', '2.39']],
            'permissions' => 'My',
            'type'        => 'plugin',
            'priority'    => 1010,  // Must be higher than dcLegacyEditor/dcCKEditor priority (ie 1000)
            'settings'    => [
                'self' => false,
                'blog' => '#params.external_media',
            ],

            'details'    => 'https://open-time.net/?q=externalMedia',
            'support'    => 'https://github.com/franck-paul/externalMedia',
            'repository' => 'https://raw.githubusercontent.com/franck-paul/externalMedia/main/dcstore.xml',
            'license'    => 'gpl2',
        ]
    );
}
