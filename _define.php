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

if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */			"External Media",
	/* Description*/		"Insert external media from Internet",
	/* Author */			"Olivier Meunier",
	/* Version */			'0.8',
	/* Permissions */		'usage,contentadmin',
	/* Priority */			50
);
?>
