$().ready(function(){

});

function checkIsNull(obj){
    var confirm_id = $(obj).attr('id');
    var text_value = $(obj).val();
    if(!text_value){
        $(obj).css('border','1px solid red');
        $('#confirm_'+confirm_id).css('display','block');
    }else{
        //判断邮箱
        if(confirm_id == 'email'){
            var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; //验证邮箱的正则表达式
            if(!reg.test(text_value))
            {
                $(obj).css('border','1px solid red');
                $('#confirm_'+confirm_id).css('display','block');
                $('#confirm_'+confirm_id).text('输入的邮件格式不正确');
            }else{
                $(obj).css('border','1px solid green');
                $('#confirm_'+confirm_id).css('display','none');
            }
        }else{
            $(obj).css('border','1px solid green');
            $('#confirm_'+confirm_id).css('display','none');
        }
    }
}

function confirmForm(){
    //验证
    var confirm = true;
    $('.textbox').each(function(){
        var confirm_id = $(this).attr('id');
        var text_value = $(this).val();
        if(!text_value){
            $(this).css('border','1px solid red');
            $('#confirm_'+confirm_id).css('display','block');
        }else{
            //判断邮箱
            if(confirm_id == 'email'){
                var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; //验证邮箱的正则表达式
                if(!reg.test(text_value))
                {
                    $(this).css('border','1px solid red');
                    $('#confirm_'+confirm_id).css('display','block');
                    $('#confirm_'+confirm_id).text('输入的邮件格式不正确');
                }else{
                    $(this).css('border','1px solid green');
                    $('#confirm_'+confirm_id).css('display','none');
                }
            }else{
                $(this).css('border','1px solid green');
                $('#confirm_'+confirm_id).css('display','none');
            }
        }
    });
    $('.textbox').each(function(){
        if(!$(this).val()){
            confirm = false;
            return false;
        }
    });
    if(confirm){
        //验证通过则提交
        postForm();
    }else{
        alert('error');
    }
    return false;
}

function postForm(){
    var url = '/index/index/contact';
    $.ajax({
        type: 'POST',
        url: url,
        data: {data : $('#commentForm').serialize()},
        //dataType: 'json',
        success: function(data){
            var value = JSON.parse(data);
            if(value.code == 1){
                layer.msg(value.msg, {icon: 1, time: 2000}, function(){ //2秒关闭（如果不配置，默认是3秒）
                    $('.textbox').each(function(){
                        $(this).val('');
                        $(this).css('border','1px solid #ececec');
                    });
                });
            }else{
                layer.msg(value.msg, {icon: 2,time: 2000});
            }
        },
        error: function(request) {
            layer.msg('网络错误!', {icon: 5,time: 2000}); //2秒关闭（如果不配置，默认是3秒）
        }
    });
}
