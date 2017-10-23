<?php
	
	define('disk', 'F:\\');
	$tota = round(disk_total_space(disk)/1024/1024/1024,1);
	$fre = round(disk_free_space(disk)/1024/1024/1024,1);
	$use = $tota-$fre;
	$prenc = round($use/$tota,1)*100 . '%';
	return array(
			'total'=>$tota,
			'free'=>$fre,
			'user'=>$use,
			'prenct'=>$prenc
		);