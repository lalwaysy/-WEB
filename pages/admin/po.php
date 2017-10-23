<?php

    require '../functions.php';
    // 检测存放图片的目录是否存在
    if(!file_exists('../uploads')) {
        mkdir('../uploads');
    }
    // print_r($_FILES);
    // exit;
    // 使用时间戳做为文件名，一定程度上避免名字重复
    $filename = time();
    // 根据文件名获取文件后缀
    $ext = explode('.', $_FILES['avata']['name'])[1];
    // 拼凑目录路径
    $path = '/uploads/' . $filename . '.' . $ext;
    // 读取用户id
    $sql = 'SELECT * FROM posts';
    $result = query($sql);
  //   foreach ($result as $key => $value) {
  //   $lis = array();
  //   $id = $value['id'];
  //   $lis[] = $id;
  // // }
  // print_r($lis);
  //   $user_id = $_SESSION['user_inf']['id'];

    // 转存上传文件到指定目录
    move_uploaded_file($_FILES['avata']['tmp_name'], '..' . $path);
    // 更新数据库（永久存储）

    // 将上传路径返回给浏览器，实现预览效果
    echo $path;