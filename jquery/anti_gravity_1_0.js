$(document).ready(function() {
  var showposition = 480;
  var animateduration = 1200;

  $(window).scroll(function() {
    if ($(this).scrollTop() > showposition) {
      $('.antiGravity').fadeIn();
    } else {
      $('.antiGravity').fadeOut();
    }
  });

  $('.antiGravity').click(function() {
    $('html, body').animate({scrollTop : 0}, animateduration);
    return false;
  });

  $("a[href='#region-main-shoehorn-shadow']").click(function(e) {
    e.preventDefault();
    var target = $('#region-main-shoehorn-shadow');
    $('html, body').animate({scrollTop : target.offset().top}, animateduration);
    return false;
  });
});
