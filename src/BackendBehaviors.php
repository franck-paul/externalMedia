<?php
/**
 * @brief externalMedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\externalMedia;

use ArrayObject;
use dcCore;
use dcNamespace;
use Dotclear\Core\Backend\Page;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;

class BackendBehaviors
{
    /**
     * @param   ArrayObject<string, string>     $csp    The csp
     */
    public static function adminPageHTTPHeaderCSP(ArrayObject $csp): string
    {
        if (!isset($csp['script-src'])) {
            $csp['script-src'] = '';
        }
        $csp['script-src'] .= ' ' . 'https://api.embed.ly';

        return '';
    }

    public static function adminBlogPreferencesForm(): string
    {
        $settings = My::settings();
        echo
        (new Fieldset('external_media'))
        ->legend((new Legend(__('External Media'))))
        ->fields([
            (new Para())->items([
                (new Input('extmedia_api_key'))
                    ->size(25)
                    ->maxlength(50)
                    ->value(Html::escapeHTML($settings->api_key))
                    ->label((new Label(__('embed.ly API Key:'), Label::INSIDE_TEXT_BEFORE))),
            ]),
            (new Para())->class('form-note')->items([
                (new Text(null, __('See <a href="https://app.embed.ly/signup">embed.ly</a> web site in order to get your free API Key.'))),
            ]),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(): string
    {
        My::settings()->put('api_key', empty($_POST['extmedia_api_key']) ? '' : $_POST['extmedia_api_key'], dcNamespace::NS_STRING);

        return '';
    }

    public static function adminPostEditor(string $editor = ''): string
    {
        $res = '';
        if ($editor == 'dcLegacyEditor') {
            $data = [
                'title'    => __('External media'),
                'icon'     => urldecode(Page::getPF(My::id() . '/icon.svg')),
                'open_url' => dcCore::app()->adminurl->get('admin.plugin.' . My::id(), [
                    'popup' => 1,
                ], '&'),
                'style' => [
                    'class'  => true,
                    'left'   => 'media-left',
                    'center' => 'media-center',
                    'right'  => 'media-right',
                ],
            ];
            $res = Page::jsJson('dc_editor_extmedia', $data) .
            My::jsLoad('post.js');
        } elseif ($editor == 'dcCKEditor') {
            $data = [
                'title'        => __('External media'),
                'tab_url'      => __('URL'),
                'url'          => __('Page URL:'),
                'url_empty'    => __('URL cannot be empty.'),
                'tab_align'    => __('Alignment'),
                'align'        => __('Media alignment:'),
                'align_none'   => __('None'),
                'align_left'   => __('Left'),
                'align_right'  => __('Right'),
                'align_center' => __('Center'),
                'api_key'      => My::settings()->api_key,
                'style'        => [
                    'class'  => true,
                    'left'   => 'media-left',
                    'center' => 'media-center',
                    'right'  => 'media-right',
                ],
            ];
            $res = Page::jsJson('ck_editor_extmedia', $data);
        }

        return $res;
    }

    /**
     * @param      ArrayObject<int, mixed>  $extraPlugins  The extra plugins
     *
     * @return     string
     */
    public static function ckeditorExtraPlugins(ArrayObject $extraPlugins): string
    {
        $extraPlugins[] = [
            'name'   => 'externalmedia',
            'button' => 'ExternalMedia',
            'url'    => urldecode(DC_ADMIN_URL . Page::getPF(My::id() . '/cke-addon/')),
        ];

        return '';
    }
}
