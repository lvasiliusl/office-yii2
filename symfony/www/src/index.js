import './../vendor/foundation-sites/js/foundation.core.js'
import './../vendor/foundation-sites/js/foundation.accordion.js'
import './../vendor/foundation-sites/js/foundation.reveal.js'
import './../vendor/foundation-sites/js/foundation.util.box.js'
import './../vendor/foundation-sites/js/foundation.util.triggers.js'
import './../vendor/foundation-sites/js/foundation.util.mediaQuery.js'
import './../vendor/foundation-sites/js/foundation.util.keyboard.js'
import './../vendor/foundation-sites/js/foundation.util.motion.js'

import './../vendor/foundation-datepicker/js/foundation-datepicker.js'

import './../vendor/custom-scroll-bar/jquery.mCustomScrollbar.js'
import './../vendor/custom-scroll-bar/jquery.mousewheel-3.0.6.js'
import './../vendor/tooltipster/js/tooltipster.bundle.min.js'

import 'select2';

import {Sortable} from './js/sortable.js';
import './js/editable-input.js';
import './js/date.format.js';
import './js/calendar.js';
import './js/sort-table.js'
import './js/perfomance-chart.js'
import './js/add-new-day-accordion.js'
import './js/add-new-day-block.js'
import './js/gallery.js'
import './js/add-exercise.js'
import './js/add-set.js'
import './js/responsive-menu.js'
import './js/menu.js'
import './js/responsive-table.js'
import './js/table-block.js'
import './js/table-clients-responsive.js'

// if dev
if (process.env.NODE_ENV === 'dev') {
  console.log(process.env.NODE_ENV)
}

jQuery(function ($) {
  // If safari set input's console.log();border-width 2px
  let isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)
  if (isSafari) {
    $('body').addClass('safari')
  }
  
  
  function initPlugins() {
      $('.day-exercise tbody').each(function() {
          var sortable = window.Sortable.create(this, {
            onSort: function (evt) {
                $(evt.srcElement).trigger('exercise.sort')
            },
          });
      });
      
      $('.accordion').each(function() {
          new Foundation.Accordion($(this), {
              allowAllClosed: true,
              multiExpand: true
          });
      });
      
      $('.accordion')
      .on("down.zf.accordion", function(e,$panel) {
          accordionButtonToggleView()
      })
      .on("up.zf.accordion", function(e,$panel) {
          accordionButtonToggleView()
      });
      $('.reveal').on("open.zf.reveal", function () { // fix scrollTop
          $('.reveal-overlay').scrollTop(0)
      })
      function accordionButtonToggleView () {
          $('.accordion .accordion-item').each(function (i, item) {
              if ($(item).hasClass('is-active') && $(item).find('.accordion-title').find('.button').length > 0) {
                  $(item).find('.accordion-title').find('.button').css({ visibility: 'hidden', opacity: 0 })
              } else {
                  $(item).find('.accordion-title').find('.button').css({ visibility: 'visible', opacity: 1 })
              }
          })
      }
      $('.accordion-title .button.log').click((e) => {
          e.preventDefault()
          return false;
      })
      
      $('.search-btn').click( (e) => {
          $('body').addClass('search-visible')
          if ($('.search-area').hasClass('show-search')){
              $('.search-area').submit()
          } else {
              $('.search-area').addClass('show-search')
              $('.search-input').focus()
          }
          e.preventDefault()
      })
      $('.accordion-title').click((e) => {
          e.preventDefault()
      })
      $('a.info').click((e) => {
          e.preventDefault()
      })
      
      
      $('.datepicker-input').fdatepicker({
          format: 'dd M yyyy',
          disableDblClickSelection: true,
          leftArrow:'<',
          rightArrow:'>',
          closeIcon:'X',
          closeButton: true
      });
      
      $('.custom_select').select2({
          placeholder: 'Select Metrics',
          minimumResultsForSearch: -1,
          width: '200px'
      });
      
      $('td input[type="checkbox"]').on('change', function (e) {
          $('td input[type="checkbox"]').each(function (index, item) {
            if ($(item).prop('checked')) {
              $('.delete_table_row').addClass('visible')
              return false
            } else {
              $('.delete_table_row').removeClass('visible')
            }
          })
      });
      
      $('select[data-href]').on('change', function() {
          let url = $(this).data('href');
          let parameter = $(this).data('parameter');
          let pjax_container = $(this).data('pjax-container');
          
          url = url.replace(parameter, $(this).val());
          window.whr.jQuery().pjax({url: url, container: pjax_container});
      });
      
      
      let modals = [];
      
      $('[data-open]').each(function (e) {

          let id = $(this).data('open');
          
          if( modals.indexOf(id) === -1 ) {
              modals.push(id);
              new Foundation.Reveal($('#'+id));
          }
      });
    
      $('.strength-category-select').each(function() {
         var category_dropdown = $(this);
         var plan_dropdown = $('.strength-plan-select');
         var plans = $(this).data('plans');
         
         category_dropdown.on('change', function() {
             let category_plans = plans[$(this).val()];
             plan_dropdown.empty();
             
             let options = $([]);
             
             $.each(category_plans, function(id, plan_name) {
                 let option = $('<option/>').attr({ value: id }).text( plan_name );
                 options = options.add( option );
             });
             
             plan_dropdown.append(options);
         });
      });
      
      $('.js-submit-form').on('click', function(e) {
            let form = $($(this).data('submit'));
            form.submit();
      });
  }
  
  initPlugins();
  
  window.whr.context().on('whr-pjax:end', function() {
    $('.reveal-overlay').remove();
    initPlugins();
  });

  $('.close_notification').on('click', function (e) {
    e.preventDefault();
    const notificationHeigth = $(".client_notification").outerHeight()
    $(".client_notification").animate({
      marginTop: -notificationHeigth + 'px',
      opacity: 0
    }, 300, function () {
      $(".client_notification").remove()
    })
  })

  $('.show_all_btn').click(function (e) {
    $('.gallery').addClass('show-all');
    $('.gallery li').animate({
      opacity: 1
    }, 500);
    $('.show_all_btn_container').remove();
  })

  // gallery upload
  
  $('.gallery_upload_btn').click(function (e) {
    $('.input_gallery_upload').focus().trigger('click');
    e.preventDefault()
  })

  $('.input_gallery_upload').on('change', function () {
    $('#gallery-photo').submit()
  })

  $('.show_more').click(function (e) {
    $(this).siblings('.exercise_description').addClass('slideDown');
    $(this).remove()
    e.preventDefault()
    return false;
  })

  function setButtonPosition (buttonClassName) {
    let windowHeight = $(window).height()
    const contentHeight  = $('.row.expanded').outerHeight()
    if ($(window).width() < 768 && $(window).width() > 640) {
      if (windowHeight > contentHeight) {
        let buttonHeight = $(buttonClassName).height()
        let calcMargin = windowHeight - buttonHeight - contentHeight + 93
        console.log(buttonHeight)
        $(buttonClassName).css({
          'margin-top': calcMargin
        })
      }
    } else if ($(window).width() < 641) {
      if (windowHeight > contentHeight) {
        let buttonHeight = $(buttonClassName).height()
        let calcMargin = windowHeight - buttonHeight - contentHeight + 39
        console.log(buttonHeight)
        $(buttonClassName).css({
          'margin-top': calcMargin
        })
      }
    }
  }
  
  setButtonPosition('.add-new')
  setButtonPosition('.add-new-plan')
  setButtonPosition('.add-section')
  setButtonPosition('.btn-contact')
  setButtonPosition('.nutrient-balance')
  
  
  var ajaxTables = function() {
      
  }
})

