SC.UpdateModel = SC.ApplicationModel.extend({
  _type: 'update',

  defaults: { 
    'created_at': new Date(),
    'updated_at': new Date()
  },

  initialize: function() {
    _.bindAll(this, 'formatDates');
    this.bind('change', this.formatDates, this);
    this.change();
  },

  formatDates: function() {
    var monthNames    = ["January","February","March","April","May","June","July","August","September","October","November","December"],
        createdAt     = this.get('created_at'),
        dateCreatedAt = typeof createdAt === 'number' ? new Date(createdAt * 1000) : createdAt,
        currDay       = dateCreatedAt.getDate(),
        currMonth     = dateCreatedAt.getMonth(),
        currYear      = dateCreatedAt.getFullYear();

    this.set({ 
      'created_at': dateCreatedAt,
      'formatted_created_at': monthNames[currMonth] + " " + currDay + ", " + currYear 
    });          

    // TODO: This function is called too many times. There is a binding error.
    console.log(this.get('created_at').toString());

    return this;
  }
});