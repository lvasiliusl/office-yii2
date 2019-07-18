jQuery(function ($) {
    $('.intensity_select').on('change', function () {
        titleDependsOnSelect(this)
    });
    
    $(document).on('click', '.week-plus', function(e) {
        e.preventDefault();
        
        var new_week_template = $('#week-template').html();
        var week_index = parseInt($('.week-tabs').data('counter'));
        var week_count = $('.week-tabs li').length + 1;
        
        week_index = week_index + 1;
        
        $('<li/>')
            .append('<a/>')
            .find('a').text(week_count)
            .attr('href', '#')
            .attr('data-index', week_index)
            .closest('li')
            .appendTo($('.week-tabs ul'));
        
        var new_week = $(new_week_template.replace(new RegExp("{{week}}","gm"), week_index));
        $('.weeks-wrap').append(new_week);
        
        $('.week-tabs').data('counter', week_index);
        
        if( new_week.hasClass('accordion-week') || new_week.find('.accordion').length ) {
            new Foundation.Accordion(new_week, {
                allowAllClosed: true,
                multiExpand: true
            });
            
            new_week.find('.add-new-day').trigger('click');
        } else {
            new_week.find('.add-new-day-block').trigger('click');
        }
    });
    
    $('.day-exercise tbody').on('exercise.sort', function() {
        $(this).find('tr').each(function(index) {
            $(this).find('input[data-name="order"]').val((index + 1));
        });
    });
    
    $(document).on('click', '.week-tabs li a', function(e) {
        e.preventDefault();
        var week = $('.weeks-wrap .week-wrap[data-week="'+$(this).data('index')+'"]');
        $(this).addClass('current');
        $('.week-tabs li a').not(this).removeClass('current');

        $('.weeks-wrap .week-wrap').not(week).removeClass('active');
        week.addClass('active');
    });
    
    $(document).on('click', '.remove-week', function(e) {
        e.preventDefault();
        var week = $(this).closest('.week-wrap');
        var week_index = week.data('week');
        var week_tab_link = $('.week-tabs li a[data-index="'+week_index+'"]');
        
        if( week.data('id') ) {
            
            week.find('.accordion-item').each(function() {
                if( $(this).data('id') ) {
                  $('input[name="RemoveCardioDay['+$(this).data('id')+']"]').attr('checked', true);
                }
            });
            
            $('input[name="RemoveCardioWeek['+week.data('id')+']"]').attr('checked', true);
        }
        
        var new_week_tab_link = week_tab_link
            .removeClass('current')
            .closest('li')
            .prev()
            .find('a')
            .addClass('current');
        
        week_tab_link.closest('li').remove();
        
        new_week_tab_link.trigger('click');
        
        week.remove();
        
        $('.week-tabs li a').each(function(index, el) {
            $(this).text(index + 1);
        });
    });
    
    $(document).on('click', '.remove-strength-week', function(e) {
        e.preventDefault();
        var week = $(this).closest('.week-wrap');
        var week_index = week.data('week');
        var week_tab_link = $('.week-tabs li a[data-index="'+week_index+'"]');
        
        if( week.data('id') ) {
            
            week.find('.day-block').each(function() {
                if( $(this).data('id') ) {
                  $('input[name="RemoveStrengthDay['+$(this).data('id')+']"]').attr('checked', true);
                }
            });
            
            $('input[name="RemoveStrengthWeek['+week.data('id')+']"]').attr('checked', true);
        }
        
        var new_week_tab_link = week_tab_link
            .removeClass('current')
            .closest('li')
            .prev()
            .find('a')
            .addClass('current');
        
        week_tab_link.closest('li').remove();
        
        new_week_tab_link.trigger('click');
        
        week.remove();
        
        $('.week-tabs li a').each(function(index, el) {
            $(this).text(index + 1);
        });
    });


    $(document).on('click', '.add-new-day', function (e) {
        e.preventDefault();
        const week = $(this).closest('.week-wrap');
        const itemsLength = parseInt(week.data('counter'));
        const nextItemIndex = itemsLength + 1
        const daysLength = week.find('.accordion-item').length
        const new_day_template = $('#day-template').html();
        let day = new_day_template.replace(new RegExp("{{day}}","gm"), nextItemIndex).replace(new RegExp("{{week}}","gm"), week.data('week')).replace(new RegExp("{{day_number}}","gm"), daysLength + 1);
        var accordionItem = $(day);
        
        week.data('counter', nextItemIndex);

        week.find('.accordion').append(accordionItem);
        bindListeners();
        setActive();
    });

    $('.remove_accordion-item').on('click', function (e) {
        e.preventDefault();
        removeAccordionItem(this);
        bindListeners();
        setActive();
    });

  function removeAccordionItem (el) {
      var day = $(el).closest('.accordion-item');
      
      if( day.data('id') ) {
        $('input[name="RemoveCardioDay['+day.data('id')+']"]').attr('checked', true);
      }
      
      day.remove();
      
      $('.accordion').each(function() {
          var accordion = $(this);
          accordion.find('.accordion-item').each(function (index, item) {
            $(item).children('.accordion-title').children('.day-number').text(index + 1);
        });
      });
        
  }

  function titleDependsOnSelect (item) {
    let dayTitle = $(item).val()
    $(item).parents('.accordion-content')
      .siblings('.accordion-title')
      .children('.day-title')
      .text(dayTitle)
  }
  
  function setActive () {
    $('.accordion').each(function() {
        var accordion = $(this);
        accordion.find('.accordion-item').each(function (i, item) {
            if ((i + 1) === accordion.find('.accordion-item').length) {
                $(item).addClass('is-active')
                $(item).children('.accordion-title').attr('aria-expanded', 'true')
                $(item).children('.accordion-title').attr('aria-selected', 'true')
                $(item).children('.accordion-content').css({ 'display': 'block' })
                
            } else {
                $(item).removeClass('is-active');
                $(item).children('.accordion-title').attr('aria-expanded', 'false')
                $(item).children('.accordion-title').attr('aria-selected', 'false')
                $(item).children('.accordion-content').css({ 'display': 'none' })
            }
        });
    });
  }

  function bindListeners () {
      
    $('.accordion').each(function() {
        new Foundation.Accordion($(this), {
            allowAllClosed: true,
            multiExpand: true
        });
    });
    // re-bind listeners
    $('.intensity_select').unbind() // unbind listener on "change"
    $('.intensity_select').on('change', function () { // bind listener on "change" again
      titleDependsOnSelect(this)
    })

    $('.remove_accordion-item').unbind()
    $('.remove_accordion-item').on('click', function (e) {
      removeAccordionItem(this)
      bindListeners()
      setActive()
      e.preventDefault()
    })
  }
});