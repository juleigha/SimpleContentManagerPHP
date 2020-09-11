<?php
define("CURRENT_PHP_FOLDER", "MainListName.php");
include "rootvars.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// determine page type and save url data
define("RELATIVE_LOC", "{$_SERVER['REQUEST_URI']}");
define("PAGE_NOT_FOUND","404.php");
define("DIFF_FILE_PATH", null);
include 'getRoot.php';

    $jsFile = GetFile("Categories/Categories.json");
    $url = new Url($jsFile);
    $TYPE_OF_PAGE = $url->GetPageType();
    switch ($TYPE_OF_PAGE) {
        case "INNER_DATA":
          $pageTitle = $url->product->itemName;
          include "Categories/InnerData.php";
          break;
        case "LIST_DATA":
          $pageTitle = $url->category->pageTitle;
          include "Categories/ListData.php";
          break;
        default:
          $pageTitle = "Ready Set Present";
          // header("location: ".GetRoot()."/MainListName.php/ExampleCategory1");
          echo "<html>
                  <head>
                    <title>Home</title>
                  </head>
                  <body>
                    <h1>
                    Home or Main List Page
                    </h1>";
                    MakeNav(RELATIVE_LOC, $jsFile, "");
          echo    "</body>
                </html>";
          break;
      }

// CLASSES
class Url
{
    public function __construct($mainJson){
      $firstFolder = strpos(RELATIVE_LOC, CURRENT_PHP_FOLDER);
      $restOfPath = strpos(RELATIVE_LOC, "/", $firstFolder+strlen(CURRENT_PHP_FOLDER))
                   ? strpos(RELATIVE_LOC, "/", $firstFolder+strlen(CURRENT_PHP_FOLDER))+1 : "0" ;
      $firstFolder = substr(RELATIVE_LOC, $firstFolder+strlen(CURRENT_PHP_FOLDER)+1);
      $restOfPath = substr($firstFolder, strpos($firstFolder,"/"));
      $calcPath = $firstFolder;
      $this->firstFolder = substr($firstFolder, 0 , strlen($firstFolder)  - strlen($restOfPath))
                   ? substr($firstFolder, 0 , strlen($firstFolder)  - strlen($restOfPath))
                   : $firstFolder;
      $this->restOfPath = strpos($restOfPath, "/") === 0
                  ? substr($calcPath, strpos($calcPath,"/")+1)
                  : "";
      $this->category = new CategoryInfo($mainJson,$this->firstFolder);
    }
      public function GetPageType(){
        $return;
        if ($this->restOfPath === "") {
          $return = "LANDING_DATA";
        }
        if (strlen($this->firstFolder) > 0){
          $return = "LIST_DATA";
        }
        if (strlen($this->restOfPath) > 0) {
          $return = "INNER_DATA";
          $this->product = new Product($this->restOfPath, $this->category->jsonName);
        }
        return $return;
      }
}

class Product
{

