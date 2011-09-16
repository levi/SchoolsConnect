SC.Views.UpdateModal = SC.Views.Modal.extend({
  template: _.template($('#template-update-modal').html()),

  events: {
    'click .close': 'close',
    'click .destroy': 'destroy'
  },

  initialize: function(options) {
    _.bindAll(this, 'render', 'destroy');

    this.model = options.model || new SC.Models.Update({ id: options.update_id, school_id: options.school_id });
    this.model.bind('change', this.render, this);

    // Fetch if modal is not in the collection.
    if (_.isEmpty(this.model.get('title'))) this.model.fetch();

    SC.Views.Modal.prototype.initialize.call(this);
  },

  render: function() {
    // Add a loading state
    var template = (_.isUndefined(this.model.get('title'))) ? "Loading" : null;
    SC.Views.Modal.prototype.render.call(this, template);
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