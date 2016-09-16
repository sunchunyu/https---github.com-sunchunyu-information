$(function () {
    GetData(0);
});

function GetData(t) {
    var name = new Array();//用于存放name
    var pv_number = new Array();
    var uv_number = new Array();
    var news_number = new Array();
    var offers_number = new Array();
    var xs_number = new Array();
    var bys_number = new Array();
    var xj_number = new Array();
    var start_time = $(".start_time" + t).val();
    var s=start_time.replace(/-/g,"");
    var end_time = $(".end_time" + t).val();
    var e=end_time.replace(/-/g,"");
   if(s>e){
       bootMessage("warning", "亲，起始日期不能大于终止日期~~~")
   }else{
       $(".loading-container").show();
       $.ajax({
           type: 'POST',
           url: $(".getindex").attr('data'),
           dataType: "json",
           data: {
               "t": t,
               'start_time': start_time,
               'end_time': end_time
           },
           success: function (data) {
               for (var item in data) {
                   name.push(data[item]['time']);
                   pv_number.push(parseInt(data[item]['pv_number']));
                   uv_number.push(parseInt(data[item]['uv_number']));
                   news_number.push(parseInt(data[item]['news_number']));
                   offers_number.push(parseInt(data[item]['offers_number']));
                   xs_number.push(parseInt(data[item]['xs_number']));
                   bys_number.push(parseInt(data[item]['bys_number']));
                   xj_number.push(parseInt(data[item]['xj_number']));
               }
               switch (t) {
                   case 0:
                       showPvUv(name, pv_number, uv_number);
                       showInfo(name, xs_number, bys_number, xj_number);
                       showWebSite(name, news_number, offers_number);
                       break;
                   case 1:
                       showPvUv(name, pv_number, uv_number);
                       break;
                   case 2:
                       showWebSite(name, news_number, offers_number);
                       break;
                   case 3:
                       showInfo(name, xs_number, bys_number, xj_number);
                       break;
               }
               $(".loading-container").hide();
           }
       });
   }

}
function showInfo(name, xs_number, bys_number, xj_number) {
    $('#container1').highcharts({
        chart: {
            type: 'line',
            backgroundColor: '#FCFFC5'
        },
        title: {
            text: null,//"信息采集统计图表",
            y: 20
        },
        xAxis: {//x轴坐标
            categories: name
        },
        yAxis: {//y轴坐标
            title: {
                text: '人数'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '人'
        },
        legend: {
            verticalAlign: 'top',
            align: 'center'
        },
        series: [{//具体数据信息
            name: '新生',
            data: xs_number
        }, {
            name: '毕业生',
            data: bys_number
        }, {
            name: '学籍',
            data: xj_number
        }]
    });
}
function showWebSite(name, news_number, offers_number) {
    $('#container2').highcharts({
        chart: {
            type: 'line',
            backgroundColor: '#FCFFC5'
        },
        title: {
            text: null,//"微网站统计图表",
            y: 20
        },
        xAxis: {//x轴坐标
            categories: name
        },
        yAxis: {//y轴坐标
            title: {
                text: '条数'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '条'
        },
        legend: {
            verticalAlign: 'top',
            align: 'center'
        },
        series: [{//具体数据信息
            name: '资讯',
            data: news_number
        }, {
            name: '招聘',
            data: offers_number
        }]
    });
}
function showPvUv(name, pv_number, uv_number) {
    $('#container').highcharts({
        chart: {
            type: 'line',
            backgroundColor: '#FCFFC5'
        },
        title: {
            text: null,//"PV/UV统计图表",
            y: 20
        },
        xAxis: {//x轴坐标
            categories: name
        },
        yAxis: {//y轴坐标
            title: {
                text: '人数'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '人'
        },
        legend: {
            verticalAlign: 'top',
            align: 'center'
        },
        series: [{//具体数据信息
            name: 'PU',
            data: pv_number
        }, {
            name: 'UV',
            data: uv_number
        }]
    });
}

