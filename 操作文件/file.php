<?php

Class File
{
    public function readFile()
    {
        echo readfile("webdictionary.txt");
    }

    public function openFile()
    {
        $myfile = fopen('webdictionary.txt','r') or die('Unable to open file!');
        echo fread($myfile,filesize('webdictionary.txt'));
        fclose($myfile);
    }
    //逐行读取
    public function readFileByLine()
    {
        $myfile = fopen('webdictionary.txt','r') or die('Unable to open file!');
        while(!feof($myfile))
        {
            echo fgets($myfile).'<br>';
        }
        fclose($myfile);
    }
    //单个字符读取
    public function readFileByCharacter()
    {
        $myfile = fopen('webdictionary.txt','r') or die('Unable to open file!');
        while(!feof($myfile))
        {
            echo fgetc($myfile).'<br>';
        }
        fclose($myfile);
    }
    //覆盖写入文件
    public function writeFile()
    {
        $myfile = fopen('webdictionary.txt','w') or die('Unable to open file!');
        $txt = "Bill Gates\n";
        fwrite($myfile,$txt);
        $txt = "Steve Jobs\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    //追加的方式写入
    public function writeFileByAppend()
    {
        file_put_contents("webdictionary.txt", "This is another something.", FILE_APPEND);
    }

}

$file = new File;
//$file->readFile();
//$file->openFile();
//$file->readFileByLine();
//$file->writeFile();
$file->writeFileByAppend();