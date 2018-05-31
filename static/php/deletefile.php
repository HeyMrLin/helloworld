<?php 
$filename = $_POST["filename"];
$path = $_SERVER['DOCUMENT_ROOT']."/axi/img_1.0.3/";
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