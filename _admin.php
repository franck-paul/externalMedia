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

$core->addBehavior('adminPostHeaders',array('externalMediaBehaviors','jsLoad'));
$core->addBehavior('adminPageHeaders',array('externalMediaBehaviors','jsLoad'));
$core->addBehavior('adminRelatedHeaders',array('externalMediaBehaviors','jsLoad'));
$core->addBehavior('adminDashboardHeaders',array('externalMediaBehaviors','jsLoad'));

class externalMediaBehaviors
{
	public static function jsLoad()
	{
		return
		'<script type="text/javascript" src="index.php?pf=externalMedia/post.js"></script>'.
		'<script type="text/javascript">'."\n".
		"//<![CDATA[\n".
		dcPage::jsVar('jsToolBar.prototype.elements.extmedia.title',__('External media')).
		"\n//]]>\n".
		"</script>\n";
	}
}
