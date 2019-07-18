
jQuery(function ($) {

  let responsiveTable = (function (_className, _columns, _windowWidth, _willOpenIndex, _tableIndex, _fromThead) {
    if ($(_className).length === 0) {
      return false
    }
    let columnHeight
    _willOpenIndex = _willOpenIndex || 0
    
    if ($(window).width() < _windowWidth) {
      if (!$(_className).hasClass('ready')) {
        init()
      } else {
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


    function init () {
      oneColumn()
      hideContent()
      bindListeners()
      $(_className).addClass('ready') // Ready
    }
    function destroy () {
      $(_className + ' tbody tr').each(function (rowIndex, row) {
        $(row).removeClass('active')
        $(row).removeAttr('style')
        $(row).children('td').each(function (columnIndex, column) {
          $(column).removeClass('table-accordion-head')
          $(column).children('.custom-header-title').remove()
          $(column).children('span.table-header').remove()
        })
      })
      $(_className).removeClass('ready')
    }

    // 
    function oneColumn () {
      $(_className + ' tbody tr').each(function (trIndex, row) {
        $(row).children('td').each(function (tdIndex, column) {
          let head = $(_className + ' thead tr th:eq(' + tdIndex + ')').text()
          if (tdIndex !== _columns) {
            let spanElement = createElementSpan(head, 'table-header')
            renderHead({ trIndex, tdIndex }, spanElement)
          } else {
            if (_fromThead !== undefined) {
              let currHead = $(_className + ' tbody tr:eq(' + trIndex + ') td:eq(' + tdIndex + ')').text()
              let th =  $(_className + ' thead tr th:eq(' + _fromThead + ')').text()
              let span = createElementSpan(th + ' ', 'custom-header-title')

              $(_className + ' tbody tr:eq(' + trIndex + ') td:eq(' + tdIndex + ')').prepend(span)
            }
            $(_className + ' tbody tr:eq(' + trIndex + ') td:eq(' + tdIndex + ')').addClass('table-accordion-head')
            
            
          }
          
        })
      })
    }
    function createElementSpan (text, className) {
      let span = $('<span></span>')
      span.addClass(className)
      span.text(text)
      return span
    }
    function renderHead (position, element) {
      $(_className + ' tbody tr:eq(' + position.trIndex + ') td:eq(' + position.tdIndex + ')').prepend(element)
    }

    function hideContent () {
      let columnsHeight = 0
      let firstColumnHeight = 0
      $(_className + ' tbody tr:eq(0) td').each(function (i, item) {
        if (i === 0) {
          firstColumnHeight = parseInt($(item).outerHeight())
        }
        columnsHeight += parseInt($(item).outerHeight())
      })
      
      $(_className).attr('data-first-column-height', firstColumnHeight)
      $(_className).attr('data-columns-height', columnsHeight) // set data attr with height of one column 
      $(_className + ' tbody tr').css({ height: firstColumnHeight }) // hide all
      console.log($(_className).attr('data-columns-height'))
      // Expand the first row for each table
      $(_className).each(function (i, item) {
        let items = $(item).children('tbody').children('tr:eq(0)').children('td').length
        const itemHeight =  parseInt($(_className).attr('data-columns-height'))

        if (_tableIndex !== undefined) {
          if (_tableIndex === i) {
            $(item).children('tbody').children('tr:eq(' + _willOpenIndex + ')').addClass('active')
            $(item).children('tbody').children('tr:eq('+ _willOpenIndex +')').css({ height: itemHeight })
          } else {
            $(item).children('tbody').children('tr:eq(0)').addClass('active')
            $(item).children('tbody').children('tr:eq(0)').css({ height: itemHeight })
          }
        } else {
          $(item).children('tbody').children('tr:eq(0)').addClass('active')
          $(item).children('tbody').children('tr:eq(0)').css({ height: itemHeight })
        }
      })
      
    }
    function bindListeners () {
      $('.table-accordion-head').unbind()
      $(window).unbind('updateTableAccordion')

      $('.table-accordion-head').click(function (e) {
        
      
        const hiddenItemsHeight = parseInt($(_className).attr('data-first-column-height'))
        const items = $(this).siblings().length + 1
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
      // Generate Window event
      // (event, _className, indexOfTr, breakpoint, willOpenIndex (not required), tableIndex (not required), f - index of thead element)
      $(window).on('updateTableAccordion', function (e, c, i, w, o, t, f) { 
        destroy()
        responsiveTable(c, i, w, o, t, f)
      })
    }
  })
  
  // end function
  responsiveTable('.mobile-accordion', 0, 767, 0)
  responsiveTable('.mobile-accordion-custom-header', 0, 767, 0, 0, 0)
  $(window).resize(function () {
    responsiveTable('.mobile-accordion', 0, 767, 0)
    responsiveTable('.mobile-accordion-custom-header', 0, 767, 0, 0, 0)
  })
  
})