/*
	Application Collection for inheritence. 
*/
SC.Collections.Application = Backbone.Collection.extend({
  baseUrl: function() {
    return SC.URL_BASE+"/"+this._type;
  },

  url: function() {
    return this.baseUrl();
  }
});