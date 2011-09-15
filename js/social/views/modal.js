SC.Views.Modal = Backbone.View.extend({
  initialize: function() {
    _.bindAll(this, 'render', 'unrender', 'close', '_toggleModal');
  
    this.bind('modal:closing', this.unrender, this);
    this.render();
  },

  events: {
    'click .close': 'close'
  },

  render: function() {
    var template = template || this.template(this.model.toJSON());
    $(this.el).html(template);
    if (this.didRenderTemplate) this.didRenderTemplate();

    this._toggleModal(false);

    $('body').append(this.el);
  },

  unrender: function() {
    this.remove();
    this._toggleModal(true);
    this.trigger('modal:closed');
  },

  close: function() {
    this.trigger('modal:closing');
    return false;
  },

  _toggleModal: function(show) {
    $('#header, #wrapper, #footer').toggle(show);
    $('body').toggleClass('modal-view', !show); 
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