<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>

            <h2>注册</h2>
         <form action="/firm/rega" method="post" enctype="multipart/form-data">
            企业名称：<input type="text" name="firm_name"></br>
            法人：<input type="text" name="firm_username"></br>
            税务号：<input type="text" name="firm_tax"></br>
            对公账号：<input type="text" name="firm_account"></br>
            营业执照：<input type="file" name="firm_business"></br>
            <input type="submit" value="点击注册">
        </form>
        
</body>
</html>