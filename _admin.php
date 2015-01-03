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

// dead but useful code, in order to have translations
__('External Media').__('Insert external media from Internet');

$core->addBehavior('adminPostEditor',array('externalMediaBehaviors','adminPostEditor'));

$core->addBehavior('ckeditorExtraPlugins', array('externalMediaBehaviors', 'ckeditorExtraPlugins'));

class externalMediaBehaviors
{
	public static function adminPostEditor($editor='',$context='',array $tags=array())
	{
		$res = '';
		if ($editor == 'dcLegacyEditor') {

			$res =
				'<script type="text/javascript" src="index.php?pf=externalMedia/post.js"></script>'.
				'<script type="text/javascript">'."\n".
				"//<![CDATA[\n".
				dcPage::jsVar('jsToolBar.prototype.elements.extmedia.title',__('External media')).
				"\n//]]>\n".
				"</script>\n";

		} elseif ($editor == 'dcCKEditor') {

			$res =
				'<script type="text/javascript">'."\n"."//<![CDATA[\n".
				dcPage::jsVar('extmedia_title',__('External media')).
				dcPage::jsVar('extmedia_tab_url',__('URL')).
				dcPage::jsVar('extmedia_url',__('Page URL:')).
				dcPage::jsVar('extmedia_url_empty',__('URL cannot be empty.')).
				dcPage::jsVar('extmedia_tab_align',__('Alignment')).
				dcPage::jsVar('extmedia_align',__('Media alignment:')).
				dcPage::jsVar('extmedia_align_none',__('None')).
				dcPage::jsVar('extmedia_align_left',__('Left')).
				dcPage::jsVar('extmedia_align_right',__('Right')).
				dcPage::jsVar('extmedia_align_center',__('Center')).
				"\n//]]>\n"."</script>\n";


		}
		return $res;
	}

	public static function ckeditorExtraPlugins(ArrayObject $extraPlugins, $context='') {
		$extraPlugins[] = array(
			'name' => 'externalmedia',
			'button' => 'ExternalMedia',
			'url' => DC_ADMIN_URL.'index.php?pf=externalMedia/cke-addon/'
		);
	}
}
