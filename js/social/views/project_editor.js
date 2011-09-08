SC.Views.ProjectEditor = Backbone.View.extend({
  id: 'project_editor',

  template: _.template($('#template-project-editor').html()),

  events: {
    'click .cancel': 'cancel',
    'click .create': 'create',
    'keydown input.numeric': 'forceNumeric'
  },

  initialize: function() {
    var self = this;
    _.bindAll(self, 'render', 'open', 'show', 'cancel', 'create', 'close');
  
    self.model = self.model || new SC.Models.Project();

    self.collection.bind('add', self.close, self);

    self.render();
  },

  render: function() {
    var self = this;

    $(self.el).append(self.template(self.model.toJSON()));

    $.modal($(self.el), { 
      overClose: true, 
      position: ['80px', ''],
      onOpen: self.open,
      onShow: self.show, 
      onClose: self.close
    });

    return self;
  },

  open: function(dialog) {
    dialog.overlay.fadeIn('fast');
    dialog.container.show();
    dialog.data.fadeIn('fast');
  },

  show: function(dialog) {
    $('input[placeholder], textarea[placeholder]', dialog.data).placeholder();
  },

  cancel: function(evt) {
    evt.preventDefault();
    this.close();
  },

  create: function(evt) {
    evt.preventDefault();
    
    var self   = this,
        name   = self.$('#project_editor_name').val(),
        dollar = self.$('#project_editor_amount_dollar').val() || 0,
        cent   = self.$('#project_editor_amount_cent').val() || "00",
        amount = dollar+'.'+cent;
    
    self.model.save({ name: name, amount: amount }, {
      success: function(model, resp) {
        self.collection.add(model);
      },

      error: function() {
        alert("ERROR! -- "+resp);            
      }
    });
  },

  close: function() {
    $.modal.close();
  },

  forceNumeric: function(e) {
    var $el  = $(e.target),
        id  = $el.attr('id'),
        max = (id === 'project_editor_amount_cent') ? 99 : 999999999;

    if  (e.which === 8 || e.which === 0 || e.which === 9) return  true;      
    if  (e.which < 48 || e.which > 57) return false;

    var dest = e.which - 48,
        result = $el.val() + dest.toString();

    if  (result > max) return  false;
  }
});