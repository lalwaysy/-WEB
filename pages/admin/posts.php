<?php 
  require '../functions.php';
  checkLogin();

  $actives = array('dashboard','categories','posts','post');
  $active = 'posts';
  // print_r($list);
  // exit;
  $sq = 'SELECT COUNT(*) AS abc FROM comments';
  $list = query($sq);
  $zs = 5;
  $sjz = 97;
  $xs = 6;
  $dq = isset($_GET['dq'])?$_GET['dq']:1;
  $prevpage = $dq-1;
  $nextpage = $dq+1;
  $ys = ceil($sjz/$xs);
  $start = $dq - floor($xs/2);
  $start = $start<1 ? 1:$start;
  $end = $start+$xs-1;
  $end = $end>=$ys?$ys:$end;
  $start = $end-$xs+1;
  $start = $start<1 ? 1:$start;
  $page = range($start,$end);

  $offset = ($dq-1)*$zs;
 
 
  $sql = 'SELECT posts.id,posts.title,posts.created,posts.status,users.nickname,categories.name FROM posts LEFT JOIN users ON posts.user_id = users.id LEFT JOIN categories ON posts.category_id = categories.id LIMIT ' . $offset . ',' . $zs;
  $result = query($sql);
  // print_r($result);
  // exit;
  $action = isset($_GET['action'])?$_GET['action']:'';
  $pid = isset($_GET['pid'])?$_GET['pid']:'';
  if($action == 'delete'){
    $sql = 'DELETE FROM posts WHERE id=' . $pid;
    $result = delete($sql);
    // print_r($result);
    // exit;
    if($result){
      header('Location: /admin/posts.php');
      exit;
    }
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <?php include './inc/style.php'; ?>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body> 
  <div class="main">
      <?php include './inc/nav.php'; ?>
        <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <?php if($dq > 1){ ?>
          <li><a href="/admin/posts.php?dq=<?php echo $prevpage; ?>">上一页</a></li>
          <?php } ?>
          <?php foreach($page as $key=>$value) { ?>
          <?php if($dq == $value) { ?>
          <li class="active"><a href="/admin/posts.php?dq=<?php echo $value; ?>"><?php echo $value ?></a></li>
          <?php }else {  ?>
          <li><a href="/admin/posts.php?dq=<?php echo $value; ?>"><?php echo $value ?></a></li>
          <?php } ?>
          <?php } ?>
          <?php if($dq<$ys) { ?>
          <li><a href="/admin/posts.php?dq=<?php echo $nextpage; ?>">下一页</a></li>
          <?php } ?>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <tbody>
          <?php foreach($result as $key=>$val) { ?>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td><?php echo $val['title']; ?></td>
            <td><?php echo $val['nickname']; ?></td>
            <?php if(!empty($val['name'])) { ?>
            <td><?php echo $val['name']; ?></td>
            <?php }else { ?>
            <td>未分类</td>
            <?php } ?>
            <td class="text-center"><?php echo $val['created']; ?></td>
            <td class="text-center"><?php echo $val['status']; ?></td>
            <td class="text-center">
              <a href="/admin/post.php?action=edit&pid=<?php echo $val['id']; ?>" class="btn btn-default btn-xs">编辑</a>
              <a href="/admin/posts.php?action=delete&pid=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
           <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include './inc/aside.php'; ?>
  <?php include './inc/script.php'; ?>
</body>
</html>
