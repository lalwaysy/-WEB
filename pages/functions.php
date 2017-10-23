<?php 

	require __DIR__ . '/config.php';
	session_start();
	function checkLogin(){
	  if (!isset($_SESSION['user_inf'])) {  //这个变量是否设置了，empty是说这个变量已经默认设置了，但是判断一下是否赋值为空
	    header('Location: /admin/login.php');
	    exit;
  		}
  	}
	function connect(){
		$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$connection){
			echo '数据库连接失败';
		};
		mysqli_select_db($connection, DB_NAME);
		mysqli_set_charset($connection, DB_CHARSET);
		return $connection;
	}
	function query($sql){
		$connection = connect();
		$result = mysqli_query($connection,$sql);
		$rows = fetch($result);
		return $rows;
	}
	function fetch($result){
		$rows = array();
		while($row = mysqli_fetch_assoc($result)){
			$rows[] = $row; 
		};
		return $rows;
	}
	function insert($table,$arr){
		$connection = connect();
		$keys = array_keys($arr);
		$values = array_values($arr);
           // '  INSERT INTO  uesrs ( a,name ,age   )  VALUES(   1 ", " 2 ", " 3     )'    [1,2,3]         
 
		$sql = "INSERT INTO " . $table .  " (" . implode(", ", $keys) . ") VALUES('" . implode("', '", $values) . "')";
		// echo $sql;
		// exit;
		$result = mysqli_query($connection,$sql);
		return $result;
	}
	 function delete($sql) {
        // DELETE FROM 表名 WHERE 条件
        $connection = connect();

        // echo $sql;
        // exit;
        $result = mysqli_query($connection, $sql);
        // exit;
        // echo $result;
        // exit;

        return $result;
    }
    function update($table,$arr,$id){
    	$connection = connect();
    	$str = "";
    	foreach($arr as $key=>$val){
    		$str .= $key . "=" . "'" . $val . "', ";
    	}
    	$str = substr($str,0,-2);
    	$sql = "UPDATE " . $table . " SET " . $str . " WHERE id=" . $id;
    	// echo  $sql ;
    	// exit;
    // 	print_r($_GET);
    // exit;
    	$result = mysqli_query($connection,$sql);
    	return $result;
    }