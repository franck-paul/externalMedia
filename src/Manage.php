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

use dcCore;
use Dotclear\Core\Backend\Notices;
use Dotclear\Core\Backend\Page;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\Button;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Hidden;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Url;
use Dotclear\Helper\Html\Html;

class Manage extends Process
{
    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        // Only in popup mode
        return self::status(My::checkContext(My::MANAGE) && !empty($_REQUEST['popup']));
    }

    /**
     * Processes the request(s).
     */
    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        return true;
    }

    /**
     * Renders the page.
     */
    public static function render(): void
    {
        if (!self::status()) {
            return;
        }

        $settings = dcCore::app()->blog->settings->get(My::id());

        $head = My::jsLoad('popup.js') .
            Page::jsJson('external_media', ['external_media' => [
                'api_key'       => $settings->api_key,
                'missing_key'   => __('embed.ly API Key missing, see blog settings'),
                'request_error' => __('embed.ly API error: '),
            ]]);

        Page::openModule(__('External media selector'), $head);

        echo Page::breadcrumb(
            [
                Html::escapeHTML(dcCore::app()->blog->name) => '',
                __('External media selector')               => '',
            ]
        );
        echo Notices::getNotices();

        // Form
        $m_url = !empty($_POST['m_url']) ? $_POST['m_url'] : null;

        if (!$m_url) {
            echo (new Form('media-external-form'))
                ->action(dcCore::app()->admin->getPageURL() . '&popup=1')
                ->method('post')
                ->fields([
                    (new Text('h3', __('Supported media services'))),
                    (new Para())->items([
                        (new Text(null, __('See <a href="https://embed.ly/providers">this site</a> for supported services'))),
                    ]),
                    (new Para())->items([
                        (new Text(null, __('Please enter the URL of the page containing the video you want to include in your post.'))),
                    ]),
                    (new Para())->items([
                        (new Url('m_url'))
                            ->size(50)
                            ->maxlength(255)
                            ->label((new Label(__('Page URL:'), Label::INSIDE_TEXT_BEFORE))),
                    ]),
                    (new Para())->items([
                        (new Submit(['frmsubmit']))
                            ->value(__('Ok')),
                        dcCore::app()->formNonce(false),
                    ]),
                ])
            ->render();
        } else {
            $i_align = [
                'none'   => [__('None'), 0],
                'left'   => [__('Left'), 0],
                'right'  => [__('Right'), 0],
                'center' => [__('Center'), 1],
            ];
            $aligns = [];
            $i      = 0;
            foreach ($i_align as $k => $v) {
                $aligns[] = (new Radio(['alignment', 'alignment' . ++$i], (bool) $v[1]))
                    ->value($k)
                    ->label((new Label($v[0], Label::INSIDE_TEXT_AFTER)));
            }

            echo (new Form('media-insert-form'))
                ->method('get')
                ->fields([
                    (new Text('h3', __('Media alignment'))),
                    (new Para())->items([
                        ...$aligns,
                    ]),
                    (new Text('h3', __('Media title'))),

                    (new Para())->items([
                        (new Input('m_title'))
                            ->size(50)
                            ->maxlength(255)
                            ->label((new Label(__('Title:'), Label::INSIDE_TEXT_BEFORE))),
                    ]),
                    (new Para())->separator(' ')->items([
                        (new Hidden(['m_url'], Html::escapeHTML($m_url))),
                        (new Button('media-insert-ok'))
                            ->class('submit')
                            ->value(__('Insert')),
                        (new Button('media-insert-cancel'))
                            ->class('submit')
                            ->value(__('Cancel')),
                    ]),
                ])
            ->render();
        }

        Page::closeModule();
    }
}
