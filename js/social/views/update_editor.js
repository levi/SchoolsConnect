/**
  Update Editor View Modal

  Modal for creation/editing of a school blog-like update.
  Includes title and body of the update and will animate the opening
  and closing of a modal including a wysiwyg text-editor. "Saving"
  this view will create a model and add it to the current collection.

  @extends Backbone.View
*/
SC.Views.UpdateEditorModal = SC.Views.Modal.extend({
  id: 'update_editor_modal',

  template: _.template($('#template-update-editor').html()),

  events: {
    'click .cancel': 'cancel',
    'click .publish': 'publish'
  },

  // initialize: function() {
  //   var self = this;
  //   _.bindAll(self, 'render', 'publish', 'cancel', 'open', 'show', 'close');

  //   self.model = self.model || new SC.Models.Update();

  //   self.collection.bind('add', self.close, self);

  //   self.render();
  // },

  // render: function() {
  //   var self = this;
  //   // render template within element
  //   $(self.el).append(self.template(self.model.toJSON()));
  //   // open modal
  //   $.modal($(self.el), { 
  //     overClose: true, 
  //     position: ['80px', ''],
  //     onOpen: self.open,
  //     onShow: self.show, 
  //     onClose: self.close 
  //   });

  //   return self;
  // },

  publish: function(evt) {
    evt.preventDefault();

    var self    = this,
        title   = self.$('#update_editor_title').val(),
        content = self.$('#update_editor_content').val();
    
    self.model.save({ title: title, content: content }, {
      success: function(model, response) {
        self.collection.add(model, { prepend: true });
      },

      error: function(model, response) {
        alert("ERROR! -- "+response);            
      }
    });
  },

  cancel: function(evt) {
    var self = this;
    evt.preventDefault();
    self.close();
  }

  // open: function(dialog) {
  //   dialog.overlay.fadeIn('fast');
  //   dialog.container.show();
  //   dialog.data.fadeIn('fast');
  // },

  // show: function(dialog) {
  //   var self = this;
  //   self.$('textarea').tinymce({
  //     script_url: '/wp-content/themes/schoolsconnect/js/tiny_mce/tiny_mce.js',
  //     theme : "advanced",
  //     theme_advanced_toolbar_location : "top",
  //     theme_advanced_buttons1: 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,blockquote,|,link,unlink',
  //     theme_advanced_buttons2: '',
  //     theme_advanced_buttons3: '',
  //     theme_advanced_buttons4: '',
  //     content_css: '/wp-content/themes/schoolsconnect/style.css'
  //   });
  // },

  // close: function() {
  //   $.modal.close();
  // }
});