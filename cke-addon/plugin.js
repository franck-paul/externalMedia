CKEDITOR.plugins.add('externalmedia', {
	requires:"dialog",

	init: function(editor) {
		editor.addCommand('externalMediaCommand', new CKEDITOR.dialogCommand('externalMediaDialog'));

		CKEDITOR.dialog.add('externalMediaDialog', this.path+'dialogs/popup.js');

		editor.ui.addButton("ExternalMedia", {
			label: extmedia_title,
			command: 'externalMediaCommand',
			icon: this.path+'icons/icon.png'
		});
	}
});
