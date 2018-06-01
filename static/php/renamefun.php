<?php 
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
	$bool;
	while (!feof($content)) {
		if ($i==$line) {
			fseek($content,0,SEEK_CUR);
			fwrite($content, $replaceStr);
			$bool = true;
			break;
		}else {
			$bool = false;
		}
		fgets($content);
		$i++;
	}
	fclose($content);
	return $bool;
}


//更改图片文件夹名称
function modificationfolder($path,$key,$newname,$suffix)
{
	$axi = opendir($path);
	$needpath;
	while( ($rootfilename = readdir($axi)) !== false ) 
	{
		if ($rootfilename!="."&&$rootfilename!=".."&&strpos($rootfilename,$key)!==false) {
			$needpath = $rootfilename;
		}
	}
	if (rename($path.$needpath,$path.$newname.$suffix)) {
		return true;
	}else {
		return false;
	}
}

 ?>