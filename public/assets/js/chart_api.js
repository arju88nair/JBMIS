function formatDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    date = dd + '-' + mm + '-' + yyyy;
    return date
}

function Last7Days(i) {
    var result = '';
    var d = new Date();
    d.setDate(d.getDate() - i);
    result = formatDate(d);
    return (result);
}


//$(function () {
//    $.getJSON('/home_signups/', function (data) {
//        $("#signups_chart").removeClass('loader1');
//        var data_new = JSON.stringify(data);
//        data_new = data_new.replace(/"/g,"");
//        var data_final = eval(data_new);
//        Highcharts.chart('signups_chart', {
//            chart: {
//                zoomType: 'x'
//            },
//            title: {
//                text: 'Date Wise Signups'
//            },
//            subtitle: {
//                text: document.ontouchstart === undefined ?
//                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
//            },
//            xAxis: {
//                type: 'datetime'
//            },
//            yAxis: {
//                title: {
//                    text: 'Signups rate'
//                }
//            },
//            legend: {
//                enabled: false
//            },
//            plotOptions: {
//                area: {
//                    fillColor: {
//                        linearGradient: {
//                            x1: 0,
//                            y1: 0,
//                            x2: 0,
//                            y2: 1
//                        },
//                        stops: [
//                            [0, Highcharts.getOptions().colors[0]],
//                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
//                        ]
//                    },
//                    marker: {
//                        radius: 2
//                    },
//                    lineWidth: 1,
//                    states: {
//                        hover: {
//                            lineWidth: 1
//                        }
//                    },
//                    threshold: null
//                }
//            },
//
//            series: [{
//                type: 'area',
//                name: 'Signups',
//                data: data_final
//            }]
//        });
//    });
//});

//$(function () {
//    $.getJSON('/home_category/', function(data) {
//        $("#category_chart").removeClass('loader1');
//        var final_data = new Array();
//        data.forEach(function(dat){
//            var data_array = new Array();
//            var data_new = {};
//            data_new['name'] = dat.CATEGORYNAME;
//            data_new['y'] = parseInt(dat.RENTED);
//            final_data.push(data_new);
//        });
//        //console.log(final_data);
//        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
//            return {
//                radialGradient: {
//                    cx: 0.5,
//                    cy: 0.3,
//                    r: 0.7
//                },
//                stops: [
//                    [0, color],
//                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
//                ]
//            };
//        });
//
//        // Build the chart
//        Highcharts.chart('category_chart', {
//            chart: {
//                plotBackgroundColor: null,
//                plotBorderWidth: null,
//                plotShadow: false,
//                type: 'pie'
//            },
//            title: {
//                text: 'Top Rented Categories'
//            },
//            tooltip: {
//                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//            },
//            credits: {
//                enabled: false
//            },
//            plotOptions: {
//                pie: {
//                    allowPointSelect: true,
//                    cursor: 'pointer',
//                    dataLabels: {
//                        enabled: true,
//                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                        style: {
//                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                        },
//                        connectorColor: 'silver'
//                    }
//                }
//            },
//            series: [{
//                name: 'Brands',
//                data: final_data
//            }]
//        });
//    });
//});


$(function () {
    $.getJSON('/home_datewise_signups/', function (data) {
        $("#signups_chart").removeClass('loader1');
        //console.log(data);
        data_date = [];
        data_val_cm = [];
        data_val_lm = [];
        cm_total = lm_total = percentage = percentage_final = 0;
        data.forEach(function (val) {
            if (val.MTH == 'current_month') {
                data_val_cm.push(parseInt(val.SIGN));
                cm_total = cm_total + parseInt(val.SIGN);
                data_date.push(val.DT);
            } else {
                lm_total = lm_total + parseInt(val.SIGN);
                data_val_lm.push(parseInt(val.SIGN));
            }
        });
        percentage = cm_total - lm_total;
        if (percentage < 0) {
            per = Math.round(percentage / lm_total * 100, 0);
        } else {
            per = Math.round(percentage / cm_total * 100, 0);
        }
        Highcharts.chart('signups_chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Date Wise Signups     ' + per + '%'
            },
            xAxis: {
                categories: data_date
            },
            yAxis: {
                title: {
                    text: 'Signups in Number   '
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Current Month, Total - ' + cm_total,
                data: data_val_cm
            }, {
                name: 'Last Month, Total - ' + lm_total,
                data: data_val_lm
            }]
        });
    });
});

