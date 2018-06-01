<?php 
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:https://localhost:8080');
header('Access-Control-Allow-Origin:*');
$newname = $_POST["newname"];
$type = $_POST["type"];
$root_dir_name = $_SERVER['DOCUMENT_ROOT'];

include_once 'renamefun.php';

if ($type==="img") {
	
	if(modificationfolder($root_dir_name."/axi/","img",$newname,"")&&modificationfile('"img_url":"'.$newname.'"',2,$root_dir_name."/axi/js/","config")){
		echo json_encode(array(
			"result"=>"200",
			"message"=>"成功!"
		));
	}else {
		echo json_encode(array(
			"result"=>"201",
			"message"=>"失败!"
		));
	}
}elseif ($type==="config") {
	
	if(modificationfolder($root_dir_name."/axi/js/","config",$newname,".js")&&modificationfile('<script type="text/javascript" src="js/'.$newname.'.js"></script>',73,$root_dir_name."/axi/","index")){
		echo json_encode(array(
			"result"=>"200",
			"message"=>"成功!"
		));
	}else{
		echo json_encode(array(
			"result"=>"201",
			"message"=>"失败!"
		));
	}
}
?>