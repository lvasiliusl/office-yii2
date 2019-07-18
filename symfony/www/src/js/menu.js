jQuery(function ($){
  // left-side menu
  $('.sandwich_btn').click(function () {
    $('.main-menu').toggleClass('show-menu')
    $(this).toggleClass('close-menu')
    $('body').toggleClass('no-scroll')
  })

  // header menu
  $('.header:not(.mobile-only) .mobile-menu-current-page span, .header:not(.mobile-only) .mobile-menu-current-page i').click(function () {
    $('.header .menu').toggleClass('show-menu');
    $('.mobile-menu-current-page').toggleClass('show-menu');
  })
  $(window).on('click', function (e) {
    let _parent = e.target.parentNode
    if (_parent.parentNode) {
      if (_parent.className.match(/mobile-menu-current-page/i) || _parent.parentNode.className.match(/menu/i)) {
        return
      } else {
        $('.header .menu').removeClass('show-menu')
        $('.mobile-menu-current-page').removeClass('show-menu');
      }
    }
  })
})