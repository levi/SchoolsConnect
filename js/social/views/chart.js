SC.ChartView = Backbone.View.extend({
	id: 'chart_progress',

	template: _.template($('#template-chart').html()),

	initialize: function() {
		_.bindAll(this, 'render', 'getPercentage', 'showProgress', 'showAmountTip');
		this.collection.bind('total:calculated', this.render, this);
		this.model.bind('change', this.render, this);
	},

	render: function() {
		if (this.model.get('goal') === undefined) return this;

	    $(this.el).html(this.template({
	    	goal: this.model.get('goal'),
	    	total: this._formatNumber(Math.ceil(this.collection.totalRaised)),
	    	completed: ((this.getPercentage() === "100%") ? true : false),
	    	notStarted: ((this.getPercentage() === "0%") ? true : false)
	    }));
	    this.showProgress();
	    return this;
	},

	getPercentage: function() {
		var percent = ( this.collection.totalRaised / this.model.get('goal') ) * 100;
		if (percent > 100) percent = 100;
		return percent +'%';
	},

	showProgress: function() {
		var self       = this,
			$progress  = this.$('.progress'),
			percentage = self.getPercentage(),
			hasStarted = (percentage !== "0%");

		$progress.animate({
			width: percentage
		}, 600, function() {
			if ((self.collection.totalRaised < self.model.get('goal')) && hasStarted) {
				self.showAmountTip();
			} else {
				if (!hasStarted) {
					self.$('.not_started').fadeIn('fast');
				} else {
					// show completed state
					$progress.children().fadeIn('fast');									
				}
			}
		});

		return this;
	},

	showAmountTip: function(callback) {
		var $amount = this.$('.amount'),
			offset  = this.$('.progress').width()-52;

		// reset position if about to be displayed
		$amount.css('left', offset);

		$amount.animate({ opacity: 'toggle' }, 300, callback);

		return this;
	},

	_formatNumber: function(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
});