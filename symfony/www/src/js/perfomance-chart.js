(function ($) {
    
    var Chart = (function (_data) {
      let countOfLines = _data.series.length
      let max = 0
      let liWidth = $('.ct_area li').outerWidth()
      let liHeight = $('.ct_area li').outerHeight()
      for(let i = 0; i < countOfLines; i++) {
        
        let tempMax = getMaxOfArray(_data.series[i].data)
        max =  tempMax > max ? tempMax : max
      }
      max = Math.ceil((max)/10)*10 // e.g. 74 -> 80, 76 -> 80, 81 -> 90
      $('.yAxis-labels .top').text(max)
      $('.yAxis-labels .center').text(max / 2)

      $('.ct_area li').each(function() {
        $(this).html('')
      })
      $('.ct_chart_wrapper .xAxis-labels').each(function() {
        $(this).html('')
      })
      for(let i = 0; i < countOfLines; i++) {
        _data.series[i].data.forEach(function (item, index) {
          let lineStyle = 'calc('+ getPositionY(item, max, liHeight) + 'px + ' + 0 + 'px)'
          let dot
          let tooltipTitle = item + ' ' + $('.ct_chart_wrapper').attr('data-metrics')
          if (_data.series[i].data[index + 1]) {
             dot = '<span data-item="'+ item +'" class="chart-dot ' + _data.series[i].className + '" style="bottom: '+ getPositionY(item, max, liHeight) +'px" title="'+ tooltipTitle +'"></span>' +
                    '<span data-item="'+ item +'" class="chart-line ' + _data.series[i].className + '" style="bottom: '+ lineStyle +'; transform: rotate('+rotate(_data.series[i].data, index, max)+'deg); width: '+ getWidthOfLine(_data.series[i].data, index, max) +'px;"></span>'
          
          } else {
            dot = '<span data-item="'+ item +'" class="chart-dot ' + _data.series[i].className + '" style="bottom: '+ getPositionY(item, max, liHeight) +'px"  title="'+ tooltipTitle +'"></span>'
          }
          $('.ct_area li:eq('+ index +')').append(dot);
        })
      }
      for(let i = 0; i < _data.labels.length; i++) {
        $('.ct_chart_wrapper .xAxis-labels').append('<span>'+ _data.labels[i] +'</span>')
      }
      $('.chart-dot').tooltipster()
    })

    function getMaxOfArray(numArray) {
      return Math.max.apply(null, numArray);
    }
    function getPositionY (value, max, liHeight) {
      let onePercent = liHeight / max
      return onePercent * value
    }
    function getPercentsOfHeight (value, max, liHeight) {
      let onePercent = liHeight / max
      return onePercent * value
    }
    // _data.series[i].data, index,
    function rotate(data, index, max) {
        let liWidth = $('.ct_area li').outerWidth()
        let liHeight = $('.ct_area li').outerHeight()
        let x1 = 0
        let y1 = getPercentsOfHeight(data[index], max, liHeight)
        let x2 = liWidth
        let y2 = getPercentsOfHeight(data[index + 1], max, liHeight)
        var rad = Math.atan2(y2 - y1, x2-x1);
        var deg = rad / Math.PI * 180;
        deg = y2 < y1 ? (deg * -1) : (deg * -1)
        return deg
    }

    function getWidthOfLine (data, index, max) {
      let liWidth = $('.ct_area li').outerWidth()
      let liHeight = $('.ct_area li').outerHeight()
      let diff = Math.abs(data[index] - data[index + 1])
      diff = getPercentsOfHeight(diff, max, liHeight)
      let c = Math.sqrt((Math.pow(liWidth, 2) + Math.pow(diff, 2)))
      return c
    }
    
    function initChart() {
        var $lineChart = $('.ct_chart_wrapper')
        const CHARTS = $lineChart.data('charts');
        const LABELS = $lineChart.data('labels');
        
        if( !$lineChart.length ) return;
        
        var getSeries = function() {
            let metric = $('.metrics').val();
            let series = [];
            
            series.push(CHARTS[metric]);
            
            $lineChart.attr('data-metrics', CHARTS[metric].xLabel);
            
            return series;
        };
        
        if (CHARTS && LABELS) {
            let labels = LABELS.map((item) => {
                let date = new Date();
                date.setTime(parseInt(item) * 1000);
                return date.format('dd mmm yyyy');
            });

            let data = {
                labels: labels,
                series: getSeries()
            };
            
            new Chart(data);
            
            $(window).resize(function () {
                let data = {
                    labels: labels,
                    series: getSeries()
                };
                
                new Chart(data);
            });

            $('.metrics').change(function (e) {
                let data = {
                    labels: labels,
                    series: getSeries()
                };
                
                new Chart(data);
            })
        }
    }
    
    

    // mobile chart

    $(document).ready(function () {
      $('.ct_area').attr('data-slide', 0)
      mobileChart()
      initChart();
    });
    
    window.whr.context().on('whr-pjax:end', function() {
        if (!$('.ct_area').attr('data-slide')) {
          $('.ct_area').attr('data-slide', 0)
        }
        
        mobileChart();
        initChart();
    });

    $(window).resize(function () {
      if (!$('.ct_area').attr('data-slide')) {
        $('.ct_area').attr('data-slide', 0)
      }
      mobileChart()
    })
    

    function mobileChart () {
      if ($(window).width() <= 768) {
        let _index = parseInt($('.ct_area').attr('data-slide')) || 0 // get current slide
        let marginLeft
        $('.ct_mobile_nav .arrow-left').click(function () {
          if (_index > 0) {
            _index -= 1
            marginLeft = 80 * _index
            $('.ct_area').css({
              'margin-left': '-' + marginLeft + '%'
            })
            $('.xAxis-labels').css({
              'margin-left': '-' + marginLeft + '%'
            })
            setTimeout(function () {
              $('.ct_area').attr('data-slide', _index)
            }, 295)
          } else {
            return false
          }
        })
        $('.ct_mobile_nav .arrow-right').click(function () {
          if (_index < 2) {
            _index += 1
            marginLeft = 80 * _index
            $('.ct_area').attr('data-slide', _index)
            $('.ct_area').css({
              'margin-left': '-' + marginLeft + '%'
            })
            $('.xAxis-labels').css({
              'margin-left': '-' + marginLeft + '%'
            })
          } else {
            return false
          }
        })
      } else {
        $('.ct_area').removeAttr('data-slide')
        $('.ct_area').removeAttr('style')
        $('.xAxis-labels').removeAttr('style')
      }
    }
  


})(jQuery);