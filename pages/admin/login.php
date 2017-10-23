  <?php 
    require '../functions.php';
    $message = '';
    if(!empty($_POST)){
      $email = $_POST['email'];
      $password = $_POST['password'];
      // $conne3ct = mysqli_connect('localhost','root','123456');
      // mysqli_select_db($connect,'baixiu');
      // mysqli_set_charset($connect,'utf-8');
      $rows = query('SELECT * FROM users WHERE email="' . $email . '"');
      // $row = mysqli_fetch_assoc($result);
      var_dump($rows);
      if($rows[0]){
        if($rows[0]['password']==$password){
          header('Location: /admin');
          session_start();
          $_SESSION['user_inf']=$rows[0];
          exit;
        }else{
          $message = '登录失败';
          }
        } else {
        $message = '账号不存在';
              }
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="./login.php" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if(!empty($message))  { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message;?>
      </div>
      <?php }?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="密码">
      </div>
      <input type="submit" class="btn btn-primary btn-block" value="登录">
     
    </form>
  </div>
</body>
</html>
