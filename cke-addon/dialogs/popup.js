/*global $, CKEDITOR, extmedia_title, extmedia_tab_url, extmedia_url, extmedia_url_empty, extmedia_tab_align, extmedia_align, extmedia_align_none, extmedia_align_left, extmedia_align_right, extmedia_align_center, extmedia_api_key */
'use strict';

CKEDITOR.dialog.add('externalMediaDialog', function(editor) {
	return {
		title: extmedia_title,
		minWidth: 400,
		minHeight: 150,
		contents: [
			{
				id: 'tab-url',
				label: extmedia_tab_url,
				elements: [{
					id: 'url',
					type: 'text',
					label: extmedia_url,
					validate: CKEDITOR.dialog.validate.notEmpty(extmedia_url_empty)
				}]
			},
			{
				id: 'tab-alignment',
				label: extmedia_tab_align,
				elements: [{
					type: 'radio',
					id: 'alignment',
					label: extmedia_align,
					items: [
						[ extmedia_align_none, 'none' ],
						[ extmedia_align_left, 'left' ],
						[ extmedia_align_right, 'right'],
						[ extmedia_align_center, 'center'] ],
					'default': 'none'
				}]
			}
		],
		onOk: function() {
			const dialog = this;
			const url = dialog.getValueOf('tab-url', 'url');
			const alignment = dialog.getValueOf('tab-alignment', 'alignment');

			$.getJSON('https://api.embed.ly/1/oembed?url='+url+'&key='+extmedia_api_key+'&callback=?',
				  function(data) {
					  const div = editor.document.createElement('div');
					  let style = '';
					  div.setAttribute('class', 'external-media');
					  if (alignment == 'left') {
						  style = 'float: left; margin: 0 1em 1em 0;';
					  } else if (alignment == 'right') {
						  style = 'float: right; margin: 0 0 1em 1em;';
					  } else if (alignment == 'center') {
						  style = 'margin: 1em auto; text-align: center;';
					  }
					  if (style!='') {
						  div.setAttribute('style', style);
					  }

					  div.appendHtml(data.html);
					  editor.insertElement(div);
				  });
		}
	};
});
