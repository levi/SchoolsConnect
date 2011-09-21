/*
  Profile Photo View
*/
SC.Views.ProfilePhoto = Backbone.View.extend({
  id: 'profile_photo',

  template: _.template($('#template-profile-photo').html()),

  initialize: function() {
    _.bindAll(this, 'render', 'openModal', 'uploadingImage', 'newImage');
    this.bind('uploading', this.uploadingImage, this);
    this.bind('uploaded', this.newImage, this);
  },

  events: {
    'click .change_image': 'openModal'
  },

  render: function() {
    var self = this;
    
    if (this.model.isEmpty()) return this;
  
    $(this.el).html(this.template(this.model.toJSON()));

    return this;
  },

  openModal: function() {
    this.modal = new SC.Views.PhotoModal({ model: this.model });
  },

  uploadingImage: function() {
    
  },

  newImage: function() {
    
  },

  toggleChange: function(evt) {
    var type = evt.type;

    if (type === 'mouseenter') {
      this.createUploader();
    }

    if (type === 'mouseleave') {
      if (!$(evt.toElement).hasClass('change_image')) this.destroyUploader();
    }
  },

  createUploader: function() {
    var self = this,
        button = self.$('.change_image');

    if (self.uploader && typeof(self.uploader) === 'object') {
      if (self.uploader && self.uploader.hasOwnProperty('destroy')) self.uploader.destory();
    }
    self.uploader = null;

    console.log(self.uploader);

    button.fadeIn(100, function() {
    }); 
  },

  destroyUploader: function() {
    var self = this;
    self.$('.change_image').fadeOut(100, function() {
      self.uploader.destroy();
    }); 
  }
});