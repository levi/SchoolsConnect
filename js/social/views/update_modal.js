SC.Views.UpdateModal = SC.Views.Modal.extend({
  template: _.template($('#template-update-modal').html()),

  events: {
    'click .close': 'close',
    'click .destroy': 'destroy'
  },

  initialize: function(options) {
    _.bindAll(this, 'destroy');

    this.model = new SC.Models.Update({ id: options.update_id, school_id: options.school_id });
    this.model.bind('change', this.render, this);
    this.model.fetch();

    SC.Views.Modal.prototype.initialize.call(this);
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