<?php 
header("Content-type: text/html; charset=utf-8"); 
$newimgname = $_POST["newimgname"];
$newconfigname = $_POST["newconfigname"];
$root_dir_name = $_SERVER['DOCUMENT_ROOT'];
$needpath;
modificationfile('"img_url":"'.$newimgname.'"',2,$root_dir_name."/axi/js/","config");
modificationfile('<script type="text/javascript" src="js/'.$newconfigname.'.js"></script>',73,$root_dir_name."/axi/","index");
// 修改文件
function modificationfile($replaceStr,$line,$path,$key)	// 参数:$replaceStr--要替换的内容，$line--第几行，$path--文件路径，$key--文件的关键字
{
	$configfilenamestr;
	$config = opendir($path);
	while( ($configfilename = readdir($config)) !== false ) 
	{
		if ($configfilename!="."&&$configfilename!=".."&&strpos($configfilename,$key)!==false) { //
			$configfilenamestr = $configfilename;
		}
	}
	$content = fopen($path.$configfilenamestr,"r+");
	$i=1;
	while (!feof($content)) {
		if ($i==$line) {
			fseek($content,0,SEEK_CUR);
			fwrite($content, $replaceStr);
			break;
		}
		fgets($content);
		$i++;
	}
	fclose($content);
}


modificationfolder($root_dir_name."/axi/","img",$newimgname,"");
modificationfolder($root_dir_name."/axi/js/","config",$newconfigname,".js");
//更改图片文件夹名称
function modificationfolder($path,$key,$newname,$suffix)
{
	$axi = opendir($path);
	while( ($rootfilename = readdir($axi)) !== false ) 
	{
		if ($rootfilename!="."&&$rootfilename!=".."&&strpos($rootfilename,$key)!==false) {
			$needpath = $rootfilename;
		}
	}
	if (rename($path.$needpath,$path.$newname.$suffix)) {
		echo "成功";
	}else {
		echo "失败";
	}
}

?>