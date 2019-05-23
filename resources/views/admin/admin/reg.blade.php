
<style>
    no-padding {
        padding: 0 !important;
    }
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
        background-color:#fff;
    }
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd;
    }
    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    div {
        display: block;
    }
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-weight: 400;
        overflow-x: hidden;
        overflow-y: auto;
    }
    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }
    html {
        font-size: 10px;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    html {
        font-family: sans-serif;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .box-header:after, .box-body:after, .box-footer:after {
        clear: both;
    }
    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
        content: " ";
        display: table;
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册展示</title>
</head>
<script src="/jq/jquery-3.1.1.min.js"></script>

<body>
<div class="box-body table-responsive no-padding content">
        <table class="table table-hover">
               <tr>
                     <td>请选择</td>
                    <td>ID</td>
                   <td>企业名称</td>
                   <td>法人</td>
                   <td>税务号</td>
                   <td>对公账号</td>
                   <td>状态</td>
                   <td>营业执照</td>
               </tr>
               @foreach($info as $k=>$v)
               <tr>
               <td><input type="checkbox" class="check" id="{{$v->f_id}}"></td>
                   <td>{{$v->f_id}}</td>
                   <td>{{$v->firm_name}}</td>
                   <td>{{$v->firm_username}}</td>
                   <td>{{$v->firm_tax}}</td>
                   <td>{{$v->firm_account}}</td>
                    <td>
                        @if($v->status=='2')
                           审核通过
                       @else
                            请审核
                        @endif
                        
                    </td>
                   <td><img src="/{{$v->firm_business}}" alt="" width="100" high="100"></td>
                   <td>
                   <a href="javascript:;" class="button">审核</a>
                   </td>
               </tr>
                @endforeach
              
        </table>
</div>
</body>
</html>
<script>
    $(function(){
        $(document).on("click",".button",function(){    
                var box=$(this).parents().find("input[class='check']");
                //console.log(id);
                var id='';
                box.each(function(index){
                    if($(this).prop("checked")==true){
                        id+=$(this).attr('id')+',';
                    }
                })
                id=id.substr(0,id.length-1);
               $.post(
                   "/admin/audit",
                   {id:id},
                   function(res){
                        if(res.error==1){
                            alert('审核成功');
                             $(".button").html('审核通过');
                        }else{
                            alert('该企业已经审核');
                        }
                   }
               )

        })
    })
</script>