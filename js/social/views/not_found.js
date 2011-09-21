SC.Views.NotFound = Backbone.View.extend({
  
  className: 'page',

  template: _.template($('#template-not-found').html()),

  initialize: function() {
    _.bindAll(this, 'render');
  },

  render: function() {
    $(this.el).html(this.template());
    return this;
  }

});