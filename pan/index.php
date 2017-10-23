<?php
	
	$diskk = include './disk.php';
	// echo $diskk['total'];
	$dir = isset($_GET['name'])?$_GET['name']:disk;
	function finder($dir){
		static $parents = array();
		$path = dirname($dir);
		$parents[] = $path;
		if($path!= disk){
			finder($path);
		}
		return $parents;
	}
	$i = 0 ;
	$i++;
	echo $i;
	print_r(finder($dir));
	$breakcurm = array_reverse(finder($dir));
	// print_r($breakcurm);
	function fn($dir){
		if(!is_dir($dir)){
			echo '不是一个目录';
			return;
		}
		$rows = scandir($dir);
		$list = array();
		foreach($rows as $key=>$val){
			if($val == '.'||$val == '..'){
				continue;
			}
			$path = $dir . '/' . $val;
			$tmp = array();
			$tmp['name'] = iconv('gbk', 'utf-8', $val);;
			$tmp['mtime'] = date('Y-m-d h:i:s',filemtime($path));
			$tmp['realpath'] = $path;
			$tmp['flag'] = true;
			$tmp['type'] = 'folder';
			if(is_file($path)){
				$tmp['size'] = filesize($path);
				$tmp['flag'] = false;
				$tmp['type'] = pathinfo($path)['extension'];
			}
			if(is_dir($path)){
				$tmp['size']='-';
			}
			$list[] = $tmp;
		}
		return $list;
	}
	$items = fn($dir);
	include './views/index.html';