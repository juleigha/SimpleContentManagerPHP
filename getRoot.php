<?php
function GetRoot()
{
  $_path = getcwd();
  $_rootPath = $_SERVER['DOCUMENT_ROOT'];
  $x = strpos($_path,$_rootPath);
  $_path = substr($_path, $x + strlen($_rootPath));
  return $_path;
}

 ?>
