<?php  
  require '../functions.php';
  checkLogin();
  $cogs = array('menus', 'slides', 'settings');
  $actives = array();
  
  $active = 'menus';
  $sql = 'SELECT value FROM options WHERE `key`="nav_menus"';
  $lists = query($sql);
  // print_r($lists);
  // exit;
  $json = $lists[0]['value'];
  $data = json_decode($json,true);

  // print_r($data);
  // exit;
  $action = isset($_GET['action'])?$_GET['action']:'add';
  if($action == 'delete'){
    $index = $_GET['index'];
    unset($data[$index]);
    // $data = array_values($data);
    // print_r($data);
    // exit;
    // echo json_encode($data);exit;
    $json = json_encode($data,JSON_UNESCAPED_UNICODE);
    // print_r($json);
    // exit;
    $result = update('options',array('value'=>$json),9);
    if ($result) {
      header('Location: /admin/menus.php');
      exit;
    }
  }
  if(!empty($_POST)){
    if($action=='add'){
      // print_r($_POST);
      // exit;
      $data[] = $_POST;
      $json = json_encode($data,JSON_UNESCAPED_UNICODE);
      $result = update('options',array('value'=>$json),9);
      if ($result) {
        header('Location: /admin/menus.php');
        exit;
     }
    }
  }


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action="/admin/menus.php?action=<?php echo $action; ?>" method="post">
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
              <div class="form-group">
              <label for="title">图标</label>
              <input id="title" class="form-control" name="icon" type="text" placeholder="自定义图标">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="href">链接</label>
              <input id="href" class="form-control" name="link" type="text" placeholder="链接">
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
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data as $key=>$val) { ?>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><i class="fa <?php echo $val['icon'] ?>"></i><?php echo $val['text'] ?></td>
                <td><?php echo $val['title'] ?></td>
                <td><?php echo $val['link'] ?></td>
                <td class="text-center">
                  <a href="/admin/menus.php?action=delete&index=<?php echo $key; ?>" class="btn btn-danger btn-xs">删除</a>
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
