SC.Views.ProjectEditorModal = SC.Views.Modal.extend({
  id: 'project_editor',

  template: _.template($('#template-project-editor').html()),

  events: {
    'click .cancel': 'close',
    'submit form': 'create',
    'keydown input.numeric': 'forceNumeric'
  },

  initialize: function() {
    _.bindAll(this, 'render', 'create', 'forceNumeric');
    this.collection.bind('add', this.close, this);
    SC.Views.Modal.prototype.initialize.call(this);
  },

  render: function() {
    var template = this.template();
    $(this.el).html(template);

    this._toggleModal(false);

    $('body').append(this.el);
  },

  create: function(evt) {
    evt.preventDefault();
    
    var self   = this,
        name   = this.$('#project_editor_name').val(),
        dollar = this.$('#project_editor_amount_dollar').val() || 0,
        cent   = this.$('#project_editor_amount_cent').val() || "00",
        amount = dollar+'.'+cent;

    this.model = this.model || new SC.Models.Project();
    
    this.model.save({ name: name, amount: amount }, {
      success: function(model, resp) {
        self.collection.add(model);
      },
      error: function(resp) {
        alert("ERROR! -- "+resp);            
      }
    });
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