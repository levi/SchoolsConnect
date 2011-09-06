/*
  Update List Collection
*/
SC.UpdatesList = SC.ApplicationCollection.extend({
  _type: 'update',

  model: SC.UpdateModel,

  initialize: function(models, options) {
    this.school_id = options.school_id;
  },

  comparator: function(update) {
    return -(update.get('created_at').getTime());
  },

  fetch: function(options) {
    console.log(this.school_id);
    options || (options = {});
    options.data || (options.data = {});
    options.data.school_id = this.school_id;

    this.trigger("fetching");
    Backbone.Collection.prototype.fetch.call(this, options);
  }
});