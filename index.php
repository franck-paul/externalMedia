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

$m_object = $m_title = $m_url = null;
$m_url    = !empty($_POST['m_url']) ? $_POST['m_url'] : null;

?>
<html>
<head>
  <title><?php echo __('External media selector') ?></title>
  <script src="<?php echo urldecode(dcPage::getPF('externalMedia/js/popup.js')); ?>"></script>
<?php
// Set personal API key
dcCore::app()->blog->settings->addNamespace('extmedia');
echo dcPage::jsJson('external_media', ['external_media' => [
    'api_key'       => dcCore::app()->blog->settings->extmedia->api_key,
    'missing_key'   => __('embed.ly API Key missing, see blog settings'),
    'request_error' => __('embed.ly API error: '),
]]);
?>
</head>

<body>
<?php
echo '<h2>' . __('External media selector') . '</h2>';

if (!$m_url) {
    echo
    '<form action="' . dcCore::app()->admin->getPageURL() . '&amp;popup=1" method="post">' .
    '<h3>' . __('Supported media services') . '</h3>' .
    '<p>' . __('Please enter the URL of the page containing the video you want to include in your post.') . '</p>' .
    '<p><label for="m_url">' . __('Page URL:') . '</label> ' .
    form::field('m_url', 50, 250, html::escapeHTML($m_url)) . '</p>' .

    '<p><input type="submit" value="' . __('ok') . '" />' .
    dcCore::app()->formNonce() . '</p>' .
        '</form>';
} else {
    echo
        '<div style="margin: 1em auto; text-align: center;">' . $m_object . '</div>' .
        '<form id="media-insert-form" action="" method="get">';

    $i_align = [
        'none'   => [__('None'), 0],
        'left'   => [__('Left'), 0],
        'right'  => [__('Right'), 0],
        'center' => [__('Center'), 1],
    ];

    echo '<h3>' . __('Media alignment') . '</h3>';
    echo '<p>';
    foreach ($i_align as $k => $v) {
        echo '<label class="classic" for"alignement">' .
        form::radio(['alignment'], $k, $v[1]) . ' ' . $v[0] . '</label><br /> ';
    }
    echo '</p>';

    echo
    '<h3>' . __('Media title') . '</h3>' .
    '<p><label for="m_title">' . __('Title:') . ' ' .
    form::field('m_title', 50, 250, html::escapeHTML($m_title)) . '</label></p>';

    echo
    '<p><a id="media-insert-cancel" class="button" href="#">' . __('Cancel') . '</a> - ' .
    '<a id="media-insert-ok" class="button" href="#">' . __('Insert') . '</a>' .
    form::hidden('m_url', html::escapeHTML($m_url)) .
        '</form>';
}

?>
</body>
</html>
