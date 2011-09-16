/*
  Update List Collection
*/
SC.Collections.Updates = SC.Collections.Paginated.extend({
	_type: 'updates',
	model: SC.Models.Update,

	parse: function(resp) {
		this.total = resp.total;
		this.offset = resp.offset;

		resp.models = _.map(resp.models, function(model) {
			return SC.Models.Update.prototype.parse.call(this, model);
		}, this);
		return resp.models;
	},

	comparator: function(update) {
		return update.get('created_at').getTime();
	}
});