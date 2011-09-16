/*
  Updates List View
  
  Lists updates with a "more" pagination button to load via requests 
  more updates until there are no more.
*/
SC.Views.UpdateList = Backbone.View.extend({
  id: 'recent_updates',

  template: _.template($('#template-updates-list').html()),

  blankTemplate: _.template($('#template-blank-update').html()),

  events: {
    'click .create-update': 'create',
    'click .more a': 'loadMore'
  },

  initialize: function() {
    _.bindAll(this, 'render', 'addUpdate', 'create', 'loadMore', 'toggleLoading', 'removeMore', 'onLoadingComplete');

    this.collection.bind('add', this.addUpdate, this);
    this.collection.bind('reset', this.render, this);
    this.collection.bind('fetching', this.toggleLoading, this);
    this.collection.bind('fetched', this.moreLoaded, this);
    this.collection.bind('all', this.toggleBlankState, this);
  },

  render: function(options) {
    var $template = $(this.template(this.model.toJSON()));

    if (this.collection.pageInfo().more) {
      $template.find('.more').show();
    }

    $(this.el).html($template);

    this.collection.each(function(model) {
      this.addUpdate(model);
    }, this);

    return this;
  },

  addUpdate: function(model, options) {
    options || ( options = {} );
    var view  = new SC.Views.Update({ model: model }),
        $el   = $(view.render().el),
        $list = this.$('.update-list');
    
    if (this.collection.length > 0) { 
      $el.prependTo($list); 
    } else { 
      $el.appendTo($list);
    }

    if (this.collection.pageInfo().more) {
      this.$('.more');
    }
  },

  create: function(evt) {
    evt.preventDefault();
    this.editor = new SC.Views.UpdateEditorModal({ collection: this.collection });
    return false;
  },

  loadMore: function(evt) {
    this.collection.loadMore();
    return false;
  },

  toggleLoading: function() {
    var $more    = this.$('.more'),
        $link    = $('a', $more),
        $loading = $('.loading', $more);
    
    $link.toggle();
    $loading.toggle();

    return this;
  },

  removeMore: function() {
    this.$('.more').slideUp('fast', function() {
      $(this).remove();
    });
    return this;
  },

  onLoadingComplete: function() {
    this.toggleLoading();
    if (!this.collection.pageInfo().more) this.removeMore();
  },

  toggleBlankState: function() {
    var $listElement    = this.$('.update-list'),
        $blankElement   = this.$('.update-list .none'); 

    if (this.collection.length === 0) {
      $listElement.children().remove();
      $listElement.append(this.blankTemplate);
    } else {
      if ($blankElement.length > 0) $blankElement.remove();
    }
  }
});