$(function () {
    $.getJSON('/home_datewise_renewals/', function (data) {
        $("#renewals_chart").removeClass('loader1');
        //console.log(data);
        data_date = [];
        data_val_cm = [];
        data_val_lm = [];
        cm_total = lm_total = percentage = percentage_final = 0;
        data.forEach(function (val) {
            if (val.MTH == 'current_month') {
                data_val_cm.push(parseInt(val.SIGN));
                cm_total = cm_total + parseInt(val.SIGN);
                data_date.push(val.DT);
            } else {
                lm_total = lm_total + parseInt(val.SIGN);
                data_val_lm.push(parseInt(val.SIGN));
            }
        });
        percentage = cm_total - lm_total;
        if (percentage < 0) {
            per = Math.round(percentage / lm_total * 100, 0);
        } else {
            per = Math.round(percentage / cm_total * 100, 0);
        }
        Highcharts.chart('renewals_chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Date Wise Renewals    ' + per + '%'
            },
            xAxis: {
                categories: data_date
            },
            yAxis: {
                title: {
                    text: 'Renewals in Number    '
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Current Month, Total - ' + cm_total,
                data: data_val_cm
            }, {
                name: 'Last Month, Total - ' + lm_total,
                data: data_val_lm
            }]
        });
    });
});

$(function () {
    $.getJSON('/home_branch_amount/', function (data) {
        $("#amount_chart").removeClass('loader2');
        //console.log(data);
        var final_data = new Array();
        data.forEach(function (dat) {
            var data_array = new Array();
            var data_new = [];
            data_new.push(dat.BRANCHNAME);
            data_new.push(parseInt(dat.FINAL_AMOUNT));
            final_data.push(data_new);
        });
        //console.log(final_data);
        Highcharts.chart('amount_chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Branch Wise Amount Colleted'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            credits: {
                enabled: false
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Collected (Rupees)'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Amount Colleted: <b>{point.y:.1f} Rs</b>'
            },
            series: [{
                name: 'Population',
                data: final_data,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
});

$(function () {
    $.getJSON('/home_datewise_amount/', function (data) {
        $("#amount_date_chart").removeClass('loader2');
        //console.log(data);
        data_date = [];
        data_val_cm = [];
        data_val_lm = [];
        cm_total = lm_total = percentage = percentage_final = 0;
        data.forEach(function (val) {
            if (val.MTH == 'current_month') {
                data_val_cm.push(parseInt(val.COLC));
                cm_total = cm_total + parseInt(val.COLC);
                data_date.push(val.DT);
            } else {
                lm_total = lm_total + parseInt(val.COLC);
                data_val_lm.push(parseInt(val.COLC));
            }
        });
        percentage = cm_total - lm_total;
        if (percentage < 0) {
            per = Math.round(percentage / lm_total * 100, 0);
        } else {
            per = Math.round(percentage / cm_total * 100, 0);
        }
        console.log(percentage_final);
        Highcharts.chart('amount_date_chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Date Wise Collection   ' + per + '%'
            },
            xAxis: {
                categories: data_date
            },
            yAxis: {
                title: {
                    text: 'Amount in Rs'
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Current Month, Total - ' + cm_total,
                data: data_val_cm
            }, {
                name: 'Last Month, Total - ' + lm_total,
                data: data_val_lm
            }]
        });
    });
});

$(function () {
    $.getJSON('/home_dd_data/', function (data) {
        $("#ibt_chart1").removeClass('loader1');
        var final_data = new Array();
        data.forEach(function (dat) {
            if (dat.LOC == "web") {
                var data_array = new Array();
                var data_new = {};
                data_new['name'] = dat.STATE;
                data_array.push(parseInt(dat.DAY1));
                data_array.push(parseInt(dat.DAY2));
                data_array.push(parseInt(dat.DAY3));
                data_array.push(parseInt(dat.DAY4));
                data_array.push(parseInt(dat.DAY5));
                data_array.push(parseInt(dat.DAY6));
                data_array.push(parseInt(dat.DAY7));
                data_new['data'] = data_array;
                data_new['stack'] = 'WEB';
                final_data.push(data_new);
            } else {
                var data_array = new Array();
                var data_new = {};
                data_new['name'] = dat.STATE;
                data_array.push(parseInt(dat.DAY1));
                data_array.push(parseInt(dat.DAY2));
                data_array.push(parseInt(dat.DAY3));
                data_array.push(parseInt(dat.DAY4));
                data_array.push(parseInt(dat.DAY5));
                data_array.push(parseInt(dat.DAY6));
                data_array.push(parseInt(dat.DAY7));
                data_new['data'] = data_array;
                data_new['stack'] = 'BRANCH';
                final_data.push(data_new);
            }
        });
        Highcharts.chart('ibt_chart1', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
                }
            },
            title: {
                text: 'DD Report - Branch Vs Web'
            },
            xAxis: {
                categories: [Last7Days(0), Last7Days(1), Last7Days(2), Last7Days(3), Last7Days(4), Last7Days(5), Last7Days(6)]
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Total Number'
                }
            },
            credits: {
                enabled: false
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
            series: final_data
        });
    });
});

