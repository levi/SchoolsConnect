SC.Models.Update = SC.Models.Application.extend({
  _type: 'update',

  defaults: { 
    'created_at': new Date(),
    'updated_at': new Date(),
    'formatted_created_at': '',
    'formatted_updated_at': ''
  },

  initialize: function(attr) {
    _.bindAll(this, '_formatDate', 'formatDates');

    if (_.isNumber(attr.created_at))
      this.set({'created_at': new Date(attr.created_at)}, { silent: true });

    if (_.isNumber(attr.updated_at))
      this.set({'updated_at': new Date(attr.updated_at)}, { silent: true });

    this.formatDates();

    this.bind('change:created_at', this.formatDates, this);
    this.bind('change:updated_at', this.formatDates, this);
  },

  parse: function(resp) {
    resp.created_at = new Date(resp.created_at);
    resp.updated_at = new Date(resp.updated_at);
    resp.formatted_created_at = SC.Models.Update.prototype._formatDate.call(this, resp.created_at);
    resp.formatted_updated_at = SC.Models.Update.prototype._formatDate.call(this, resp.updated_at);

    return resp;
  },

  validate: function(attrs) {
    if (!attrs.excerpt) {
      if (_.isEmpty(attrs.title))
        return "update must have a title.";

      if (_.isEmpty(attrs.content))
        return "update must have content.";      
    }
  },

  formatDates: function() {
    this.set({
      formatted_created_at: this._formatDate(this.get('created_at')),
      formatted_updated_at: this._formatDate(this.get('updated_at'))
    }, { silent: true });
  },

  _formatDate: function(date) {
    var monthNames    = ["January","February","March","April","May","June","July","August","September","October","November","December"],
        dateObj       = typeof date === 'number' ? new Date(date * 1000) : date,
        currDay       = dateObj.getDate(),
        currMonth     = dateObj.getMonth(),
        currYear      = dateObj.getFullYear();

    return monthNames[currMonth] + " " + currDay + ", " + currYear;
  }
});