
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
        <table border="1">
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