$(function () {
    $.getJSON('/home_ibt_data/', function (data) {
        $("#ibt_chart").removeClass('loader1');
        //console.log(data);
        var final_data = new Array();
        data.forEach(function (dat) {
            if (dat.LOC == "web") {
                var data_array = new Array();
                var data_new = {};
                data_new['name'] = dat.STATE;
                data_array.push(parseInt(dat.DAY1));
                data_array.push(parseInt(dat.DAY2));
                data_array.push(parseInt(dat.DAY3));
                data_array.push(parseInt(dat.DAY4));
                data_array.push(parseInt(dat.DAY5));
                data_array.push(parseInt(dat.DAY6));
                data_array.push(parseInt(dat.DAY7));
                data_new['data'] = data_array;
                data_new['stack'] = 'WEB';
                final_data.push(data_new);
            } else {
                var data_array = new Array();
                var data_new = {};
                data_new['name'] = dat.STATE;
                data_array.push(parseInt(dat.DAY1));
                data_array.push(parseInt(dat.DAY2));
                data_array.push(parseInt(dat.DAY3));
                data_array.push(parseInt(dat.DAY4));
                data_array.push(parseInt(dat.DAY5));
                data_array.push(parseInt(dat.DAY6));
                data_array.push(parseInt(dat.DAY7));
                data_new['data'] = data_array;
                data_new['stack'] = 'BRANCH';
                final_data.push(data_new);
            }
        });
        //console.log(final_data);
        Highcharts.chart('ibt_chart', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
                }
            },
            title: {
                text: 'IBT Report - Branch Vs Web'
            },
            xAxis: {
                categories: [Last7Days(0), Last7Days(1), Last7Days(2), Last7Days(3), Last7Days(4), Last7Days(5), Last7Days(6)]
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Total Number'
                }
            },
            credits: {
                enabled: false
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

            series: final_data
        });
    });
});
$(function () {
    $.getJSON('/avg_circ_mtd_data/', function (data) {
        $("#avg_circ_mtd").removeClass('loader2');
        console.log(data);
        var dates = new Array();
        var avg_calc = new Array();
        data.forEach(function (dat) {
            dates.push(dat['TDATE']);
            avg_calc.push(parseFloat(dat['AVG_CIRCULATION']))

        });

        //console.log(final_data);
        Highcharts.chart('avg_circ_mtd', {

            title: {
                text: 'Average Circulation Per Customer  '
            },

            subtitle: {
                text: 'Month To Day'
            },

            yAxis: {
                title: {
                    text: 'Average Calculation'
                }
            },
            legend: {},

            plotOptions: {
                series: {
                    pointStart: 1
                }
            },

            series: [{
                name: 'Current Month',
                data: avg_calc
            }]

        });
    });
});


