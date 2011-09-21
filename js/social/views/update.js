/*
  Update View
  
  Represents one single update list item to be used in the Updates List View.
*/
SC.Views.Update = Backbone.View.extend({
  className: 'update',

  template: _.template($('#template-update').html()),

  events: {
    'click h2 a': 'select'
  },

  initialize: function() {
    _.bindAll(this, 'render');
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
    return this;
  },

  select: function() {
    this.collection.trigger('select', this.model);
  }
});
