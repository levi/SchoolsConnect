/*
  Profile Photo View
*/
SC.Views.ProfilePhoto = Backbone.View.extend({
  id: 'profile_photo',

  template: _.template($('#template-profile-photo').html()),

  initialize: function() {
    _.bindAll(this, 'render', 'uploadingImage', 'newImage');
    this.bind('uploading', this.uploadingImage, this);
    this.bind('uploaded', this.newImage, this);
  },

  render: function() {
    var self = this;
  
    $(this.el).html(this.template(this.model.toJSON()));

    // self.uploader = new AjaxUpload(self.$('.change_image'), {
    //     action: '/social/photo',
    //     onSubmit: function(file , ext){
    //       if ( ext && /^(jpg|png|jpeg|gif)$/.test(ext) ){
    //         self.trigger('uploading');
    //       } else {                
    //         console.log('Error: only images are allowed');
    //         return false;               
    //       }      
    //     },
    //     onComplete: function(file, resp){
    //       self.trigger('uploaded');
    //       console.log(file, resp);
    //     }       
    //   });

    return this;
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