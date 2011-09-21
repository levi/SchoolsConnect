/*
  School info sidebar view. Delegates photot to ProfilePhoto view.
*/
SC.Views.SchoolInfo = Backbone.View.extend({

  className: 'sidebar',

  template: _.template($('#template-profile-info').html()),

  initialize: function() {
    _.bindAll(this, 'render');
    this.model.bind('change', this.render, this);
  },

  render: function() {    
    if (this.model.isEmpty()) return this;

    var profilePhoto = new SC.Views.ProfilePhoto({ model: this.model });

    $(this.el).html(profilePhoto.render().el)
              .append(this.template(this.model.toJSON()));

    return this;
  }

});