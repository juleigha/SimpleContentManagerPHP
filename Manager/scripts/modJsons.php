<?php
include "rootvars.php";
$called=$_GET["action"];
$called();
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
function move()
{
  $from = $_GET["from"];
  $to = $_GET["to"];
  echo "moving {$from} to {$to}";
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"] ;
  $products = GetFile($prodPath);
  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $prodPath = "../../".$products[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["json"];
    $products = GetFile($prodPath);
  }
  $newJs =[];
  $moving ;
  foreach ($products as $key => $value) {
    if ($key == $from){
      $moving = $value;
    }
  }
  foreach ($products as $key => $value) {
    if ($key != $from && $key != $to+1){
      array_push($newJs,$value);
      echo "\n".$value["name"];
    }
    if ($key == $to+1){
      array_push($newJs,$moving);
      array_push($newJs,$value);
      echo "\n*****newItem*****".$moving["name"];
      echo "\n".$value["name"];
    }
  }
  file_put_contents($prodPath,json_encode($newJs, JSON_PRETTY_PRINT) );
}//end move
function edit()
{
  $newStr = str_replace("ANDSIGN","&",str_replace("POUNDSIGN","#",$_GET["txtval"]));
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodPath ="../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $products = GetFile($prodPath);
  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $prodPath = "../../".$products[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["json"];
    $products = GetFile($prodPath);
  }
  $evalStr = explode("-",$_GET["index"]);
  var_dump($evalStr);
  switch (count($evalStr)) {
    case 1:
      $products[$_GET["focused"]][$evalStr[0]] = $newStr;
    break;
    case 2:
    $products[$_GET["focused"]][$evalStr[0]][$evalStr[1]] = $newStr;
    break;
    case 3:
    $products[$_GET["focused"]][$evalStr[0]][$evalStr[1]][$evalStr[2]] = $newStr;
    break;
  }
  var_dump($prodPath);
  file_put_contents($prodPath,json_encode($products, JSON_PRETTY_PRINT) );
} // end edit
function upload()
{
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $products = GetFile($prodsPath);
  $target_dir = DOCROOT."/{$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["imgPath"]}{$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]}/";
  $uploadOk = 1;

  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $masterjs = $products;
    $prodsPath = "../../".$products[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["json"];
    $products = GetFile($prodsPath);
    $target_dir = DOCROOT."/".$masterjs[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["imgPath"].$masterjs[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["href"]."/";
  }
  $target_file = str_replace(" ","",basename($_FILES["fileToUpload"]["name"]));
  $replc = ".".pathinfo($target_file,PATHINFO_EXTENSION);
  $jsString = str_replace($replc,"",str_replace(" ","",basename($_FILES["fileToUpload"]["name"])));

  switch ($_GET["typedata"]) {
    case 'V1':
      $products[$_GET["focused"]]["V1"]["image"] = $jsString;
      break;
    case 'V2':
      $products[$_GET["focused"]]["V2"]["image"] = $jsString;
      $target_dir.= "V2/";
      break;
    case 'na':
      $products[$_GET["focused"]]["image"] = $jsString;
  }
  $fname = $target_file;
  $target_file = $target_dir . $target_file;
  if (!file_exists($target_file)){
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      file_put_contents($prodsPath,json_encode($products, JSON_PRETTY_PRINT) );
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
  else {
    echo "Filename not unique: {$fname}";
  }
} // end uploadz
function productText()
{
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $products = GetFile($prodsPath);
  $target_dir = DOCROOT."Texts/{$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]}/";
  $uploadOk = 1;
  $productArr = [];
  $subIndex = "";
  $subCatCounter = 0;
  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
    $cats = GetFile($prodsPath);
    foreach ($cats[0]["options"] as $key => $value) {
      $prods2 = GetFile("../../".$value["json"]);
      foreach ($prods2 as $a => $b) {
        if($subCatCounter == $_GET["arrayIndex"] ){
          $target_dir .= $masterjs[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["href"].$value["href"]."/";
          $prodsPath = "../../".$value["json"];
          $products = GetFile($prodsPath);
        }
        $subCatCounter ++;
        array_push($productArr, $b);
      }
    }
  }
  else{
    $productArr = $products;
  }
  // $replc = ".".pathinfo($target_file,PATHINFO_EXTENSION);
  // $jsString = str_replace($replc,"",str_replace(" ","",$productArr[$_GET["arrayIndex"]]["text"]));
  $textFile = "";
  $jsItem = "";
  var_dump($target_dir);
  var_dump($_GET["typedata"]);
  switch ($_GET["typedata"]) {
    case 'V1':
      $textFile = $productArr[$_GET["arrayIndex"]]["V1"]["text"];
      if ($textFile == "x" || $textFile == "" || $textFile == null){
        $textFile = str_replace(" ","",$productArr[$_GET["arrayIndex"]]["name"]);
        $products[$_GET["arrayIndex"]]["V1"]["text"] = $textFile;
      }
      break;
    case 'V2':
      $textFile = $productArr[$_GET["arrayIndex"]]["V2"]["text"];
      if ($textFile == "x" || $textFile == "" || $textFile == null){
        $textFile = str_replace(" ","",$productArr[$_GET["arrayIndex"]]["name"]);
        $products[$_GET["arrayIndex"]]["V2"]["text"] = $textFile;
      }
      $target_dir.= "V2/";
      break;
    case 'na':
    $textFile = $productArr[$_GET["arrayIndex"]]["text"];
    if ($textFile == "x" || $textFile == "" || $textFile == null){
      $textFile = str_replace(" ","",$productArr[$_GET["arrayIndex"]]["name"]);
      $products[$_GET["arrayIndex"]]["text"] = $textFile;
    }
  }
  $target_file = $target_dir . $textFile . ".txt";
  $newTextString = str_replace('style="','text-edit="',($_POST["txtArea"]));
  $newTextString = str_replace('<em>','',$newTextString);
  if (file_put_contents($target_file,$newTextString )) {
      echo "The file ".$target_file . " has been uploaded.";
      var_dump(file_put_contents($prodsPath,json_encode($products, JSON_PRETTY_PRINT) ));
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
} // end prodtext


function categoryText(){
  $masterjs = GetFile("../../Categories/Categories.json");
  $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $txtPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["text"];
  $txtPathjs = $masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["text"];
  $uploadOk = 1;
  if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
    $cats = GetFile($prodsPath);
    foreach ($cats[0]["options"] as $key => $value) {
      if($_GET["formNum"] == $key){
        $formNum = $_GET["formNum"];
        $txtPath = "../../".$cats[0]["options"][$formNum]["text"];
        $txtPathjs = $cats[0]["options"][$formNum]["text"];
        if (!file_exists($txtPath)){
          $txtPath = DOCROOT."Categories/".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]."/".str_replace(" ","",$value["name"])."_CategoryText.txt";
          $txtPathjs = "Categories/".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]."/".str_replace(" ","",$value["name"])."_CategoryText.txt";
        }
        $cats[0]["options"][$key]["text"] = $txtPathjs;
      }
    }
    var_dump(json_encode($cats,JSON_PRETTY_PRINT));
    file_put_contents($prodsPath, json_encode($cats,JSON_PRETTY_PRINT));
  }
  $newTextString = str_replace('<em>','',$_POST["txtArea"]);
  $newTextString = str_replace('<div>','<p>',$newTextString);
  $newTextString = str_replace('</div>','</p>',$newTextString);
  file_put_contents($txtPath, $newTextString);
}

 ?>
