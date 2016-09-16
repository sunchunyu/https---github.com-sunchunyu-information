$(function () {
    $('.edit-city').val($("#city_id").attr('data'));
    
    $('.edit-pro').val(parseInt($("#province-id").text()));

    $(".btn-save").on("click", function () {
        var make = $('#make').attr('data');
        if($('.areaName').val()!=""){
        if (make == 0) {
            //编辑省的代码段
            var url = $('#edit-url').attr('data');
            var data ={
                'make' :make,
                'id' :$('.id').val(),
                'name' :$('.areaName').val()
            }
            $.post(url, data, function (data) {
                if ((data.code) == 0) {
                    bootMessage("success", data.message);
                } else {
                    bootMessage("danger", data.message);
                }
            });

        } else if (make == 1) {
            //编辑市的代码段
            if($('.edit-pro').val()==0){
                bootMessage("danger",'操作失败');
                return;
            }
            var url = $('#edit-url').attr('data');
            var data ={
                'make' :make,
                'id' :$('.id').val(),
                'pro_id':$('.edit-pro').val(),
                'name' :$('.areaName').val()
            };

            $.post(url, data, function (data) {
                    console.log(123);
                if ((data.code) == 0) {
                    bootMessage("success", data.message);
                } else {
                    bootMessage("danger", data.message);
                }
            });


        } else if (make == 2) {
            //编辑区的代码段
            if($('.edit-city').val()==0){
                bootMessage("danger",'操作失败');
                return;
            }
            var url = $('#edit-url').attr('data');
            var data ={
                'make' :make,
                'id' :$('.id').val(),
                'city_id':$('.edit-city').val(),
                'name' :$('.areaName').val()
            };

            $.post(url, data, function (data) {
                console.log(123);
                if ((data.code) == 0) {
                    bootMessage("success", data.message);
                } else {
                    bootMessage("danger", data.message);
                }
            });

        } else {
            //添加
            var pro_id = $('#pro-list').val();
            var city_id = $('#city-list').val();
            var area_val = $('.areaName').val();
            var url = $('#save-rul').attr('data');
            if(area_val&&pro_id==0&&city_id==0){
                //表明添加的是一个省
                var data = {
                    'type':0,
                    'name':area_val
                };
                $.post(url, data, function (data) {

                    if ((data.code) == 0) {

                        bootMessage("success", data.message);
                    } else {
                        bootMessage("danger", data.message);
                    }
                });


            }else if(area_val&&city_id==0&&(pro_id != 0)){
                //表明添加的是一个市
                console.log("市");
                var data = {
                    'type':1,
                    'name':area_val,
                    "pro_id": pro_id,
                };
                $.post(url, data, function (data) {
                    if ((data.code) == 0) {
                        bootMessage("success", data.message);
                    } else {
                        bootMessage("danger", data.message);
                    }
                });
            }else if((pro_id != 0) && (city_id != 0) && area_val){
                //表明添加的是一个区
                console.log("区");
                var data = {
                    'type':2,
                    'name':area_val,
                    "pro_id": pro_id,
                    "city_id": city_id,
                };
                $.post(url, data, function (data) {
                    if ((data.code) == 0) {
                        bootMessage("success", data.message);
                    } else {
                        bootMessage("danger", data.message);
                    }
                });
            }
        }
    }else{
        bootMessage("danger", "名称不能为空！");
    }
    });



    $('#pro-list').change(function () {
        $('#city-list option').remove();
        if(($('#pro-list').val())!=0){

        $.post($("#get-city-rul").attr("data"), {
            "Id": $('#pro-list').val(),
        }, function (d) {
            if (d.info.code == 0) {
                var city_data = d.data;
                var option_group = '';
                $('#city-list').append('<option value=0>请选择</option>');
                for (var i = 0; i < city_data.length; i++) {
                    option_group = option_group + '<option value=' + city_data[i].Id + '>' + city_data[i].name + '</option>';

                }
                $('#city-list').append(option_group);
            }
        });
        }else {
            $('#city-list').append('<option value=0>请选择</option>');
        }

    });

});
