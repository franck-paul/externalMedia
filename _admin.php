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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

// dead but useful code, in order to have translations
__('External Media') . __('Insert external media from Internet');

class externalMediaBehaviors
{
    public static function adminPageHTTPHeaderCSP($csp)
    {
        if (!isset($csp['script-src'])) {
            $csp['script-src'] = '';
        }
        $csp['script-src'] .= ' ' . 'https://api.embed.ly';
    }

    public static function adminBlogPreferencesForm($settings)
    {
        echo
        '<div class="fieldset"><h4 id="external_media">' . __('External Media') . '</h4>' . "\n" .
        '<p><label>' .
        __('embed.ly API Key:') . ' ' .
        form::field('extmedia_api_key', 25, 50, $settings->extmedia->api_key) .
        '</label></p>' . "\n" .
        '<p class="form-note">' . __('See <a href="https://app.embed.ly/signup">embed.ly</a> web site in order to get your free API Key.') . '</p>' . "\n" .
            '</div>' . "\n";
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->extmedia->put('api_key', empty($_POST['extmedia_api_key']) ? '' : $_POST['extmedia_api_key'], 'string');
    }

    public static function adminPostEditor($editor = '')
    {
        $res = '';
        if ($editor == 'dcLegacyEditor') {
            $res = dcPage::jsJson('dc_editor_extmedia', ['title' => __('External media')]) .
            dcPage::jsModuleLoad('externalMedia/js/post.js', dcCore::app()->getVersion('externalMedia'));
        } elseif ($editor == 'dcCKEditor') {
            $res = dcPage::jsJson('ck_editor_extmedia', [
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
                'api_key'      => dcCore::app()->blog->settings->extmedia->api_key,
            ]);
        }

        return $res;
    }

    public static function ckeditorExtraPlugins(ArrayObject $extraPlugins)
    {
        $extraPlugins[] = [
            'name'   => 'externalmedia',
            'button' => 'ExternalMedia',
            'url'    => DC_ADMIN_URL . 'index.php?pf=externalMedia/cke-addon/',
        ];
    }
}

dcCore::app()->addBehaviors([
    'adminPageHTTPHeaderCSP'        => [externalMediaBehaviors::class, 'adminPageHTTPHeaderCSP'],
    'adminBlogPreferencesFormV2'    => [externalMediaBehaviors::class, 'adminBlogPreferencesForm'],
    'adminBeforeBlogSettingsUpdate' => [externalMediaBehaviors::class, 'adminBeforeBlogSettingsUpdate'],
    'adminPostEditor'               => [externalMediaBehaviors::class, 'adminPostEditor'],
    'ckeditorExtraPlugins'          => [externalMediaBehaviors::class, 'ckeditorExtraPlugins'],
]);
