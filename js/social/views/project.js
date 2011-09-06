SC.ProjectView = Backbone.View.extend({
  className: 'project',

  template: _.template($('#template-project').html()),

  events: {
  	'click .destroy': 'destroy'
  },

  initialize: function() {
    _.bindAll(this, 'render');
  },

  render: function() {
  	var self = this;
    $(this.el).html(this.template(this.model.toJSON()));

    $(this.el).hover(function() {
    	self.$('.destroy').show();
    }, function() {
    	self.$('.destroy').hide();    	
    });

    return this;
  },

  destroy: function() {
  	var self = this;
  	
  	self.model.destroy({ success: function() {
	  	$(self.el).remove();
  	} });

  	return false;
  }

});