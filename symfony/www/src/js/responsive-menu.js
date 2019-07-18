jQuery(function ($) {

  let isScroll = false

  function isNeedScrollbar () {
    const logoHeight = $('.logo').outerHeight()
    const windowHeight = $(window).outerHeight()
    const menuContainerHeight = $('.main-navigation').outerHeight()
    const menu = $('.menu.vertical')
    const menuHeight = $(menu[0]).outerHeight() + $(menu[1]).outerHeight()
    const realmenuContainerHeight = getmenuContainerHeight()

    if (windowHeight < (logoHeight + menuHeight)) {
      $('.main-navigation').css({ height: realmenuContainerHeight })
      if (!isScroll) {
        setTimeout(function () {
          $(".main-navigation").mCustomScrollbar({
            theme:"dark-3",
            axis:"y",
            scrollInertia: 200,
            mouseWheel:{ 
              preventDefault: true
            },
            advanced:{
              updateOnContentResize: true
            }
          });
          isScroll = true
        }, 0)
      }
    } else {
      $(".main-navigation").mCustomScrollbar("destroy");
      $('.main-navigation').css({ height: windowHeight - logoHeight })
      isScroll = false
    }
  }
  isNeedScrollbar()
  $(window).resize(isNeedScrollbar)

  function getmenuContainerHeight () {
    const logoHeight = $('.logo').outerHeight()
    const windowHeight = $(window).outerHeight()
    return windowHeight - logoHeight
  }
})