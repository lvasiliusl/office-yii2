jQuery(function ($) {

    function initCalendar() {
        
        let jsonData = getData() // get json-object
        let DATA
        if (jsonData) {
            DATA = $.parseJSON(getData())
        } else {
            return false
        }
        
        function getData() { 
            return $('.calendar').attr('data-labels');
        }
        // end DATA obj
        var daysOfWeekFullName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
        var dayArray = [], daysRegExp = [/Sun/gi,/Mon/gi,/Tue/gi,/Wed/gi, /Thu/gi,/Fri/gi,/Sat/gi];
        var date = new Date()
        var today = [
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        ]
        var currentMonth = date.getMonth()
        var currentYear = getYear()
        var allMonths = $('.month');
        var monthCont = $('#months');
        
        render()
        responsiveCalendar()
        
        $(window).resize(responsiveCalendar)
        
        
        function responsiveCalendar () {
            if ($(window).width() < 768) {
                $('#daysofweek th').each(function (i, item) {
                    let text = $(item).text()
                    let croppedText = text.substring(0, 3)
                    $(item).text(croppedText)
                })
            } else {
                $('#daysofweek th').each(function (i, item) {
                    $(item).text(daysOfWeekFullName[i])
                })
            }
        }
        
        function setData (year, month, date) {
            var calendarDate = new Date(year, month, date)
            var labelsHtml = '';
            DATA.forEach(function(el) {
                var elementDate = new Date(el.date)
                
                if (elementDate.getDate() === calendarDate.getDate() && elementDate.getMonth() === calendarDate.getMonth() && elementDate.getFullYear() === calendarDate.getFullYear()) {
                    el.labels.forEach(function (label, i) {
                        switch (label) {
                            case 1: // Strength
                            labelsHtml += '<i class="label-strength"></i>';
                            break;
                            case 2: // Nutrition
                            labelsHtml += '<i class="label-nutrition"></i>';
                            break;
                            case 3: // Cardio
                            labelsHtml += '<i class="label-cardio"></i>';
                            break;
                        }
                    })
                }
            }, this);
            return labelsHtml
        }
        
        function render() {
            for(var i=0; i<allMonths.length; i++){
                allMonths[i].innerHTML += ' ';
            }
            $('#months-cont .month:eq('+ currentMonth +')').addClass('active')
            addElements(currentMonth, 'days');
        }
        
        function setYear () {
            setTimeout(function () {
                $('.year').text(currentYear)
            }, 100)
        }
        
        function getAllDays(month, year) {
            var date = new Date(year, month, 1);
            var days = [];
            while (date.getMonth() === month) {
                var dayToPush = new Date(date);
                days.push(dayToPush);
                date.setDate(date.getDate() + 1);
            }
            return days;
        }
        
        function getYear() {
            var d = new Date();
            var curYear = d.getFullYear();
            return curYear;
        }
        
        function isToday(year, month, day) {
            if (today[0] === year && today[1] === month && today[2] === day) {
                return true
            } else {
                return false
            }
        }
        
        function addElements (query, id) {
            $('#' + id).html('')
            $('.calendar').addClass('ready'); 
            setYear()
            var allDays = getAllDays((query), currentYear);
            var counter = 0;
            var daysHtml = '';
            var cellsCount;
            
            for(var i = 0; i < allDays.length; i++){
                allDays[i] = allDays[i].toString();
            }
            for(var i = 0; i < daysRegExp.length; i++) {
                
                if(allDays[0].match(daysRegExp[i])){
                    break
                } else {
                    counter += 1;
                }
            }
            for(var i=0; i < counter; i++){
                allDays.unshift(" ");
            }
            
            if (allDays.length <= 28) {
                cellsCount = 28
            } else if (allDays.length <= 35) {
                cellsCount = 35
            } else {
                cellsCount = 42
            }
            for(var i = 0; i < cellsCount; i++){
                var getLabels = ''
                var calcDay = i - counter + 1
                
                if (i >= counter) {
                    getLabels = setData(currentYear, currentMonth, calcDay)
                }
                if(allDays[i] !== ' ' && allDays[i]){
                    var dayOTW = allDays[i].split(' ')[2];
                    if(dayOTW.charAt(0)==="0"){
                        allDays[i] = dayOTW.replace(/0/gi, '');
                    } else {
                        allDays[i] = dayOTW;
                    }
                }
                if (!allDays[i]) {
                    allDays.push(' ')
                }
                if(i === 0 || i === 7 || i === 14 || i === 21 || i === 28 || i === 35){
                    daysHtml += `<tr><td class="day"><span class="${isToday(currentYear, currentMonth, calcDay) ? ' today' : ''}">${allDays[i]}</span>
                    ${allDays[i] !== ' ' ? getLabels : ''}
                    </td>`
                } else if(i === 6 || i === 13 || i === 20 || i === 27 || i === 34 || i === 42){
                    daysHtml += `<td class="day"><span class="${isToday(currentYear, currentMonth, calcDay) ? ' today' : ''}">${allDays[i]}</span>
                    ${allDays[i] !== ' ' ? getLabels : ''}
                    </td></tr>`
                } else {
                    daysHtml += `<td class="day"><span class="${isToday(currentYear, currentMonth, calcDay) ? ' today' : ''}">${allDays[i]}</span>
                    ${allDays[i] !== ' ' ? getLabels : ''}
                    </td>`
                }
            };
            
            $('#' + id).html(daysHtml);
            
            let days = $('#' + id).find('.day');
            days.on('click', function(e) {
                days.removeClass('active');
                $(this).addClass('active');
            });
        }
        function whichChild(elem){
            var  i= 0;
            while ((elem = elem.previousSibling) != null) ++i;
            return i;
        }
        
        
        $('#prevMt').click(function () {
            monthToggle('prevMt')
        })
        $('#nextMt').click(function () {
            monthToggle('nextMt')
        })
        
        function monthToggle (ID) {
            var currentActive = document.querySelector('#months .month.active');
            var activeIndex = 0;
            for(var i=0; i < allMonths.length; i++){
                if(allMonths[i].innerHTML === currentActive.innerHTML){
                    activeIndex = i;
                }
            }
            
            if(ID ==='nextMt') {
                if(activeIndex<11) {
                    currentActive.className = 'month';
                    allMonths[activeIndex+1].className += ' active';
                    currentMonth++
                    addElements((activeIndex+1), 'days');
                } else {
                    currentActive.className = 'month';
                    allMonths[0].className += ' active';
                    currentYear++
                    currentMonth = 0
                    addElements(0, 'days');        
                }
            } else if(ID ==='prevMt') {
                if(activeIndex>0) {
                    currentActive.className = 'month';
                    allMonths[activeIndex-1].className += ' active';
                    currentMonth--
                    addElements((activeIndex-1), 'days');
                } else {
                    currentActive.className = 'month';
                    allMonths[11].className += ' active';
                    currentYear--
                    currentMonth = 11
                    addElements(11, 'days');
                }
            }
        }
    }
    
    initCalendar();
    
    window.whr.context().on('whr-pjax:end', function() {
        initCalendar();
    });
})