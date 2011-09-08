/*
  Update List Collection
*/
SC.UpdatesList = SC.PaginatedCollection.extend({
  _type: 'updates',
  model: SC.UpdateModel
});