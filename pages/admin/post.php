<?php 
  require '../functions.php';
  checkLogin();
  $action = isset($_GET['action'])?$_GET['action']:'add';
  // $pid = isset($_GET['pid'])?$_GET['pid']:'';
  $actives = array('dashboard','categories','posts','post');
  $active = 'post';
  if(!empty($_POST)){
     // echo $pid;
     // exit;
    if($action == 'add'){
    unset($_POST['pid']);
    $result = insert('posts', $_POST);
    // print_r($action);
    // exit;
    if($result) {
      header('Location: /admin/posts.php');
      exit;
    }
      $message = '添加文章失败!';
  }else if($action == 'update') { 

      $id = $_POST['pid'];

      unset($_POST['pid']);

      $result = update('posts', $_POST, $id);

      if($result) {
        header('Location: /admin/posts.php');
        exit;
      }
    }
}
  if($action == 'edit'){
      $action = 'update';
      $pid = $_GET['pid'];
      $sql = 'SELECT * FROM posts WHERE id=' . $pid;
      $liss = query($sql);
      // print_r($liss);
      // exit;
    }

  $sql = 'SELECT * FROM categories';
  $lists = query($sql);

  // print_r($_GET);
  // exit;

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <div class="main">
    <?php include './inc/nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="/admin/post.php?action=<?php echo $action; ?>" method="post">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_inf']['id']; ?>">
        <input type="hidden" name="feature" class="themp" value="<?php echo isset($liss[0]['feature']) ? $liss[0]['feature'] : '' ?>">
        <input type="hidden" name="pid" value="<?php echo $pid ?>">
          </div>
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" value="<?php echo !empty($liss[0]['title'])?$liss[0]['title']:''; ?>">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" name="content" cols="30" rows="10" placeholder="内容"><?php echo !empty($liss[0]['content'])?$liss[0]['content']:''; ?></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo !empty($liss[0]['slug'])?$liss[0]['slug']:''; ?>">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <?php if(!empty($liss[0]['feature'])) { ?>
            <img class="help-block thumbnail preview" src="<?php echo $liss[0]['feature']; ?>">
            <?php }else { ?>
            <img class="help-block thumbnail preview" style="display:none">
            <?php } ?>
            <input id="feature" class="form-control" type="file">
          
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              <?php foreach($lists as $key=>$val) { ?>
              <option value="<?php echo $val['id']; ?>" <?php if(isset($liss[0]['category_id'])) { if($liss[0]['category_id'] == $val['id']) { ?> selected <?php }} ?>><?php echo $val['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="text" value="<?php echo !empty($liss[0]['created'])?$liss[0]['created']:''; ?>">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted" <?php if(isset($liss[0]['status'])) { if($liss[0]['status']=='drafted') { ?>selected <?php } } ?>   >草稿</option>
              <option value="published" <?php if($liss[0]['status']=='published') { ?>selected <?php } ?> >已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
  <script src="/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="/assets/vendors/ueditor/ueditor.all.min.js"></script>
  <script type="text/javascript">
    UE.getEditor('content');
    $('#feature').on('change',function(){
      console.log(1);
      var data = new FormData();
      data.append('avata',this.files[0]);
      var xhr = new XMLHttpRequest;
      xhr.open('post','/admin/po.php');
      xhr.send(data);
       xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
          // console.log(xhr.responseText);
          $('.preview').attr('src', xhr.responseText).show();
          $('.themp').val(xhr.responseText);
        }
      }

    })
  </script>
</body>
</html>
