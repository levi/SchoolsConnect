var SC = {
	URL_BASE: '/social',

	Models: {},
	Collections: {},
	Views: {},
	Routers: {},
	Cache: new CacheProvider(),
	init: function(schools) {
		this.app = new SC.Routers.Social(schools);
		Backbone.history.start();
	}
};