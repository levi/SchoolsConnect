/*
  Profile Info View
*/
SC.ProfileInfoView = Backbone.View.extend({
  className: 'sidebar',

  template: _.template($('#template-profile-info').html()),

  initialize: function() {
    _.bindAll(this, 'render');
    this.model.bind('change', this.render, this);
  },

  render: function() {    
    var profilePhoto = new SC.ProfilePhotoView({ model: this.model });

    $(this.el).html(profilePhoto.render().el)
              .append(this.template(this.model.toJSON()));

    return this;
  }

});