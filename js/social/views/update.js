/*
  Update View
  
  Represents one single update list item to be used in the Updates List View.
*/
SC.UpdateView = Backbone.View.extend({
  className: 'update',

  template: _.template($('#template-update').html()),

  events: {
    'click h2 a': 'show'
  },

  initialize: function() {
    _.bindAll(this, 'render');
  },

  render: function() {
    $(this.el).html(this.template(this.model.toJSON()));
    return this;
  },

  show: function() {
    console.log('show!');
  }
});
