<?php
function GetImagePath($imgpth, $isV2, $fileName,$crntImgV2){
  $fullImagePath ="";
  $fileBool = "../".$imgpth."/";
  switch ($isV2) {
    case 'TRUE':
      $fileBool.= $crntImgV2.$fileName;
      break;
    case 'FALSE':
      $fileBool.=$fileName;
      break;
    }
    // echo "<tr><td>".$fileBool."</td></tr>";
  if(file_exists($fileBool.".png") ){
    $fullImagePath = $fileBool.".png";
  }
  elseif(file_exists($fileBool.".PNG") ){
    $fullImagePath = $fileBool.".PNG";
  }
  elseif(file_exists($fileBool.".jpg") ){
    $fullImagePath = $fileBool.".jpg";
  }
  else {
    $fullImagePath = IMAGES."noImageAvailable.png";
  }
  return $fullImagePath;
}
$js = GetFile("../Categories/Categories.json");
echo "<tr class='between' tr-data='-1'><td></td></tr>";
$prods = GetFile("../".$js[$categoryIndex]["options"][$prodList]["json"]);
if ($js[$categoryIndex]["options"][$prodList]["2Versions"] === "SUBCATS"){
  foreach ($prods as $x => $y ){
    var_dump($y["options"]);
    foreach ($y["options"] as $f => $p) {
      $prods2 = GetFile("../".$p["json"]);
      if ($p["2Versions"] === "TRUE"){

        $headerStr = "<tr class='headerRow'><th></th><th></th><th>Product</th><th>Type</th><th>Price</th><th>ISBN/SKU</th><th>ItemCode</th>";
        $onlyOne = 1;
        foreach ($prods2 as $a => $b) {
          $otherStr = "";
          $_imgFilePath = GetImagePath($p["imgPath"].$p["href"],$p["2Versions"],$b["V1"]["image"],"");
          if( array_key_exists("other",$b["V1"])){
            foreach ($b["V1"]["other"] as $otherN => $otherVal) {
              if($onlyOne == 1){
                $onlyOne = 0;
                for($lp=0;$lp<= count($b["V1"]["other"]);$lp++){
                  $headerStr.="<th>". array_keys($b["V1"]["other"])[$lp] ."</th>";
                }
                echo $headerStr;
              }
              if (array_keys($b["V1"]["other"])[$otherN] == "keywords"){
                $otherStr.= "";
                // $otherStr.= "</tr><tr><td class='editable' prod-data='V1-other-{$otherN}'>".$otherVal."</td>";
              }elseif (array_keys($b["V1"]["other"])[$otherN] == "fileName"){
                $otherStr.= "<td class='editable' prod-data='V1-other-{$otherN}'>".$otherVal."</td>";
              }else {
                $otherStr.= "<td class='editable' prod-data='V1-other-{$otherN}'>".$otherVal."</td>";
              }
            }
          }
          echo "<tr><td><span class='move' prod-data='{$a}&subcat1={$x}&subcat2={$f}'>move</span></td><td class='prod-img'><img  type-data='V1' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"] ."</td><td>". "V1"."</td><td class='editable' prod-data='V1-price'>". $b["V1"]["price"]."</td><td class='editable' prod-data='V1-isbn'>".$b["V1"]["isbn"]."</td><td class='editable' prod-data='V1-shareIt'>"
          . $b["V1"]["shareIt"]."</td>".$otherStr."</tr>";
          $otherStr = "";
          $_imgFilePath = GetImagePath($p["imgPath"].$p["href"],$p["2Versions"],$b["V2"]["image"],"V2/");
          foreach ($b["V2"]["other"] as $otherN => $otherVal) {
            if($onlyOne == 1){
              $onlyOne = 0;
              for($lp=0;$lp<= count($b["V2"]["other"]);$lp++){
                $headerStr.="<th>". array_keys($b["V2"]["other"])[$lp] ."</th>";
              }
              echo $headerStr;
            }
            if (array_keys($b["V2"]["other"])[$otherN] == "keywords"){
              $otherStr.= "";
            }
            elseif (array_keys($b["V2"]["other"])[$otherN] == "fileName"){
              $otherStr.= "<td class='editable' prod-data='V2-other-{$otherN}'>".$otherVal."</td>";
            }else {
              $otherStr.= "<td class='editable' prod-data='V2-other-{$otherN}'>".$otherVal."</td>";
            }
          }

          echo "<tr><td></td><td class='prod-img'><img type-data='V2' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"]."</td><td>". "V2"."</td><td class='editable' prod-data='V2-price' prod-data='V2-price'>". $b["V2"]["price"]."</td><td class='editable' prod-data='V2-isbn'>".$b["V2"]["isbn"]."</td><td class='editable' prod-data='V2-shareIt'>". $b["V2"]["shareIt"]."</td>".$otherStr."</tr><tr class='between' tr-data='{$a}'><td></td></tr>";

        }



      }
      else {
        $headerStr = "<tr class='headerRow'><th></th><th></th><th>Product</th><th>Type</th><th>Price</th><th>ISBN/SKU</th><th>ItemCode</th>";
        $onlyOne = 1;
        foreach ($prods2 as $a => $b) {
          $otherStr = "";
          $_imgFilePath = GetImagePath($p["imgPath"].$p["href"],$p["2Versions"],$b["image"],"");
          foreach ($b["other"] as $otherN => $otherVal) {
            if($onlyOne == 1){
              $onlyOne = 0;
              for($lp=0;$lp<= count($b["other"]);$lp++){
                $headerStr.="<th>". array_keys($b["other"])[$lp] ."</th>";
              }
              echo $headerStr;
            }
            $otherStr.= "<td class='editable' prod-data='other-{$otherN}'>".$otherVal."</td>";
          }
          echo "<tr><td><span class='move' prod-data='{$a}&subcat1={$x}&subcat2={$f}'>move</span></td><td class='prod-img'><img type-data='na' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"]."</td><td>". "NA"."</td><td class='editable' prod-data='price'>". $b["price"]."</td><td class='editable' prod-data='isbn'>".$b["isbn"]."</td><td class='editable' prod-data='shareIt'>". $b["shareIt"]."</td>".$otherStr."</tr><tr class='between' tr-data='{$a}'><td></td></tr>";

        }
      }
    }
  }
}
elseif ($js[$categoryIndex]["options"][$prodList]["2Versions"] === "TRUE") {
  $headerStr = "<tr class='headerRow'><th></th><th></th><th>Product</th><th>Type</th><th>Price</th><th>ISBN/SKU</th><th>ItemCode</th>";
  $onlyOne = 1;
  foreach ($prods as $a => $b) {
    $otherStr = "";
    $_imgFilePath = GetImagePath($js[$categoryIndex]["options"][$prodList]["imgPath"].$js[$categoryIndex]["options"][$prodList]["href"],$js[$categoryIndex]["options"][$prodList]["2Versions"],$b["V1"]["image"],"");
    foreach ($b["V1"]["other"] as $otherN => $otherVal) {
      if($onlyOne == 1){
        $onlyOne = 0;
        for($lp=0;$lp<= count($b["V1"]["other"]);$lp++){
          $headerStr.="<th>". array_keys($b["V1"]["other"])[$lp] ."</th>";
        }
        echo $headerStr;
      }
      if ($otherN == "keywords"){
      }else {
        $otherStr.= "<td class='editable' prod-data='V1-other-{$otherN}'>".$otherVal."</td>";
      }
    }
    echo "<tr><td><span class='move' prod-data='{$a}'>move</span></td><td class='prod-img'><img type-data='V1' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"]."</td><td>". "V1"."</td><td class='editable' prod-data='V1-price'>". $b["V1"]["price"]."</td><td class='editable' prod-data='V1-isbn'>".$b["V1"]["isbn"]."</td><td class='editable' prod-data='V1-shareIt'>". $b["V1"]["shareIt"]."</td>".$otherStr."</tr>";
    $otherStr = "";
    $_imgFilePath = GetImagePath($js[$categoryIndex]["options"][$prodList]["imgPath"].$js[$categoryIndex]["options"][$prodList]["href"],$js[$categoryIndex]["options"][$prodList]["2Versions"],$b["V2"]["image"],"V2/");
    foreach ($b["V2"]["other"] as $otherN => $otherVal) {
      if($onlyOne == 1){
        $onlyOne = 0;
        for($lp=0;$lp<= count($b["V2"]["other"]);$lp++){
          $headerStr.="<th>". array_keys($b["V2"]["other"])[$lp] ."</th>";
        }
        echo $headerStr;
      }
      if ($otherN == "keywords"){
        $otherStr.= "</tr><tr><td class='keywrds editable' prod-data='V2-other-{$otherN}'><b>Keywords:</b>".$otherVal."<tr class='empty'></tr></td>";
      }else {
        $otherStr.= "<td class='editable' prod-data='V2-other-{$otherN}'>".$otherVal."</td>";
      }
    }
    echo "<tr><td></td><td class='prod-img'><img  type-data='V2' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"]."</td><td>". "V2"."</td><td class='editable' prod-data='V2-price'>". $b["V2"]["price"]."</td><td class='editable' prod-data='V2-isbn'>".$b["V2"]["isbn"]."</td><td class='editable' prod-data='V2-shareIt'>". $b["V2"]["shareIt"]."</td>".$otherStr."</tr><tr class='between' tr-data='{$a}'><td></td></tr>";

  }
}
else {
  $headerStr = "<tr class='headerRow'><th></th><th></th><th>Product</th><th>Type</th><th>Price</th><th>ISBN/SKU</th><th>ItemCode</th>";
  $onlyOne = 1;
  foreach ($prods as $a => $b) {
    $otherStr = "";
    $_imgFilePath = GetImagePath($js[$categoryIndex]["options"][$prodList]["imgPath"].$js[$categoryIndex]["options"][$prodList]["href"],$js[$categoryIndex]["options"][$prodList]["2Versions"],$b["image"],"");
    foreach ($b["other"] as $otherN => $otherVal) {
      if($onlyOne == 1){
        $onlyOne = 0;
        for($lp=0;$lp<= count($b["other"]);$lp++){
          $headerStr.="<th>". array_keys($b["other"])[$lp] ."</th>";
        }
        echo $headerStr;
      }
      $otherStr.= "<td class='editable' prod-data='other-{$otherN}'>".$otherVal."</td>";
    }
    echo "<tr><td><span class='move' prod-data='{$a}'>move</span></td><td class='prod-img'><img type-data='na' src='".$_imgFilePath."'></td><td class='editable' prod-data='name'>".$b["name"] . "<td>NA</td><td class='editable' prod-data='price'>". $b["price"]."</td><td class='editable' prod-data='isbn'>".$b["isbn"]."</td><td class='editable' prod-data='shareIt'>". $b["shareIt"]."</td>".$otherStr."</tr><tr class='between' tr-data='{$a}'><td></td></tr>";

  }
}
?>
<script type="text/javascript">
$(document).ready(function() {
  // $("td").css("width","")
  var dragging = false;
  var editing = false;
  var editingElem = null;
  var movingElemIndex = -1;
  $(".move").mousedown(function() {
    if (dragging === true){
      StopDrag();
    }
    else{
      $("html").css({"cursor":"grabbing","cursor":"-webkit-grabbing","-moz-user-select": "none","-ms-user-select": "none","user-select": "none"});
      movingElemIndex = $(this).attr("prod-data");
      $(".between > td").css("background-color","blue");
      $(".between > td").mouseup(function () {
        console.log($(this).parent().attr("tr-data"));
        $.get("scripts/modJsons.php?action=move&from="+movingElemIndex+"&to="+$(this).parent().attr("tr-data")+$("select").val(), function(data,status) {
          console.log(data, status);
        });
        $("tbody").load("categoryTableServer.php?action=table"+$("select").val());
        StopDrag();
      })
    }
  })//end move
  $(".editable").dblclick(function() {
    var tdEdit = $(this);
    if (editing === true){
      // $("tbody").load("categoryTableServer.php?action=table"+$("select").val());
      editingElem.css("background-color","lightyellow");
    }
    else {
      editing = true;
      editingElem = $(this);
      tdEdit.focus();
      tdEdit.attr("contentEditable","true");
      var span = $(this).parent().find("span").length == 1 ? $(this).parent().find("span") : $(this).parent().prev("tr").find("span");
      $("html").keydown(function(e) {
        if (e.key === "Enter"){
          e.preventDefault();
          tdEdit.attr("contentEditable","false");
          $("html").unbind();
          $.get("scripts/modJsons.php?action=edit&focused="+span.attr("prod-data")+$("select").val() + "&index="+tdEdit.attr("prod-data")+"&txtval="+tdEdit.text().replace("#","POUNDSIGN").replace("&","ANDSIGN"), function(data,status) {
            Reset();
          });
        }
      })
    }
  }) // end edit
  $(".prod-img").dblclick(function() {
    $("#img-form").remove();
    var td = $(this);
    var span = $(this).parent().find("span").length == 1 ? $(this).parent().find("span") : $(this).parent().prev("tr").find("span");
    var tdAction = td.siblings().find("span").attr("prod-data");
    if (td.children("img").attr("type-data") === "V2"){
      tdAction = td.parent().prev().find("span").attr("prod-data");
    }
    td.append('<form id="img-form" action="" method="post" enctype="multipart/form-data">  <input type="file" name="fileToUpload" id="fileToUpload">  <input id="newPicSubmit" type="button" value="update" name="submit"><p id="statusP"></p></form>'); //action:  scripts/modJsons.php?action=upload&focused='+span.attr("prod-data")+$("select").val() +"&typedata="+td.children("img").attr("type-data")+'
    $("#newPicSubmit").click(function() {
      $("#img-form").ajaxSubmit(function (data,stat) {
        if(data.indexOf("Sorry") > -1 || data.indexOf("unique") > -1){
          console.log(data, status);
          $("#statusP").text(data);
        }else {
          $("#newPicSubmit").unbind();
          $("#img-form").remove();
          $("tbody").load("categoryTableServer.php?action=table"+$("select").val());
        }
      });
    })
  })
  $(document).keydown(function(e) {
    if(e.key === "Escape") {
      var a = 0;
      a += 1;
      console.log(a);
      e.preventDefault();
      Reset();
    }
  })
  function StopDrag() {
    dragging = false;
    $("html").css("cursor","default");
    $("html").css({"-moz-user-select": "default","-ms-user-select": "default","user-select": "default"});
    $(".between > td").css("background-color","inherit");
    $(".between > td").unbind();
    movingElemIndex = -1;
  }
  function Reset(){
    var y= window.pageYOffset;
    // console.log(x);
    // var x=14;
    $(document).unbind();
    $("tbody").append("<div class='loading'> Loading please wait</div>");
    $("tbody").load("categoryTableServer.php?action=table"+$("select").val());
  }
})
</script>
