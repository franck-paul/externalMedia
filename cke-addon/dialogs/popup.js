/*global dotclear, $, CKEDITOR */
'use strict';

CKEDITOR.dialog.add('externalMediaDialog', (editor) => ({
  title: dotclear.ck_extmedia.title,
  minWidth: 400,
  minHeight: 150,
  contents: [
    {
      id: 'tab-url',
      label: dotclear.ck_extmedia.tab_url,
      elements: [
        {
          id: 'url',
          type: 'text',
          label: dotclear.ck_extmedia.url,
          validate: CKEDITOR.dialog.validate.notEmpty(dotclear.ck_extmedia.url_empty),
        },
      ],
    },
    {
      id: 'tab-alignment',
      label: dotclear.ck_extmedia.tab_align,
      elements: [
        {
          type: 'radio',
          id: 'alignment',
          label: dotclear.ck_extmedia.align,
          items: [
            [dotclear.ck_extmedia.align_none, 'none'],
            [dotclear.ck_extmedia.align_left, 'left'],
            [dotclear.ck_extmedia.align_right, 'right'],
            [dotclear.ck_extmedia.align_center, 'center'],
          ],
          default: 'none',
        },
      ],
    },
  ],
  onOk() {
    const url = this.getValueOf('tab-url', 'url');
    const alignment = this.getValueOf('tab-alignment', 'alignment');

    $.getJSON(
      `https://api.embed.ly/1/oembed?url=${url}&key=${dotclear.ck_extmedia.api_key}&callback=?`,
      (data) => {
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
        if (style != '') {
          div.setAttribute('style', style);
        }

        div.appendHtml(data.html);
        editor.insertElement(div);
      }
    );
  },
}));
