<?php 

  require '../functions.php';
  checkLogin();
  $message = '';
  $actives = array();
  $cogs=array();
  $active = 'users';
  $action=isset($_GET['action'])?$_GET['action']:'add';
  if(!empty($_POST)){
    // $slug = $_POST['slug'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];
    // $nickname = $_POST['nickname'];
     if($action == 'add'){
     $_POST['status'] = 'unactivated';
     $result = insert('users',$_POST);
     if($result){
        header('Location: /admin/users.php');
     }else {
       $message = '添加新用户失败';
      }
    }
     if($action == 'update'){
   
       $id = $_POST['id'];
       // var_dump($id);
       unset($_POST['id']);
       $result = update('users',$_POST,$id);
       var_dump($result);
       exit;
       if($result){
          header('Location:/admin/users.php');
          exit;
       }

     }
     if($action == 'deleteAll'){
      // echo 1;
        // print_r($_POST['ids']);
        // exit;
        // echo $_POST;
        // [1,2141]
        // 'DELETE FROM users WHERE id in (   '  . implode()  . '   )'

        $sql = 'DELETE FROM users WHERE id in (' . implode(',', $_POST['ids']). ')';
        $result = delete($sql);
        var_dump($result);
        exit;
        // echo $action;
        // exit;
        header('Content-Type: application/json');
        if($result){
           $info = array('code'=>10000, 'message'=>'删除成功!');

          echo json_encode($info);
        }else {
        // 失败提示信息
        $info = array('code'=>10001, 'message'=>'删除失败!');

        echo json_encode($info);
      }
      exit;
     }
  }

    $lists = query('SELECT * FROM users');
  
    $user_id = isset($_GET['user_id']) ? $_GET['user_id']:'';
    // var_dump($user_id);
    // exit;
    if($action == 'edit'){
      $action = 'update';
      $rows = query('SELECT * FROM users WHERE id=' . $user_id);
      // var_dump($rows);
    }else if($action=='delete'){
       $result = delete('DELETE FROM users WHERE id=' . $user_id);
       // echo $result;
       // exit;
       if($result) { // 自己的
        header('Location: /admin/users.php');
        exit;
      }
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if(!empty($message)) { ?>
      <div class="alert alert-danger">
        <strong><?php echo $message; ?></strong>
      </div>
      <?php } ?>
      <div class="row">
        <div class="col-md-4">
          <form action="./users.php?action=<?php echo $action;?>" method="post">
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>

              <?php if($action!='add') { ?>
              <input type="hidden" name="id" value="<?php echo isset($rows[0]['id'])?$rows[0]['id']:''?>">
              <?php } ?>

              <input id="email" class="form-control" name="email" type="email" value="<?php echo isset($rows[0]['email'])?$rows[0]['email']:''?>" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" value="<?php echo isset($rows[0]['slug'])?$rows[0]['slug']:''?>" placeholder="别名">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" value="<?php echo isset($rows[0]['nickname'])?$rows[0]['nickname']:''?>" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" value="<?php echo isset($rows[0]['password'])?$rows[0]['password']:''?>" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm delete" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40">
                  <input type="checkbox" id="toggle"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
               <?php foreach($lists as $key=>$val) { ?>
              <tr>
                <td class="text-center">
                  <input type="checkbox" class="chk" value="<?php echo $val['id'] ?>">
                </td>
                <td class="text-center"><img class="avatar" src="<?php echo $val['avatar'] ?>"></td>
                <td><?php echo $val['email']; ?></td>
                <td><?php echo $val['slug']; ?></td>
                <td><?php echo $val['nickname']; ?></td>
                <?php if($val['status'] == 'activated') { ?>
                <td>已激活</td>
                <?php } else if($val['status'] == 'unactivated') { ?>
                <td>未激活</td>
                <?php } else if($val['status'] == 'forbidden') { ?>
                <td>已禁用</td>
                <?php } else { ?>
                <td>已删除</td>
                <?php } ?>
                <td class="text-center">
                  <a href="/admin/users.php?action=edit&user_id=<?php echo $val['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                  <a href="/admin/users.php?action=delete&user_id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    $('#toggle').on('click',function(){
      if(this.checked){
        $('.chk').prop('checked',true);
        $('.delete').show();
      }else {
        $('.chk').prop('checked',false);
        $('.delete').hide();
      }
    })
     $('.chk').on('change',function(){
      var size = $('.chk:checked').size();
      if (size>0) {
        $('.delete').show();
      }else{
          $('.delete').hide();
      }
    })




     $('.delete').on('click',function(){
      var ids = [];
      $('.chk:checked').each(function(){
        ids.push($(this).val());
        console.log(ids);
      })
       $.ajax({
        url:'/admin/users.php?action=deleteAll',
        type:'post',
        data:{ ids : ids},
        success:function(info){
          console.log(info)
          alert(info.message);
          if(info.code ==10000){
           location.reload();
          }
        }
     })
     })

    

  </script>
</body>
</html>
