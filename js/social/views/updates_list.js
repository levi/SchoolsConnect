/*
  Updates List View
  
  Lists updates with a "more" pagination button to load via requests 
  more updates until there are no more.
*/
SC.UpdatesListView = Backbone.View.extend({
  id: 'recent_updates',

  template: _.template($('#template-updates-list').html()),

  events: {
    'click .create_update': 'create',
    'click .more a': 'loadMore'
  },

  initialize: function() {
    _.bindAll(this, 'render', 'addUpdate', 'create', 'loadMore', 'toggleLoading', 'removeMore', 'onLoadingComplete');

    this.collection.bind('add', this.addupdate, this);
    this.collection.bind('fetching', this.toggleLoading, this);
    this.collection.bind('fetched', this.moreLoaded, this);
  },

  render: function(options) {
    var $template = $(this.template(this.model.toJSON()));

    if (this.collection.pageInfo().more) {
      $template.find('.more').show();
    }

    $(this.el).html($template);

    this.collection.each(function(model) {
      this.addUpdate(model, { animated: false });
    }, this);

    return this;
  },

  addUpdate: function(model, options) {
    options || ( options = {} );
    var view  = new SC.UpdateView({ model: model }),
        $el   = $(view.render().el),
        $list = this.$('.update-list');
    
    if (options.prepend) { 
      $el.hide().prependTo($list).slideDown('fast'); 
    } else { 
      $el.hide().appendTo($list);
      if (options.animated) {
        $el.slideDown('fast');
      } else {
        $el.show(); 
      }
    }

    if (this.collection.pageInfo().more) {
      this.$('.more').slideDown('fast');
    }
  },

  create: function(evt) {
    evt.preventDefault();
    this.updateEditor = new SC.UpdateEditorView({ collection: this.collection });
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
  }
});