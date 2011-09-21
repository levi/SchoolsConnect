/*
  Collection for the profile's update list.
*/
SC.Collections.Updates = SC.Collections.Paginated.extend({

	_type: 'updates',
	
	_perPage: 3,

	model: SC.Models.Update,

	parse: function(resp) {
		this.total = resp.total;
		this.offset = resp.offset;

		resp.models = _.map(resp.models, function(model) {
			var ret = SC.Models.Update.prototype.parse.call(this, model);
			// Non attribute flag to definie whether to append/prepend.
			ret.wasFetched = true;
			return ret;
		}, this);
		return resp.models;
	},

	comparator: function(update) {
		return update.get('created_at').getTime();
	}

});