SC.Collections.Paginated = SC.Collections.Application.extend({
  
  offset: 1,
  
  total: 0,
  
  initialize: function(models, options) {
    _.bindAll(this, 'parse', 'url', 'pageInfo', 'loadMore');
    this._perPage = this._perPage || 12;

    this.offset = options.offset || this.offset;
    this.total = options.total || this.total;
  },

  parse: function(resp) {
    this.total = resp.total;
    this.offset = resp.offset;
    return resp.models;
  },

  url: function() {
    return this.baseUrl()+'?offset='+this.offset;
  },

  pageInfo: function() {
    var info = {
      total: this.total,
      offset: this.offset,
      pages: Math.ceil(this.total / this._perPage),
      more: false
    };

    if (this.offset < info.pages) info.more = this.offset + 1;

    return info;
  },

  loadMore: function() {
    if (!this.pageInfo().more) return false;
    this.offset += 1;
    return this.fetch({ add: true });
  },

  fetch: function(options) {
    this.trigger('fetching');
    options || (options = {});
    var collection = this;
    var success = options.success;
    options.success = function(resp, status, xhr) {
      collection.trigger('fetched');
      if (success) success(collection, resp);
    };
    Backbone.Collection.prototype.fetch.call(this, options);
  }
});