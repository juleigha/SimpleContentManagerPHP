<?php
include "rootvars.php";
function GetFile($fileName){
  try {
    if(!file_exists($fileName)){
      throw new Exception("PAGE_NOT_FOUND");
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
$subCatCounter = 0;
if($masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["2Versions"] === "SUBCATS"){
  $prodsPath = "../../".$masterjs[$_GET["categoryIndex"]]["options"][$_GET["prodList"]]["json"];
  $cats = GetFile($prodsPath);
  foreach ($cats[0]["options"] as $key => $value) {
    $products = GetFile("../../".$value["json"]);
    foreach ($products as $a => $b) {
      array_push($productArr, $b);
      if($subCatCounter == $_GET["arrayIndex"] ){
        $target_dir .= $masterjs[$_GET["subcat1"]]["options"][$_GET["subcat2"]]["href"].$value["href"];
      }
      $subCatCounter ++;
    }
  }
}
else{
  $productArr = $products;
}
?>
<script type="text/javascript">
$(document).ready(function() {
  $("#searchBar").val("");
  $("#hints").addClass("hidden");
  $("#hints").html("");
//   $(".productText").richText({
//     fonts:false,
//     fontColor: false
// });
  var arrayIndex =  parseInt($(".hiddenIndex").text());
  if (arrayIndex  === parseInt($(".hiddenCount").text()) - 1){
    $("#btnLeft").removeClass("hidden");
    $("#btnRight").addClass("hidden");
  }
  else if (arrayIndex === 0){
    $("#btnRight").removeClass("hidden");
    $("#btnLeft").addClass("hidden");
  }
  else {
    $("#btnRight").removeClass("hidden");
    $("#btnLeft").removeClass("hidden");
  }
  $("#seeV2").click(function() {
    var list = $("select").val();
    if (list === "undefined"){
      list = "&prodList=0&categoryIndex=0";
    }
    $(".content").load("scripts/getText.php?action=getText"+list+"&arrayIndex="+arrayIndex+"&typedata=V2");
  })
  $("#seeV1").click(function() {
    var list = $("select").val();
    if (list === "undefined"){
      list = "&prodList=0&categoryIndex=0";
    }
    // $(".content").load("scripts/getText.php.php?action=getText&prodList=0&categoryIndex=0&typedata=V1&arrayIndex="+arrayIndex);
    $(".content").load("scripts/getText.php?action=getText"+list+"&arrayIndex="+arrayIndex+"&typedata=V1");
  })
  $(".content").keyup(function() {
    $("#save").unbind();
    $("#save").click(function() {
      var list = $("select").val();
      if (list === "undefined"){
        list = "&prodList=0&categoryIndex=0";
      }
      // $("[name=txtArea]").html($(".richText-editor").html());
      $('#textForm').attr("action","scripts/modJsons.php?action=productText"+list+"&arrayIndex="+arrayIndex+"&typedata="+$("#save").attr("data-attr"));
      $("#textForm").ajaxSubmit(function (data,stat) {
        console.log(data);
      })
    })
  })
})
</script>
<?php

echo "<h4>".$productArr[$_GET["arrayIndex"]]["name"]."</h4>";
echo '<p class="hiddenCount hidden">'.count($productArr).'</p>';
var_dump(count($productArr));
  switch ($_GET["typedata"]) {
    case 'V1':
    echo "<button class='BtnOtherType' id='seeV2'>view V2 product</button>";
    echo "<button data-attr='V1' id='save'>save</button>";
    $textFile = $productArr[$_GET["arrayIndex"]]["V1"]["text"];
    break;
    case 'V2':
    echo "<button class='BtnOtherType' id='seeV1'>view V1 product</button>";
    echo "<button data-attr='V2' id='save'>save</button>";
    $textFile = $productArr[$_GET["arrayIndex"]]["V2"]["text"];
    $target_dir.= "V2/";
    break;
    case 'na':
    echo "<button data-attr='na' id='save'>save</button>";
    $textFile = $productArr[$_GET["arrayIndex"]]["text"];
  }


echo "<form action='' method='post' id='textForm'> ";
if ($textFile == "x" || $textFile == ""){
  $textFile = str_replace(" ","",$productArr[$_GET["arrayIndex"]]["name"]);
}
$target_file = $target_dir ."/". $textFile . ".txt";
if(file_exists($target_file)){
  echo "<textarea class='productText' style='height:50vh;width: 97vw;' name='txtArea' >".file_get_contents($target_file)."</textarea>";
}else if (is_dir($target_dir)){
  file_put_contents($target_file,"");
  echo "<textarea class='productText' style='height:50vh;width: 97vw;' name='txtArea' ></textarea>";
}
else{
  mkdir($target_dir, 0777, true);
  file_put_contents($target_file,"");
  echo "<textarea class='productText' style='height:50vh;width: 97vw;' name='txtArea' ></textarea>";
}
echo "</form> <div id='divToUpdate'></div>";

?>
