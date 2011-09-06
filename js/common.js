$(function() {
  var updates = function() {
    setTimeout(function(){
      $('#updates_bar ul.content li:first').animate( { marginTop: '-68px' }, 800, function() {
        $(this).detach().appendTo('ul.content').css('margin-top', 0);
        updates();
      });
    }, 4000);
  };
  updates();

  $('#iphone_scroll tr[title]').tooltip({ 
    delay: 0,
    position: 'center left',
    offset: [0, -10]
  });

  $pageGrid = $('body.page #page_grid');
  if ($pageGrid.length > 0) {
    $($pageGrid).imagesLoaded(function() {
      $($pageGrid).masonry({
        itemSelector: '.post',
        columnWidth: 220
      });
    });
  }

  $('.meter .progress').each(function() {
    $(this).data('origWidth', $(this).width())
           .width(0)
           .animate({
             width: $(this).data('origWidth')
           }, 600, function() {
            if ($(this).children().length > 0) {
              $(this).children().show('fast');
            } else {
             $(this).siblings('.amount')
              .css('left', $(this).data('origWidth')-52)
              .animate({
               display: 'block',
               opacity: 'toggle'
             }, 300);
            }
           });
  });

  $('#tellafriend').click(function() {
    return sa_tellafriend('http://schoolsconnectclubs.org');
  });
});