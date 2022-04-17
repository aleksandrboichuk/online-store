if ($.fn.slider) {
  $("#sl2").slider();
}
var RGBChange = function () {
  $("#RGB").css(
    "background",
    "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
  );
};
//================================== Pre-loader =====================================

$(window).on('load', function () {
  $('body').addClass('loaded_hiding');
  window.setTimeout(function () {
    $('body').addClass('loaded');
    $('body').removeClass('loaded_hiding');
  }, 500);
});

$(document).ready(function () {

  $('.alert-btn-close').click(function () {
    $(this).parent().parent().removeClass('alert-active');
  });
  //=========================== Selecting chose category group =======================
    var url = location.pathname.split('/');
   if(url.length > 2) {
     if (url[2] == "women") {
       $('.mainmenu').find('a[class="women"]').addClass("active-nav-item");
     } else if (url[2] == "men") {
       $('.mainmenu').find('a[class="men"]').addClass("active-nav-item");
     } else if (url[2] == "girls" || url[4] == "boys"){
       $('.mainmenu').find('a[class="kids"]').addClass("active-nav-item");
    }
  }else if(url.length == 2){
    if(url[1] == 'contact') {
      $('.mainmenu').find('a[class="contact"]').addClass("active-nav-item");
    }
   }

  //=========================== fixed header with scroll ===============================

  $(window).scroll(function() {
    if ($(this).scrollTop() > 77){
      $('.header-bottom').addClass("fixed-header");
    }
    else{
      $('.header-bottom').removeClass("fixed-header");
    }
  });


  //=================================== Scroll =========================================
  $(function () {
    $.scrollUp({
      scrollName: "scrollUp",
      scrollDistance: 300,
      scrollFrom: "top",
      scrollSpeed: 300,
      easingType: "linear",
      animation: "fade",
      animationSpeed: 200,
      scrollTrigger: false,
      scrollText: '<i class="fa fa-angle-up"></i>',
      scrollTitle: false,
      scrollImg: false,
      activeOverlay: false,
      zIndex: 2147483647,
    });
  });



});



