/*global jsToolBar, dotclear */
'use strict';

dotclear.ready(() => {
  const data = dotclear.getData('dc_editor_extmedia');

  jsToolBar.prototype.elements.extmedia = {
    group: 'media',
    type: 'button',
    title: data.title || 'External Media',
    icon: data.icon,
    icon_dark: data.icon_dark,
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
        res += ` ${data.style.class ? 'class' : 'style'}="${data.style.left}"`;
      } else if (d.alignment == 'right') {
        res += ` ${data.style.class ? 'class' : 'style'}="${data.style.right}"`;
      } else if (d.alignment == 'center') {
        res += ` ${data.style.class ? 'class' : 'style'}="${data.style.center}"`;
      }

      res += `>\n${d.m_object}`;

      if (d.title) {
        if (d.url) {
          d.title = `<a href="${d.url}">${d.title}</a>`;
        }
        res += `\n<br>${d.title}`;
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
