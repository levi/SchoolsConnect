SC.ProjectsListView = Backbone.View.extend({
  className: 'projects',

  template: _.template($('#template-projects-list').html()),

  /*
    Blank state theme
  */
  blankTemplate: $('#template-blank-project').html(),

  events: {
    'click .create_project': 'create'
  },

  initialize: function(options) {
    _.bindAll(this, 'render', 'addProject', 'create', 'toggleBlankState');

    this.isAdmin = options.is_admin;

    this.collection.bind('reset', this.render, this);
    this.collection.bind('add', this.addProject, this)
    this.collection.bind('all', this.toggleBlankState, this);
  },

  render: function() {
    $(this.el).html(this.template({ isAdmin: this.isAdmin }));

    if (this.collection.length > 0) {
      this.collection.each(this.addProject);
    } else {
      this.toggleBlankState();
    }

    return this;
  },

  addProject: function(project) {
    var options = {};

    if (project) options.model = project;

    var view = new SC.ProjectView(options);
    this.$('.project_list').append(view.render().el);
  },

  create: function(evt) {
    evt.preventDefault();
    this.editor = new SC.ProjectEditorView({ collection: this.collection });
    return false;
  },

  toggleBlankState: function() {
    var $listElement    = this.$('.project_list'),
        $blankElement   = this.$('.project_list .none'); 

    if (this.collection.length === 0) {
      $listElement.children().remove();
      $listElement.append(this.blankTemplate);
    } else {
      if ($blankElement.length > 0) $blankElement.remove();
    }
  }
});