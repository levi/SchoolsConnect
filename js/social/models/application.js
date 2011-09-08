/*
	Application Collection for inheritence. 
*/
SC.Models.Application = Backbone.Model.extend({
  url: function() {
    var ret = SC.URL_BASE+'/'+this._type;

    if (!this.isNew()) ret += '/'+this.id; 
    
    return ret;
  }
});