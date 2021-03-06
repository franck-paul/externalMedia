/*global dotclear, getData, CKEDITOR */
'use strict';

dotclear.ck_extmedia = getData('ck_editor_extmedia');

(function() {

  CKEDITOR.plugins.add('externalmedia', {
    requires: "dialog",

    init: function(editor) {
      editor.addCommand('externalMediaCommand', new CKEDITOR.dialogCommand('externalMediaDialog'));

      CKEDITOR.dialog.add('externalMediaDialog', this.path + 'dialogs/popup.js');

      editor.ui.addButton("ExternalMedia", {
        label: dotclear.ck_extmedia.title,
        command: 'externalMediaCommand',
        icon: this.path + 'icons/icon.png'
      });
    }
  });
})();
