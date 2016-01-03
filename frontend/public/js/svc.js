
// Build the chart Pie Chart boys vs Girl
    $('.svc-bvg-piechart').highcharts({
        chart: {
            type: 'pie',
        },
        title: {
            text: 'gMarks contributions'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Gender Share',
            data: [
                ['Male', 45.0],
                ['Female', 55.0]
            ]
        }]
    });

//Column chart for the Subject wise distribution
    $('.svc-subject-column').highcharts({

        chart: {
            type: 'column',
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Total Subject Distribution, grouped by point'
        },

        xAxis: {
            categories: ['Management', 'HR', 'Digital Marketing', 'Programming', 'Communating']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });



    //India Map 

      var data = [
        {
            "hc-key": "in-an",
            "value": 0
        },
        {
            "hc-key": "in-wb",
            "value": 1
        },
        {
            "hc-key": "in-ld",
            "value": 2
        },
        {
            "hc-key": "in-5390",
            "value": 3
        },
        {
            "hc-key": "in-py",
            "value": 4
        },
        {
            "hc-key": "in-3464",
            "value": 5
        },
        {
            "hc-key": "in-mz",
            "value": 6
        },
        {
            "hc-key": "in-as",
            "value": 7
        },
        {
            "hc-key": "in-pb",
            "value": 8
        },
        {
            "hc-key": "in-ga",
            "value": 9
        },
        {
            "hc-key": "in-2984",
            "value": 10
        },
        {
            "hc-key": "in-jk",
            "value": 11
        },
        {
            "hc-key": "in-hr",
            "value": 12
        },
        {
            "hc-key": "in-nl",
            "value": 13
        },
        {
            "hc-key": "in-mn",
            "value": 14
        },
        {
            "hc-key": "in-tr",
            "value": 15
        },
        {
            "hc-key": "in-mp",
            "value": 16
        },
        {
            "hc-key": "in-ct",
            "value": 17
        },
        {
            "hc-key": "in-ar",
            "value": 18
        },
        {
            "hc-key": "in-ml",
            "value": 19
        },
        {
            "hc-key": "in-kl",
            "value": 20
        },
        {
            "hc-key": "in-tn",
            "value": 21
        },
        {
            "hc-key": "in-ap",
            "value": 22
        },
        {
            "hc-key": "in-ka",
            "value": 23
        },
        {
            "hc-key": "in-mh",
            "value": 24
        },
        {
            "hc-key": "in-or",
            "value": 25
        },
        {
            "hc-key": "in-dn",
            "value": 26
        },
        {
            "hc-key": "in-dl",
            "value": 27
        },
        {
            "hc-key": "in-hp",
            "value": 28
        },
        {
            "hc-key": "in-rj",
            "value": 29
        },
        {
            "hc-key": "in-up",
            "value": 30
        },
        {
            "hc-key": "in-ut",
            "value": 31
        },
        {
            "hc-key": "in-jh",
            "value": 32
        },
        {
            "hc-key": "in-ch",
            "value": 33
        },
        {
            "hc-key": "in-br",
            "value": 34
        },
        {
            "hc-key": "in-sk",
            "value": 35
        }
    ];

    // Initiate the chart


    $('#svc-india-map').highcharts('Map', {

        title : {
            text : 'Highmaps basic demo'
        },

        subtitle : {
            text : 'Source map: <a href="https://code.highcharts.com/mapdata/countries/in/custom/in-all-disputed.js">India with disputed territories</a>'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        colorAxis: {
            min: 0
        },

        series : [{
            data : data,
            mapData: Highcharts.maps["countries/in/custom/in-all-disputed"],
            joinBy: 'hc-key',
            name: 'Random data',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });


//state Charts Top 1
$('#svc-india-statentop1').highcharts({

        chart: {
            type: 'column',
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Rajasthan'
        },

        xAxis: {
            categories: ['Management', 'HR', 'Digital Marketing', 'Programming', 'Communating']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });


//state Charts Top 2
$('#svc-india-statentop2').highcharts({

        chart: {
            type: 'column',
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Delhi'
        },

        xAxis: {
            categories: ['Management', 'HR', 'Digital Marketing', 'Programming', 'Communating']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });

//state Charts Top 3
$('#svc-india-statentop3').highcharts({

        chart: {
            type: 'column',
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Ahmedabad'
        },

        xAxis: {
            categories: ['Management', 'HR', 'Digital Marketing', 'Programming', 'Communating']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });


//state Charts Top 4
$('#svc-india-statentop4').highcharts({

        chart: {
            type: 'column',
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Keral'
        },

        xAxis: {
            categories: ['Management', 'HR', 'Digital Marketing', 'Programming', 'Communating']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of fruits'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2],
            stack: 'male'
        }, {
            name: 'Joe',
            data: [3, 4, 4, 2, 5],
            stack: 'male'
        }, {
            name: 'Jane',
            data: [2, 5, 6, 2, 1],
            stack: 'female'
        }, {
            name: 'Janet',
            data: [3, 0, 4, 4, 3],
            stack: 'female'
        }]
    });

//--------------------//Topers filter format//-------------------------

    $('a[href="#svc-filter"]').on('click', function(event) {
            event.preventDefault();
            $('#svc-filter').addClass('open');
            $('#svc-filter > form > input[type="filter"]').focus();
        });
        
        $('#svc-filter, #svc-filter button.close').on('click keyup', function(event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
    });
        

    //Do not include! This prevents the form from submitting for DEMO purposes only!
    $('#svc-toper-filter-form').submit(function(event) {
        event.preventDefault();
        return false;
    });