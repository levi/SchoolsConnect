SC.Collections.Schools = SC.Collections.Paginated.extend({
  _type: 'schools',
  model: SC.Models.School,

  initialize: function(models, options) {
    SC.Collections.Paginated.prototype.initialize.call(this, arguments);

    if (options.total) this.total = options.total;
    if (options.offset) this.offset = options.offset;
  },

  /**
    Select a model to be shown in a profile.

    Load a model if it isn't yet loaded into the collection.
    Afterwards, fetch the model's nested collections either after
    fetching the new model or simply loading it into memory from the
    collection.
   */
  selectSchool: function(school_id) {
    this.selection = this.get(school_id) || new SC.Models.School({ id: school_id });

    if (_.isEmpty(this.selection.get('name'))) {
      this.selection.fetch({
        success: function(model, resp) {
          model.fetchCollections();
        }
      });
    } else {
      this.selection.fetchCollections();
    }
  }
});