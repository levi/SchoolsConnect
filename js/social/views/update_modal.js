SC.Views.UpdateModal = SC.Views.Modal.extend({
  template: _.template($('#template-update-modal').html()),

  events: {
    'click .close': 'close',
    'click .destroy': 'destroy'
  },

  initialize: function(options) {
    _.bindAll(this, 'render', 'unrender', '_toggleModal', 'close', 'destroy');

    this.model = new SC.Models.Update({ id: options.update_id, school_id: options.school_id });
    this.model.bind('change', this.render, this);
    this.model.fetch();

    this.bind('modal:closing', this.unrender, this);
    this.render();
  },

  render: function() {
    var template = this.template(this.model.toJSON());
    $(this.el).html(template);

    this._toggleModal(false);

    $('body').append(this.el);
  },

  unrender: function() {
    this.remove();
    this._toggleModal(true);
    this.trigger('modal:closed');
  },

  _toggleModal: function(show) {
    console.log(show);
    $('#header, #wrapper, #footer').toggle(show);
    $('body').toggleClass('modal-view', !show); 
  },

  close: function() {
    this.trigger('modal:closing');
    return false;
  },

  destroy: function() {
    var self = this;
    this.model.destroy({
      success: function() {
        self.close();
      }
    });
    return false;
  }
});