<?php  
  require '../functions.php';
  checkLogin();
  $sql = 'SELECT * FROM categories';
  $lists = query($sql);
  $message = '';
  $action = isset($_GET['action'])?$_GET['action']:'add';
  $actives = array('dashboard','category','posts','post');
  $active = 'category';
 
  $cat_id = isset($_GET['cat_id'])?$_GET['cat_id']:0;
  if($action == 'add'){

  unset($_GET['action']);
  unset($_GET['cat_id']);
  $result = insert('categories',$_GET);

  if($result){
    header('Location: /admin/categories.php');

    }else {
      $message = '添加失败';
    }
  } 
  if($action == 'edit'){
    $action = 'update';
    $sql = 'SELECT * FROM categories WHERE id=' . $cat_id;
    $rows = query($sql);
  }else if($action == 'update'){
   
    unset($_GET['action']);

    $cat_id = $_GET['id'];

    unset($_GET['id']);

    $result = update('categories', $_GET, $cat_id);

    if($result) {
      header('Location: /admin/categories.php');
      exit;
    }

  }else if($action == 'delete'){

    $sql = 'DELETE FROM categories WHERE id=' . $cat_id;

    $result = delete($sql);

    if($result){
      header('Location: /admin/categories.php');
      exit;
    }
  }

 

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <?php include './inc/style.php';  ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="main">
   <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      
      <!-- <div class="alert alert-danger">
        <strong><?php /*echo $message*/; ?></strong>
      </div>
 -->
      <div class="row">
        <div class="col-md-4">
          <form action="/admin/categories.php" method="get">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <input type="hidden" name="id" value="<?php echo $cat_id; ?>">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value="<?php echo !empty($rows[0]['name'])?$rows[0]['name']:''; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo !empty($rows[0]['slug'])?$rows[0]['slug']:''; ?>">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($lists as $key=>$val) { ?>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><?php echo $val['name']; ?></td>
                <td><?php echo $val['slug']; ?></td>
                <td class="text-center">
                  <a href="/admin/categories.php?action=edit&cat_id=<?php echo $val['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/categories.php?action=delete&cat_id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
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
  <?php include './inc/script.php'; ?>

</body>
</html>
