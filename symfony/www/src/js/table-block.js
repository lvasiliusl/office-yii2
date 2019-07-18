jQuery(function ($) {
  var tableBlock = (function (_className) {
    if ($(window).width() < 768) {
      if (!$(_className).hasClass('ready')) {
        $(_className + '  tbody tr').each(function (trIndex, trItem) {
          $(trItem).children('td').each(function (tdIndex, tdItem) {
            if (tdIndex !== 0 && tdIndex !== 1 && tdIndex !== 5) {
              let text = $(tdItem).text()
              let title = $(_className + '  thead tr th:eq(' + tdIndex + ')').text()
              let spanText = createSpan(text, 'table-block-text')
              let spanTitle = createSpan(title, 'table-block-title')
              $(tdItem).html('')
              $(tdItem).append(spanTitle)
              $(tdItem).append(spanText)

            } else 
            if (tdIndex === 0) {
              let text = $(tdItem).text()
              console.log(text)
              let spanNumber = createSpan(text, 'table-block-number')
              $(_className + '  tbody tr:eq(' + trIndex + ') td:eq(1)').prepend(spanNumber)
            } else 
            if (tdIndex === 5) {
              let logBtn = $(tdItem).html()
              $(_className + '  tbody tr:eq(' + trIndex + ') td:eq(1)').append('<span class="log-btn-inside-td">' + logBtn + '</span>')
              console.log(logBtn)
            }
          })
        })
        $('.open-modal').click(function (e) {
          e.preventDefault()
        })
        $(_className).addClass('ready')
      }
      
    } else {
      destroy()
    }

     function createSpan (t, className) {
      let span = $('<span></span>')
      span.addClass(className);
      span.html(t)
      return span
    }
    function destroy () {
      $('.table-block-number').remove()
      $('.table-block-title').remove()
      $('.log-btn-inside-td').remove()
      $('.table-block-text').each(function (i, item) {
        let text = $(item).text()
        $(item).html(text)
      })
      $(_className).removeClass('ready')
      
    }
  })
  tableBlock('.mobile-table-block')

  $(window).resize(function () {
    tableBlock('.mobile-table-block');
  })
})