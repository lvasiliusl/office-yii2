jQuery(function () {
  var clientTable = (function (_className, _windowWidth) {
    if ($(_className).length === 0) {
      return false
    }

    if ($(window).width() < _windowWidth) {
      if (!$(_className).hasClass('ready')) {
        init()
      } else {
        destroy()
        init()
        hideContent()
        return false
      }
      
    } else {
      if ($(_className).hasClass('ready')) {
        destroy()
      } else {
        return false
      }
    }

    function init() {
      renderAccordion()
      hideContent()
      bindListeners()
      $(_className).addClass('ready');
    }
    function destroy() {
      $('.clients-accordion').remove()
      $('.table-header').remove()
      $(_className + ' tbody tr').each(function (i, tr) {
        $(tr).removeClass('active')
        $(tr).removeAttr('style')
      })
      $(_className).removeClass('ready');
    }
    function renderAccordion() {
      $(_className + ' tbody tr').each(function (trIndex, trItem) {
        $(trItem).children('td').each(function (tdIndex, tdItem) {
          if (tdIndex === 1) {
            let text = $(tdItem).text()
            let span = createSpanElement(text, 'clients-accordion')
            $(_className + ' tbody tr:eq(' + trIndex + ') td:eq(0)').append(span)
            $(_className + ' tbody tr:eq(' + trIndex + ') td:eq(0)').addClass('table-accordion-head');
          } else 
          if (tdIndex > 1) {
            let head = $(_className + ' thead tr th:eq(' + tdIndex + ')').text()
            let spanElement = createSpanElement(head, 'table-header')
            renderHead({ trIndex, tdIndex }, spanElement)
          }
        })
      })
    }
    function createSpanElement(text, className) {
      let span = $('<span></span>')
      span.addClass(className)
      span.text(text)
      return span
    }
    function renderHead (position, element) {
      $(_className + ' tbody tr:eq(' + position.trIndex + ') td:eq(' + position.tdIndex + ')').prepend(element)
    }
    function hideContent () {
      let columnsHeight = 0;
      let firstColumnHeight = 0;
      $(_className + ' tbody tr:eq(0) td').css({ height: '' });
      $(_className + ' tbody tr:eq(0) td').each(function (i, item) {
        if (i === 0) {
          firstColumnHeight = parseInt($(item).outerHeight())
        }
        columnsHeight += parseInt($(item).outerHeight())
      })
      
      $(_className).attr('data-first-column-height', firstColumnHeight)
      $(_className).attr('data-columns-height', columnsHeight) // set data attr with height of one column 
      $(_className + ' tbody tr').css({ height: firstColumnHeight }) // hide all
      // Expand the first row for each table
      $(_className).each(function (i, item) {
        const itemHeight =  parseInt($(_className).attr('data-columns-height'))
          $(item).children('tbody').children('tr:eq(0)').addClass('active')
          $(item).children('tbody').children('tr:eq(0)').css({ height: itemHeight })
      })
      
    }
    function bindListeners () {
      $('.table-accordion-head').off('click');

      $('.table-accordion-head').on('click', function (e) {

        if ($(window).width() >= _windowWidth || $(e.target).is('input[type="checkbox"]')) { return true; }
        
        const hiddenItemsHeight = parseInt($(_className).attr('data-first-column-height'))
        const itemHeight = parseInt($(_className).attr('data-columns-height'))
        let parent = $(this).parents(_className)[0]
        let row = $(this).parent()
        
        $(parent).children('tbody').children('tr').each(function (i, item) {
          $(item).removeClass('active')
          $(item).css({ height: hiddenItemsHeight })
        })
        $(row).addClass('active')
        $(row).css({
          height: itemHeight
        })
      })
    }
  })

  clientTable('.mobile-custom-accordion', 768)
  $(window).resize(function () {
    clientTable('.mobile-custom-accordion', 768)
  })
})