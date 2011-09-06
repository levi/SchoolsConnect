/*
	Application Collection for inheritence. 
*/
SC.ApplicationModel = Backbone.Model.extend({
  url: function() {
    var ret = SC.URL_BASE+'/'+this._type;

    if (!this.isNew()) ret += '/'+this.id; 
    
    return ret;
  }
});