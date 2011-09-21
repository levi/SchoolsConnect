SC.Views.Modal = Backbone.View.extend({

  id: 'modal',
  
  loadingTemplate: _.template($('#template-modal-loading').html()),

  initialize: function() {
    _.bindAll(this, 'render', 'unrender', 'close', '_toggleModal', '_showLoading');
  
    this.bind('modal:closing', this.unrender, this);
    this.render();
  },

  events: {
    'click .close': 'close'
  },

  render: function(template, options) {
    options || (options = {});
    var $modal = $('.modal-overlay');

    // Add a loading state
    if (options.isLoading) {
      template = this.loadingTemplate();
      _.delay(this._showLoading, 300);
    }
    
    $(this.el).html(template || this.template(this.model.toJSON()));

    // Callback method
    if (this.didRenderTemplate) 
      this.didRenderTemplate.apply(this);

    // hide background elements
    this._toggleModal(false);

    // cleanup if there is a current modal
    if ($modal.length) $modal.remove();

    // Reveal modal to client
    $('body').append(this.el);
    this.trigger('modal:opened');
  },

  unrender: function() {
    this.remove();    
    this._toggleModal(true);
    this.trigger('modal:closed');
  },

  close: function(evt) {
    if (evt.preventDefault) evt.preventDefault();
    this.trigger('modal:closing');
    return false;
  },

  _toggleModal: function(show) {
    $('#header, #wrapper, #footer').toggle(show);
    $('body').toggleClass('modal-view', !show); 
  },

  _showLoading: function() {
    this.$('.modal-loading').show();
  }

});