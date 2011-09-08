SC.Views.Modal = Backbone.View.extend({
  initialize: function() {
    _.bindAll(this, 'render', 'openModal', '_onOpen', '_onShow', '_onClose');
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
    return this;
  },

  openModal: function() {
    $.modal(this.render().el, { 
      overClose: true, 
      position: ['80px', ''],
      onOpen: self._onOpen,
      onShow: self._onShow, 
      onClose: self._onClose
    });
  },

  _onOpen: function(dialog) {
    dialog.overlay.fadeIn('fast');
    dialog.container.show();
    dialog.data.fadeIn('fast');
  },

  _onShow: function(dialog) {
    $('input[placeholder], textarea[placeholder]', dialog.data).placeholder();
  },

  _onClose: function(dialog) {
    $.modal.close();
  }
});