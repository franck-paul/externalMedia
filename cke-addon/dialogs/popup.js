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
			var dialog = this;
			var url = dialog.getValueOf('tab-url', 'url');
			var alignment = dialog.getValueOf('tab-alignment', 'alignment');

			$.getJSON('http://oohembed.com/oohembed/?url='+url+'&key='+extmedia_api_key+'&callback=?',
				  function(data) {
					  var div = editor.document.createElement('div');
					  var style = '';
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
