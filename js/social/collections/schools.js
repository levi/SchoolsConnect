SC.Collections.Schools = SC.Collections.Paginated.extend({
  _type: 'schools',
  model: SC.Models.School,

  initialize: function(models, options) {
	SC.Collections.Paginated.prototype.initialize.call(this, arguments);

	if (options.total) this.total = options.total;
	if (options.offset) this.offset = options.offset;
  }
});