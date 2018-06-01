<?php 
function getPath($path,$key)
{
	$root_dir_name = $_SERVER['DOCUMENT_ROOT'];
	$temp = $root_dir_name.$path;
	$dir = opendir($temp);
	while( ($configfilename = readdir($dir)) !== false ) 
	{
		if ($configfilename!="."&&$configfilename!=".."&&strpos($configfilename,$key)!==false) { //
			return $configfilename;
		}
	}
}
?>