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
$txtPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["text"];
$uploadOk = 1;
echo "<h3>".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["name"]."</h3>";
echo "<form action='' method='post' id='textForm'> ";
if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
  $subTitle="";
  $cats = GetFile($prodsPath);
  echo "<div id='subCatBtns'>";
  $maintxtbtn ="";
  $btns ="";
  foreach ($cats[0]["options"] as $key => $value) {
    if($_GET["formNum"] == $key){
      $subTitle= "<h4 id='subTitle'>{$value["name"]}</h4>";
      $formNum = $_GET["formNum"];
      $txtPath = "../../".$cats[0]["options"][$formNum]["text"];
      if (!file_exists($txtPath)){
        $txtPath = DOCROOT."Categories/".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]."/".str_replace(" ","",$value["name"])."_CategoryText.txt";
        file_put_contents($txtPath, "");
      }
      $maintxtbtn = "<p class='showTextArea' text-data='-1'>Show {$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["name"]} Text</p>";
    }
    else {
      // $subTxtPath = DOCROOT."Texts/".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["href"]."/".$value["text"];
      $btns .=  "<p class='showTextArea' text-data='{$key}'>Show {$value["name"]} Text</p>";
    }
  }
  echo $maintxtbtn;
  echo $btns;
  echo "</div>";
  echo $subTitle;
}
echo "<button type='button' id='save' text-data='{$_GET["formNum"]}'>save</button>";
echo "<textarea class='productText' style='height:50vh;width: 97vw;' name='txtArea' >".file_get_contents($txtPath)."</textarea>";
echo "</form>";

?>
<script type="text/javascript">
$(document).ready(function() {
  var arrayIndex =  $(".hiddenIndex").text();
  if (arrayIndex === $(".hiddenCount").text()){
    $("#btnLeft").removeClass("hidden");
    $("#btnRight").addClass("hidden");
  }
  $(".content").keyup(function() {
    $("#save").unbind();
    $("#save").click(function(e) {
      e.preventDefault();
      var list = $("select").val();
      if (list === "undefined"){
        list = "&prodList=0&categoryIndex=0";
      }
      $('#textForm').attr("action","scripts/modJsons.php?action=categoryText&formNum="+$("#save").attr("text-data")+list);
      $("#textForm").ajaxSubmit(function (data,stat) {
        console.log(data);
      })
    })
  })
  $(".showTextArea").click(function() {
    var list = $("select").val();
    if (list === "undefined"){
      list = "&prodList=0&categoryIndex=0";
    }
    var btn = $(this);
    $(".content").load("scripts/getCatText.php?"+list+"&formNum="+btn.attr("text-data"),function (data, status) {
      console.log(status);
    });
  })
})
</script>
