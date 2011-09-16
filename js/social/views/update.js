/*
  Update View
  
  Represents one single update list item to be used in the Updates List View.
*/
SC.Views.Update = Backbone.View.extend({
  className: 'update',

  template: _.template($('#template-update').html()),

  initialize: function() {
    _.bindAll(this, 'render');
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
    return this;
  },
});
