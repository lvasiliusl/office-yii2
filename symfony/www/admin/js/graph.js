$( document ).ready(function() {

    var graph6 = new Rickshaw.Graph( {
        element: document.querySelector("#chart"),
        renderer: 'bar',
        series: [
            {
                data: dbdata_x,

                color: '#22BAA0'
            }, {
                data: dbdata_y,
                color: '#42f4e5'
            } ]
        });

        graph6.render();

        var days = week_days;
        var xAxisQPerDay = new Rickshaw.Graph.Axis.X({
            graph: graph6,
            tickFormat: function(x) {
                return days[x];
            }
        });

        xAxisQPerDay.render();

        var hour_per_days = {
            0:'', 1:'1h', 2:'2h', 3:'3h', 4:'4h', 5:'5h', 6:'6h', 7:'7h', 8:'8h', 9:'9h',
        };
        var yAxis = new Rickshaw.Graph.Axis.Y({
            graph: graph6,
            tickFormat: function(y) {
                return hour_per_days[y];
            }
        });

        yAxis.render();
})
