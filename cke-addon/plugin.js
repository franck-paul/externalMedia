/*global dotclear, CKEDITOR */
'use strict';

dotclear.ck_extmedia = dotclear.getData('ck_editor_extmedia');

{
  CKEDITOR.plugins.add('externalmedia', {
    requires: 'dialog',

    init(editor) {
      editor.addCommand('externalMediaCommand', new CKEDITOR.dialogCommand('externalMediaDialog'));

      CKEDITOR.dialog.add('externalMediaDialog', `${this.path}dialogs/popup.js`);

      editor.ui.addButton('ExternalMedia', {
        label: dotclear.ck_extmedia.title,
        command: 'externalMediaCommand',
        icon: `${this.path}icons/icon.png`,
      });
    },
  });
}
