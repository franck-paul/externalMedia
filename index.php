<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of externalMedia, a plugin for Dotclear 2.
#
# Copyright (c) Olivier Meunier and contributors
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_CONTEXT_ADMIN')) { return; }

$m_object = $m_title = $m_url = null;
$m_url = !empty($_POST['m_url']) ? $_POST['m_url'] : null;

?>
<html>
<head>
  <title><?php echo __('External media selector') ?></title>
  <script type="text/javascript" src="<?php echo urldecode(dcPage::getPF('externalMedia/popup.js')); ?>"></script>
<?php
		// Set personal API key
		$core->blog->settings->addNamespace('extmedia');
		echo '<script type="text/javascript">'."\n"."//<![CDATA[\n".
			dcPage::jsVar('dotclear.extmedia_api_key',$core->blog->settings->extmedia->api_key).
			"\n//]]>\n"."</script>\n";
?>
</head>

<body>
<?php
echo '<h2>'.__('External media selector').'</h2>';

if (!$m_url)
{
	echo
	'<form action="'.$p_url.'&amp;popup=1" method="post">'.
	'<h3>'.__('Supported media services').'</h3>'.
	'<p>'.__('Please enter the URL of the page containing the video you want to include in your post.').'</p>'.
	'<p><label for="m_url">'.__('Page URL:').'</label> '.
	form::field('m_url',50,250,html::escapeHTML($m_url)).'</p>'.

	'<p><input type="submit" value="'.__('ok').'" />'.
	$core->formNonce().'</p>'.
	'</form>';
}
else
{
	echo
	'<div style="margin: 1em auto; text-align: center;">'.$m_object.'</div>'.
	'<form id="media-insert-form" action="" method="get">';

	$i_align = array(
		'none' => array(__('None'),0),
		'left' => array(__('Left'),0),
		'right' => array(__('Right'),0),
		'center' => array(__('Center'),1)
	);

	echo '<h3>'.__('Media alignment').'</h3>';
	echo '<p>';
	foreach ($i_align as $k => $v) {
		echo '<label class="classic" for"alignement">'.
		form::radio(array('alignment'),$k,$v[1]).' '.$v[0].'</label><br /> ';
	}
	echo '</p>';

	echo
	'<h3>'.__('Media title').'</h3>'.
	'<p><label for="m_title">'.__('Title:').' '.
	form::field('m_title',50,250,html::escapeHTML($m_title)).'</label></p>';

	echo
	'<p><a id="media-insert-cancel" class="button" href="#">'.__('Cancel').'</a> - '.
	'<a id="media-insert-ok" class="button" href="#">'.__('Insert').'</a>'.
	form::hidden('m_url',html::escapeHTML($m_url)).
	'</form>';
}

?>
</body>
</html>
