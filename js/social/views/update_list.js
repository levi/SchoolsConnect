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
    _.bindAll(this, 'render', 'addUpdate', 'create', 'loadMore', 'toggleLoading', 'toggleMore', 'onLoadingComplete');

    this.collection = this.model.updates;

    this.collection.bind('reset', this.render, this);
    this.collection.bind('add', this.addUpdate, this);
    this.collection.bind('fetching', this.toggleLoading, this);
    this.collection.bind('fetched', this.onLoadingComplete, this);
    this.collection.bind('all', this.toggleBlankState, this);
  },

  render: function(options) {
    if (this.model.isEmpty()) return this;
    
    $(this.el).html(this.template(this.model.toJSON()));

    if (this.collection.pageInfo().more) 
      this.toggleMore(true);
  
    if (this.collection.length > 0)
      this.collection.each(this.addUpdate);
    else
      this.toggleBlankState();

    return this;
  },

  addUpdate: function(model, options) {
    options || ( options = {} );

    var view  = new SC.Views.Update({ model: model, collection: this.collection }),
        $el   = $(view.render().el),
        $list = this.$('.update-list');
    
    if (model.get('wasFetched')) 
      $el.appendTo($list);
    else
      $el.prependTo($list);

    if (this.collection.pageInfo().more)
      this.toggleMore(true);
  },

  create: function(evt) {
    evt.preventDefault();
    this.editor = new SC.Views.UpdateEditorModal({ collection: this.collection });
    return false;
  },

  loadMore: function(evt) {
    evt.preventDefault();
    this.collection.loadMore();
    return false;
  },

  toggleLoading: function(show) {
    var $more    = this.$('.more'),
        $link    = $('a', $more),
        $loading = $('.loading', $more);

    if (show === undefined) show = true;
    
    $link.toggle(!show);
    $loading.toggle(show);

    return this;
  },
  
  toggleMore: function(show) {
    var $more = this.$('.more');
    if (show) {
      $more.css('display', 'block');
    } else {
      $more.hide();
    }
  },

  onLoadingComplete: function() {
    this.toggleLoading(false);
    if (!this.collection.pageInfo().more) this.toggleMore(false);
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