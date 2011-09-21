SC.Views.UpdateModal = SC.Views.Modal.extend({

  template: _.template($('#template-update-modal').html()),

  events: {
    'click .close': 'close',
    'click .destroy': 'destroy'
  },

  initialize: function(options) {
    _.bindAll(this, 'render', 'destroy');
    var self = this;
    this.model = options.model || new SC.Models.Update({ id: options.update_id, school_id: options.school_id });
    this.model.bind('change', this.render, this);

    // Fetch modal if not loaded.
    if (_.isEmpty(this.model.get('title')))
      this.model.fetch({
        error: function(resp) {
          self.trigger('modal:error', resp);
        }
      });

    SC.Views.Modal.prototype.initialize.call(this);
  },

  render: function(update, options) {
    console.log('updateModal render');
    options || ( options = {} );
    // Add a loading state
    if (_.isUndefined(this.model.get('title')))
      options.isLoading = true;

    SC.Views.Modal.prototype.render.call(this, null, options);
  },

  destroy: function(evt) {
    evt.preventDefault();
    var self = this;

    if (window.confirm("Are you sure you want to delete this update?")) {
      this.render(this.model, { isLoading: true });

      this.model.destroy({        
        success: function() {
          self.close(evt);
        },
        
        error: function(resp) {
          alert(JSON.stringify(resp));
          self.close(evt);
        }
      });
    }

    return false;
  }

});