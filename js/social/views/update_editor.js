/**
  Update Editor View Modal

  Modal for creation/editing of a school blog-like update.
  Includes title and body of the update and will animate the opening
  and closing of a modal including a wysiwyg text-editor. "Saving"
  this view will create a model and add it to the current collection.

  @extends Backbone.View
*/
SC.Views.UpdateEditorModal = SC.Views.Modal.extend({
  id: 'update_editor',

  template: _.template($('#template-update-editor').html()),

  events: {
    'click .cancel': 'close',
    'submit form': 'create'
  },

  initialize: function() {
    _.bindAll(this, 'setup', 'create');
    this.model = this.model || new SC.Models.Update();
    this.collection.bind('add', this.close, this);
    this.model.bind('error', this.validationError, this);
    this.bind('modal:opened', this.setup, this);
    SC.Views.Modal.prototype.initialize.call(this);
  },

  setup: function() {
    this.$('textarea').tinymce({
      script_url: '/wp-content/themes/schoolsconnect/js/libs/tiny_mce/tiny_mce.js',
      theme : "advanced",
      plugins: 'autoresize,autolink,paste',
      theme_advanced_toolbar_location : "top",
      theme_advanced_buttons1: 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,blockquote,|,link,unlink',
      theme_advanced_buttons2: '',
      theme_advanced_buttons3: '',
      theme_advanced_buttons4: '',
      inline_styles: false,
      valid_elements: 'p,a[href],br',
      content_css: '/wp-content/themes/schoolsconnect/style.css'
    });
  },

  validationError: function(model, error) {
    alert("Sorry, the "+error);
  },

  create: function(evt) {
    evt.preventDefault();

    var self    = this,
        title   = this.$('#update_editor_title').val(),
        content = this.$('#update_editor_content').val();
    
    this.model.save({ title: title, content: content }, {
      success: function(model, resp) {
        self.collection.add(model);
      }
    });

    return false;
  }
});