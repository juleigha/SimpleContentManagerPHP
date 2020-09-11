<?php
include 'scripts/rootvars.php';
define("IMAGES","../Images/");
$action = $_GET["action"];
switch ($action) {
  case 'table':
    Table($_GET["categoryIndex"], $_GET["prodList"]);
  break;
  default:
    $action();
  break;
}
function GetFile($fileName){
  try {
    if(!file_exists($fileName)){
      throw new Exception("PAGE_NOT_FOUND");
    }
    $json = file_get_contents($fileName);
    $jsArray = json_decode($json, true);
    return $jsArray;
  } catch (Exception $e) {
    echo $e->getMessage() ;
  }
}
function Table($categoryIndex, $prodList)
{
  include 'scripts/makeTable.php';
}
function search()
{
  include 'scripts/search.php';
}
function options(){
  $js = GetFile("../Categories/Categories.json");
  foreach ($js as $key => $value) {
    foreach ($value["options"] as $k => $v) {
      $type = "na";
      if($v["2Versions"] == "TRUE"){
        $type = "V1";
      }
      echo "<option value='&categoryIndex={$key}&prodList={$k}&typedata={$type}'>{$v["name"]}</option>";
    }
  }
}
?>
