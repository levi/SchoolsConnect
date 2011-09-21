SC.Collections.Schools = SC.Collections.Paginated.extend({

  _type: 'schools',
  
  model: SC.Models.School,

  /**
    Select a model to be shown in a profile.
   */
  selectSchool: function(school_id) {
    this.selection = this.get(school_id) || new SC.Models.School({ id: school_id });

    if (this.selection.isEmpty()) {
      this.selection.fetch();
    }
  }

});