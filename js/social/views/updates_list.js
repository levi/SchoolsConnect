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

  initialize: function(options) {
    _.bindAll(this, 'render', 'addUpdate', 'create', 'loadMore');
    
    this.isAdmin = options.is_admin;

    this.collection.bind('reset', this.render, this);
    this.collection.bind('add', this.addUpdate, this);
    this.collection.bind('fetching', this.toggleLoading, this);
  },

  render: function(options) {
    $(this.el).html(this.template({ isAdmin: this.isAdmin }));

    this.collection.each(function(model) {
      this.addUpdate(model, self.collection, { nonAnimated: true });
    }, this);

    return this;
  },

  addUpdate: function(model, collection, options) {
    options || ( options = {} );
    var view  = new SC.UpdateView({ model: model }),
        el    = view.render().el,
        $list = this.$('.update-list');
    
    if (options.prepend) { 
      $(el).hide().prependTo($list).slideDown('fast'); 
    } else { 
      $(el).hide().appendTo($list);
      if (options.nonAnimated) {
        $(el).show(); 
      } else {
        $(el).slideDown('fast');
      }
    }
  },

  create: function(evt) {
    evt.preventDefault();
    this.updateEditor = new SC.UpdateEditorView({ collection: this.collection });
    return false;
  },

  loadMore: function(evt) {
    evt.preventDefault();
    var self = this,
        length = this.collection.length;

    self.collection.fetch({ 
      data: { offset: length },
      add: true, 
      success: function(collection) {
        self.toggleLoading();
        if (collection.length === length) self.removeMore();
      }, 
      error: function(collection, resp) {
        console.log(resp);
      } 
    });
  },

  toggleLoading: function() {
    var self     = this,
        $more    = self.$('.more'),
        $link    = $('a', $more),
        $loading = $('.loading', $more);
    
    $link.toggle();
    $loading.toggle();

    return self;
  },

  removeMore: function() {
    var self = this;
    self.$('.more').slideUp('fast', function() {
      $(this).remove();
    });
    return self;
  }

});