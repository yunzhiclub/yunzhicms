$('#button-weight').click(function(){
    //获取weight内容
    var data = $("#yunzhicms-weight").serializeArray();
    postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    });
    var url = SCOPE.weight_url;
    $.post(url,postData,function(result){
        if(result.status == 1){
            //成功
            return dialog.success(result.message,result['data']['jump_url']);
        }else if(result.status == 0){
            //失败
            return dialog.error(result.message,result['data']['jump_url']);
        }
    },"JSON");
})