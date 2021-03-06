<?php
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin:https://localhost:8080');
header('Access-Control-Allow-Origin:*');
// 允许上传的图片后缀
$allowedExts = array("jpeg", "jpg","png","bmp");
$temp = explode(".", $_FILES["file"]["name"]);
$root_dir_name = $_SERVER['DOCUMENT_ROOT'];
$handler = opendir($root_dir_name."/axi");
$needpath;
while( ($rootfilename = readdir($handler)) !== false ) 
{
    if ($rootfilename!="."&&$rootfilename!=".."&&strpos($rootfilename,"img")!==false) {
        $needpath = $rootfilename;
    }
}
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 512000)   // 小于 400 kb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo json_encode(array(
            "result"=>"203",
            "message"=>"上传失败!"
        ));
    }
    else
    {
        //echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        //echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        //echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        //echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";

        // 判断当期目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
            //echo $_FILES["file"]["name"] . " 文件已经存在。 ";
            echo json_encode(array(
                "result"=>"204",
                "message"=>"文件已经存在!"
            ));
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $root_dir_name."/axi/".$needpath."/" . $_FILES["file"]["name"])){
                echo json_encode(array(
                    "result"=>"200",
                    "message"=>"上传成功!"
                ));
            }else {
                echo json_decode(array(
                    "result"=>"201",
                    "message"=>"上传失败!"
                ));
            }

            //echo $_SERVER['DOCUMENT_ROOT'];
        }
    }
}
else
{
    echo json_decode(array(
        "result"=>"202",
        "message"=>"非法的文件格式!"
    ));
}
?>