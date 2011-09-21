SC.Views.Project = Backbone.View.extend({

  className: 'project',
  tagName: 'li',

  template: _.template($('#template-project').html()),

  events: {
    'click .destroy': 'destroy'
  },

  initialize: function(attr) {
    _.bindAll(this, 'render');
    
    this.school = attr.school;
  },

  render: function() {
    var self = this;
    $(this.el).html(this.template(this.model.toJSON()));

    if (this.school.get('is_admin')) {
      $(this.el).hover(function() {
        self.$('.destroy').show();
      }, function() {
        self.$('.destroy').hide();
      });      
    }

    return this;
  },

  destroy: function() {
    var self = this;
    
    self.model.destroy({
      success: function() {
        $(self.el).remove();
      } 
    });

    return false;
  }

});