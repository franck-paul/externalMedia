/*global $, dotclear */
'use strict';

$(() => {
  Object.assign(dotclear, dotclear.getData('external_media'));

  $('#media-insert-cancel').on('click', () => {
    window.close();
  });

  $('#media-insert-ok').on('click', () => {
    const url = $('#media-insert-form').get(0).m_url.value;
    if (dotclear.external_media.api_key == undefined || dotclear.external_media.api_key == '') {
      window.alert(dotclear.external_media.missing_key);
    } else {
      $.getJSON(`https://api.embed.ly/1/oembed?url=${url}&key=${dotclear.external_media.api_key}&callback=?`, (data) => {
        sendClose(data.html);
      }).fail((xhr) => {
        window.alert(`${dotclear.external_media.request_error + xhr.status} ${xhr.statusText}`);
      });
    }
  });
});

function sendClose(object) {
  const insert_form = $('#media-insert-form').get(0);
  if (insert_form == undefined) {
    return;
  }

  const tb = window.opener.the_toolbar;
  const data = tb.elements.extmedia.data;

  data.alignment = $('input[name="alignment"]:checked', insert_form).val();
  data.title = insert_form.m_title.value;
  data.url = insert_form.m_url.value;
  data.m_object = object;

  tb.elements.extmedia.fncall[tb.mode].call(tb);
  window.close();
}
