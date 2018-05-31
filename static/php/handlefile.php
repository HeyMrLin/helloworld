<?php
header('Access-Control-Allow-Origin:https://localhost:8080');
header('Access-Control-Allow-Origin:*');
$root_dir_name = $_SERVER['DOCUMENT_ROOT'];
$filenamearr=array();
$axi = opendir($root_dir_name."/axi");
$needpath;

while( ($rootfilename = readdir($axi)) !== false ) 
{
	if ($rootfilename!="."&&$rootfilename!=".."&&strpos($rootfilename,"img")!==false) {
		$needpath = $rootfilename;
	}
}
$path = $root_dir_name."/axi/".$needpath;
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
echo json_encode(array(
	"result"=>"200",
	"message"=>"文件名获取成功",
	"data"=>$filenamearr
));
?>