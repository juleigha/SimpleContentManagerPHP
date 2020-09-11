<?php
include "rootvars.php";
function GetFile($fileName){
  try {
    if(!file_exists($fileName)){
      throw new Exception(PAGE_NOT_FOUND);
    }
    $json = file_get_contents($fileName);
    $jsArray = json_decode($json, true);
    return $jsArray;
  } catch (Exception $e) {
    // include $e->getMessage() ;
  }
}
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $products = GetFile($prodsPath);
  $target_dir = DOCROOT."Texts/{$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]}/";
  $uploadOk = 1;
  $productArr = [];
  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
    $cats = GetFile($prodsPath);
    foreach ($cats[0]["options"] as $key => $value) {
      $products = GetFile("../../".$value["json"]);
      foreach ($products as $a => $b) {
        array_push($productArr, $b);
      }
    }
    $target_dir .= $masterjs[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["href"]."/";
  }
  else{
    $productArr = $products;
  }
  $q = $_GET["q"];
  $hint = "";
  if($q != ""){
    $q = strtolower($q);
    foreach ($products as $key => $value) {
      if(stripos($value["name"],$q) > -1){
        $hint.= "<li class='searchedHint' data-index='".$key."'>".$value["name"]."</li>";
      }
    }
      // if (array_key_exists($_GET["typedata"],$productArr[$_GET["arrayIndex"]])){
      //
      // }
    echo $hint;
  }
  ?>
  <script type="text/javascript">
    $(".searchedHint").click(function (data) {
      $(".hiddenIndex").text($(this).attr("data-index"));
      console.log($(this).attr("data-index"));
      $(".content").load("scripts/getText.php?action=getText&typedata=V1&arrayIndex="+$(this).attr("data-index")+$("select").val(),function () {

      });
    })
  </script>
