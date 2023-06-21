/*global jsToolBar, dotclear */
'use strict';

$(() => {
  const data = dotclear.getData('dc_editor_extmedia');

  jsToolBar.prototype.elements.extmedia = {
    type: 'button',
    title: data.title || 'External Media',
    icon: data.icon,
    fn: {},
    fncall: {},
    open_url: data.open_url,
    data: {},
    popup() {
      window.the_toolbar = this;
      this.elements.extmedia.data = {};

      window.open(
        this.elements.extmedia.open_url,
        'dc_popup',
        'alwaysRaised=yes,dependent=yes,toolbar=yes,height=500,width=760,menubar=no,resizable=yes,scrollbars=yes,status=no',
      );
    },
    gethtml() {
      const d = this.data;

      if (d.m_object == '') {
        return false;
      }

      let res = '<div class="external-media"';

      if (d.alignment == 'left') {
        res += ' style="float: left; margin: 0 1em 1em 0;"';
      } else if (d.alignment == 'right') {
        res += ' style="float: right; margin: 0 0 1em 1em;"';
      } else if (d.alignment == 'center') {
        res += ' style="margin: 1em auto; text-align: center;"';
      }

      res += `>\n${d.m_object}`;

      if (d.title) {
        if (d.url) {
          d.title = `<a href="${d.url}">${d.title}</a>`;
        }
        res += `\n<br />${d.title}`;
      }

      res += '\n</div>';
      return res;
    },
  };

  jsToolBar.prototype.elements.extmedia.fn.wiki = function () {
    this.elements.extmedia.popup.call(this);
  };
  jsToolBar.prototype.elements.extmedia.fn.xhtml = function () {
    this.elements.extmedia.popup.call(this);
  };
  jsToolBar.prototype.elements.extmedia.fn.markdown = function () {
    this.elements.extmedia.popup.call(this);
  };

  jsToolBar.prototype.elements.extmedia.fncall.wiki = function () {
    const html = this.elements.extmedia.gethtml();

    this.encloseSelection('', '', () => `///html\n${html}\n///\n`);
  };
  jsToolBar.prototype.elements.extmedia.fncall.xhtml = function () {
    const html = this.elements.extmedia.gethtml();

    this.encloseSelection('', '', () => html);
  };
  jsToolBar.prototype.elements.extmedia.fncall.markdown = function () {
    const html = this.elements.extmedia.gethtml();

    this.encloseSelection('', '', () => html);
  };
});
