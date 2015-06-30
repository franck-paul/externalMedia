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

$core->addBehavior('adminBlogPreferencesForm',array('externalMediaBehaviors','adminBlogPreferencesForm'));
$core->addBehavior('adminBeforeBlogSettingsUpdate',array('externalMediaBehaviors','adminBeforeBlogSettingsUpdate'));
$core->addBehavior('adminPostEditor',array('externalMediaBehaviors','adminPostEditor'));
$core->addBehavior('ckeditorExtraPlugins', array('externalMediaBehaviors', 'ckeditorExtraPlugins'));

class externalMediaBehaviors
{
	public static function adminBlogPreferencesForm($core,$settings)
	{
		$settings->addNameSpace('extmedia');
		echo
		'<div class="fieldset"><h4>'.__('External Media').'</h4>'."\n".
		'<p><label>'.
		__('embed.ly API Key:')." ".
		form::field('extmedia_api_key',25,50,$settings->extmedia->api_key,3).
		'</label></p>'."\n".
		'<p class="form-note">'.__('See <a href="https://app.embed.ly/signup">embed.ly</a> web site in order to get your free API Key.').'</p>'."\n".
		'</div>'."\n";
	}

	public static function adminBeforeBlogSettingsUpdate($settings)
	{
		$settings->addNameSpace('extmedia');
		$settings->extmedia->put('api_key',empty($_POST['extmedia_api_key'])? '' : $_POST['extmedia_api_key'],'string');
	}

	public static function adminPostEditor($editor='',$context='',array $tags=array())
	{
		global $core;

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

			$core->blog->settings->addNamespace('extmedia');
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
				dcPage::jsVar('extmedia_api_key',$core->blog->settings->extmedia->api_key).
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
