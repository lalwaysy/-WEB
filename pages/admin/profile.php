<?php 
  require '../functions.php';
  checkLogin();
  $user_id = $_SESSION['user_inf']['id'];
  $sql = 'SELECT * FROM  users WHERE id=' . $user_id; 
  $rows = query($sql);
  // print_r($rows);
  // exit;
  if(!empty($_POST)){
    unset($_POST['email']);
    $result = update('users',$_POST,$user_id);
    if ($result) {
      header('Location: /admin/profile.php');
      exit;
    }else {
      $message = '更新失败';
    }
  }

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if(isset($message)) {  ?>
      <div class="alert alert-danger">
        <strong><?php echo $message;  ?></strong>
      </div>
      <?php } ?>
      <form action="/admin/profile.php" method="post" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">
              <?php if(!empty($rows[0]['avatar'])) { ?>
              <img class="preview" src="<?php echo $rows[0]['avatar'];  ?>">
              <?php }else { ?>
              <img class="preview" src="../assets/img/default.png">
              <?php } ?>
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="<?php echo $rows[0]['email'];  ?>" placeholder="邮箱" disabled>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" class="form-control" name="slug" type="type" value="<?php echo $rows[0]['slug'];  ?>" placeholder="slug">
            <p class="help-block">https://zce.me/author/<strong>zce</strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="<?php echo $rows[0]['nickname'];  ?>" placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" class="form-control" placeholder="Bio" cols="30" rows="6"><?php echo $rows[0]['bio'];  ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">更新</button>
            <a class="btn btn-link" href="password-reset.html">修改密码</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>

  <?php include './inc/script.php'; ?>
  <script type="text/javascript">
    $('#avatar').on('change',function(){
      var data = new FormData();
      data.append('avata',this.files[0]);
      var xhr = new XMLHttpRequest;
      xhr.open('post','/admin/upfile.php');
      xhr.send(data);
       xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
          // console.log(xhr.responseText);
          $('.preview').attr('src', xhr.responseText);
          
        }
      }

    })
  
  </script>
</body>
</html>