$(function () {
    $.getJSON('/branch_chart/', function (data) {
        $("#fn_signups_year_compare_branch").removeClass('loader1');
        console.log(data);
        var datescy = new Array();
        var dately = new Array();
        var cyData = [];
        var lyData = [];
        var clArray = [];
        var lyArray = [];
        data.forEach(function (dat) {
            datescy.push(dat['DT']);
            if (dat['CURRENT_YEAR'] == 'current_year') {
                clArray.push(dat['DT']);
                cyData.push(parseFloat(dat['SIGNUPS']))
            }
            else {
                lyArray.push(dat['DT']);
                lyData.push(parseFloat(dat['SIGNUPS']));

            }

        });

        datescy.forEach(function (date) {
            dately.push(parseInt(date.slice(-2)));
        });

        function onlyUnique(value, index, self) {
            return self.indexOf(value) === index;
        }

        var unique = dately.filter(onlyUnique);
        unique=unique.sort();

        // console.log(cyData);
        // console.log(lyData);
        // console.log(clArray);
        // console.log(lyArray);
        //console.log(final_data);
        Highcharts.chart('fn_signups_year_compare_branch', {

            title: {
                text: 'Signup Comparison'
            },

            subtitle: {
                text: 'Current year to last year'
            },

            yAxis: {
                title: {
                    text: 'Average Calculation'
                }
            },
            legend: {},
            xAxis: {
                min: 1,
                max: unique.slice(-1)[0] ,
                tickInterval: 1
            },

            plotOptions: {
                series: {
                    pointStart: 1
                }
            },

            series: [{
                name: 'Current Year',
                data: cyData
            }, {
                name: 'Last Year',
                data: lyData
            }]
        });
    });
});
$(function () {
    $.getJSON('/fn_renew_year_compare_branch/', function (data) {
        $("#fn_renew_year_compare_branch").removeClass('loader1');
        console.log(data);
        var datescy = new Array();
        var dately = new Array();
        var cyData = [];
        var lyData = [];
        var clArray = [];
        var lyArray = [];
        data.forEach(function (dat) {
            datescy.push(dat['DT']);
            if (dat['CURRENT_YEAR'] == 'current_year') {
                clArray.push(dat['DT']);
                cyData.push(parseFloat(dat['RENEWALS']))
            }
            else {
                lyArray.push(dat['DT']);
                lyData.push(parseFloat(dat['RENEWALS']));

            }

        });

        datescy.forEach(function (date) {
            dately.push(parseInt(date.slice(-2)));
        });

        function onlyUnique(value, index, self) {
            return self.indexOf(value) === index;
        }

        var unique = dately.filter(onlyUnique);
        unique=unique.sort();

        // console.log(cyData);
        // console.log(lyData);
        // console.log(clArray);
        // console.log(lyArray);
        //console.log(final_data);
        Highcharts.chart('fn_renew_year_compare_branch', {

            title: {
                text: 'Renewal Comparison'
            },

            subtitle: {
                text: 'Current year to last year'
            },

            yAxis: {
                title: {
                    text: 'Average Calculation'
                }
            },
            legend: {},
            xAxis: {
                min: 1,
                max: unique.slice(-1)[0] ,
                tickInterval: 1
            },

            plotOptions: {
                series: {
                    pointStart: 1
                }
            },

            series: [{
                name: 'Current Year',
                data: cyData
            }, {
                name: 'Last Year',
                data: lyData
            }]
        });
    });
});

$(function () {
    $.getJSON('/fn_colc_year_compare_branch/', function (data) {
        $("#fn_colc_year_compare_branch").removeClass('loader1');
        console.log(data);
        var datescy = new Array();
        var dately = new Array();
        var cyData = [];
        var lyData = [];
        var clArray = [];
        var lyArray = [];
        data.forEach(function (dat) {
            datescy.push(dat['DT']);
            if (dat['CURRENT_YEAR'] == 'current_year') {
                clArray.push(dat['DT']);
                cyData.push(parseFloat(dat['COLC']))
            }
            else {
                lyArray.push(dat['DT']);
                lyData.push(parseFloat(dat['COLC']));

            }

        });

        datescy.forEach(function (date) {
            dately.push(parseInt(date.slice(-2)));
        });

        function onlyUnique(value, index, self) {
            return self.indexOf(value) === index;
        }

        var unique = dately.filter(onlyUnique);
        unique=unique.sort();

        // console.log(cyData);
        // console.log(lyData);
        // console.log(clArray);
        // console.log(lyArray);
        //console.log(final_data);
        Highcharts.chart('fn_colc_year_compare_branch', {

            title: {
                text: 'Collection Comparison'
            },

            subtitle: {
                text: 'Current year to last year'
            },

            yAxis: {
                title: {
                    text: 'Average Calculation'
                }
            },
            legend: {},
            xAxis: {
                min: 1,
                max: unique.slice(-1)[0] ,
                tickInterval: 1
            },

            plotOptions: {
                series: {
                    pointStart: 1
                }
            },

            series: [{
                name: 'Current Year',
                data: cyData
            }, {
                name: 'Last Year',
                data: lyData
            }]
        });
    });
});