  function __construct($fileName, $json ){
    $categoryItem = GetFile($json);
    $this->is404=True;
    $this->typeFactor = strpos($fileName, "=") ? strtolower(substr($fileName, strpos($fileName, "=")+1)) : False;
    $this->itemName = strpos($fileName, "=") ? substr($fileName, 0, strpos($fileName, "=")) : $fileName;
    $this->itemName = str_replace("_"," ",$this->itemName);
    if ($this->typeFactor === "clean" || $this->typeFactor === "wow"){
      foreach($categoryItem as $item){
        if($item["name"] === $this->itemName){
          $this->other = $item[$this->typeFactor]["other"];
          $this->isbn = $item[$this->typeFactor]["isbn"];
          $this->image = $item[$this->typeFactor]["image"];
          $this->text = $item[$this->typeFactor]["text"];
          $this->price = $item[$this->typeFactor]["price"];
          $this->shareIt = $item[$this->typeFactor]["shareIt"];
          $this->is404 = False;
          break;
        }
      }
    }
    elseif(!$this->typeFactor){
      foreach($categoryItem as $item){
        if($item["name"] === $this->itemName){
          if(array_key_exists("other",$item)){
            $this->other = $item["other"];
          }
          $this->isbn = $item["isbn"];
          $this->image = $item["image"];
          $this->text = $item["text"];
          $this->price = $item["price"];
          $this->shareIt = $item["shareIt"];
          $this->is404 = False;
          break;
        }
      }
    }
  }
}
// represents all the previous category information
class CategoryInfo
{
  public function __construct($info, $currentFolder, $smoke = ""){
    foreach ($info as $category) {
      foreach ($category["options"] as $value) {
        if(array_key_exists("cats",$value)){
          foreach($value["cats"] as $val){
            if($val === $currentFolder){
              $this->category = $value["pageTitle"];
              $this->backLink = $val;
              $this->backBttn = True;
              $this->link = $value["href"];
              $this->text = $value["text"];
              $subList = GetFile($smoke.$value["json"]);
              foreach($subList[0]["options"] as $key){
                if($key["href"]=== $val){
                  $this->name = $key["name"];
                  $this->imgPath = $key["imgPath"];
                  $this->jsonName = $smoke.$key["json"];
                  $this->V2 = $key["V2"];
                  $this->pageTitle = $key["pageTitle"];
                  break;
                }
              }
            }
          }
        }
        if($value["href"] === $currentFolder){
          if(array_key_exists("cats",$value)){
            $this->cats = $value["cats"];
          }
          $this->link = $value["href"];
          $this->text = $value["text"];
          $this->name = $value["name"];
          $this->imgPath = $value["imgPath"];
          $this->jsonName = $smoke.$value["json"];
          $this->V2 = $value["2Versions"];
          $this->pageTitle = $value["pageTitle"];
          break;
        }
      }
    }
  }

}

// global functions
function GetFile($fileName){
  try {
    if(!file_exists($fileName)){
      throw new Exception(PAGE_NOT_FOUND);
    }
    $json = file_get_contents($fileName);
    $jsArray = json_decode($json, true);
    return $jsArray;
  } catch (Exception $e) {
    include $e->getMessage() ;
  }
}
function MakeHeadNav($relLoc, $categories, $class){
  $folder = "";
  if($relLoc !== ""){
    $x =  strpos($relLoc, CURRENT_PHP_FOLDER) + strlen(CURRENT_PHP_FOLDER);
    $folder = strpos($relLoc, "/", $x ) ? substr($relLoc, 0, $x)."/" : "{$relLoc}/" ;
  }
  $i=0;
  foreach ($categories as $category) {
    if($i % 2 == 0) {
      $ulPre = "<div class='list-row'><div><h2>{$category["category"]}</h2><div>";
    }
    else {
      $ulPre = "<div class='mt25'><div><h2>{$category["category"]}</h2><div>";
    }
    $isSelected = "";
    $ulSuf = "' id='{$class}{$i}'>";
    $nav = "";
    foreach ($category["options"] as $sub) {
        $nav .= "<a href='{$folder}{$sub["href"]}'><i class='fa fa-angle-right'></i>{$sub["name"]}</a>";
    }
    echo $ulPre.$nav;
    echo "</ul></div>";
    $i+=1;
  }
}

function MakeNav($relLoc, $categories, $class){
  $folder = "";
  $subFolder = substr($relLoc,strlen($folder));
  if($relLoc !== ""){
    $x =  strpos($relLoc, CURRENT_PHP_FOLDER) + strlen(CURRENT_PHP_FOLDER);
    $folder = strpos($relLoc, "/", $x ) ? substr($relLoc, 0, $x)."/" : "{$relLoc}/" ;
    $subFolder = substr($relLoc,strlen($folder));
  }
  $i=0;
  foreach ($categories as $category) {
    $ulPre = "<div class='list-row'><h2>".strtoupper($category["category"])."</h2><ul>";
    $nav = "";
    foreach ($category["options"] as $sub) {
      if(strpos($subFolder,$sub["href"]) > -1){
        $nav .= "<li><a href='{$folder}{$sub["href"]}' class='active-navlist' >{$sub["name"]}</a></li>";
      }
      else{
        $nav .= "<li><a href='{$folder}{$sub["href"]}'>{$sub["name"]}</a></li>";
      }
    }
    echo $ulPre.$nav;
    echo "</ul></div>";
    $i+=1;
  }
}
?>
