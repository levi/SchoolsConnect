SC.Models.Project = SC.Models.Application.extend({
  _type: 'project',

  defaults: { 
    'created_at': new Date(),
    'updated_at': new Date()
  },

  get: function(attr) {
    var attribute = this.attributes[attr];

    if ((attr === 'created_at' || attr === 'updated_at') && typeof attribute === 'number') {
      this.attributes[attr] = new Date(attribute * 1000);
    }

    return this.attributes[attr];
  }
  
});