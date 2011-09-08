SC.Collections.Paginated = SC.Collections.Application.extend({
  initialize: function() {
    _.bindAll(this, 'parse', 'url', 'pageInfo', 'loadMore');
    this.offset = 1;
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
      pages: Math.ceil(this.total / 9),
      more: false
    };

    if (this.offset < info.pages) info.more = this.offset + 1;
    
    return info;
  },

  loadMore: function() {
    if (!this.pageInfo().more) return false;
    console.log(this.offset);
    this.offset += 1;
    return this.fetch({ add: true });
  }
});