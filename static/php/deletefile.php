<?php 
header('Access-Control-Allow-Origin:https://localhost:8080');
header('Access-Control-Allow-Origin:*');
include_once './getpath.php';
$filename = $_POST["filename"];
$path = $_SERVER['DOCUMENT_ROOT']."/axi/".getPath("/axi/","img")."/";
$filepath = $path.$filename;
if(is_file($filepath)){
	if(unlink($filepath)){
		echo json_encode(array(
			"result"=>"200",
			"message"=>"删除成功"
		));
	}else {
		echo json_encode(array(
			"result"=>"400",
			"message"=>"删除失败"
		));
	}
}else {
	echo json_encode(array(
		"result"=>"401",
		"message"=>"没有该文件"
	));
}


?>