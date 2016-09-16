$(function () {
    GetData();
    $("text[text-anchor='end']").remove();;
});


function GetData(){
    $(".loading-container").show();
    var name= new Array();//用于存放name
    var un_status= new Array();
    var do_status= new Array();
    var suer_status= new Array();
    var start_time=$("#start_time").val();
    var end_time  =$("#end_time").val();
    var type =$("#type").find("option:selected").val();
    $.ajax({
        type:'POST',
        url:$(".btn-post").attr('data'),
        data:{
            'start_time':start_time,
            'end_time':end_time,
            'type':type
        },
        success:function(data){
            for(var item in data){
                name.push(data[item]['name']);
                un_status.push(parseInt(data[item]['un_status']));
                do_status.push(parseInt(data[item]['do_status']));
                suer_status.push(parseInt(data[item]['suer_status']));
            }
            $('#container').highcharts({
                chart: { type: 'bar' },
                title: { text: '新生信息统计' },
                subtitle: { text: '' },
                xAxis: {
                    categories: name,
                    title:
                    {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population(人)',
                        align: 'high'
                    },
                    labels: { overflow: 'justify' } }, tooltip: { valueSuffix: '人' },
                plotOptions: { bar: { dataLabels: { enabled: true } } },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 100,
                    floating: true, borderWidth: 1,
                    backgroundColor: '#FFFFFF',
                    shadow: true
                },
                credits: { enabled: false },
                series: [
                    { name: '未审核', data: un_status },
                    { name: '已审核', data: do_status },
                    { name: '已确认', data: suer_status }]
               });
            $(".loading-container").hide();
            /*$('#container').highcharts({
                title: {
                    text: '学籍信息统计',
                    x: -20 //center
                },
                subtitle: {//显示不同的副标题
                    text: '',
                    x: -20
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
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{//具体数据信息
                    name: '未审核',
                    data: un_status
                }, {
                    name: '已审核',
                    data: do_status
                }, {
                    name: '已确认',
                    data: suer_status
                }]
            });*/
        }
    });

}
