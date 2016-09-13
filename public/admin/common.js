$('#button-weight').click(function(){

    //获取weight内容
    var data = $("#yunzhicms-weight").serializeArray();
    postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    });
    var url = SCOPE.weight_url;
    $.post(url,postData,function(result){
        console.log(result);
        if(result.status === "SUCCESS"){
            //成功
             window.location.reload();
        }else if(result.status === "ERROR"){
            //失败
            alert('更新权重失败');
        }
    },"JSON");

})