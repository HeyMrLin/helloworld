<?php
header('Access-Control-Allow-Origin:https://localhost:8080');
header('Access-Control-Allow-Origin:*');
include_once './getpath.php';
$root_dir_name = $_SERVER['DOCUMENT_ROOT'];
$filenamearr=array();
$axi = opendir($root_dir_name."/axi");
$path = $root_dir_name."/axi/".getPath("/axi/","img");
$handler = opendir($path);
$index = 1;
while( ($filename = readdir($handler)) !== false ) 
{
	if($filename != "." && $filename != ".."&&strpos($filename,".jpg")!==false) // &&strpos($filename,".jpg")!==false
	{
		$obj = (object)array("filename"=>$filename,"rownum"=>$index);
		$obj = json_encode($obj);
		array_push($filenamearr,$obj);
		$index++;
	}
}
$imgFileName = getPath("/axi/","img");
$configFileName = getPath("/axi/js/","config");
echo json_encode(array(
	"result"=>"200",
	"message"=>"文件名获取成功",
	"data"=>$filenamearr,
	"imgFileName"=>$imgFileName,
	"configFileName"=>$configFileName
));
?>