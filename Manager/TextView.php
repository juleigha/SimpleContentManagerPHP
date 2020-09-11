V1<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TextView</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="css\bootstrp-fontawesome4.7.0.min.css"> -->
    <link rel="stylesheet" href="RichText-master/src/richtext.min.css">
    <script type="text/javascript" src="scripts/jquery3.5.1.min.js"></script>
    <script type="text/javascript" src="RichText-master/src/jquery.richtext.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <style media="screen">

      html {
        padding: 0;
        margin: 0;
        width: 100%;
        height:100%;
      }
      .richText-editor {
        height:65vh !important;
        width:calc(100% - 40px);
      }
      header{
        position: sticky;
        position: -webkit-sticky;
        top:0;
        width: 99%;
        display: inline-block;
        z-index: 11;
        padding: 5px;
      }
      .leftnright{
        width:100%;
      }
      #btnRight {
        float: right;
        font-size: 20px;
        clear: none;
      }
      #btnLeft{
        font-size: 20px;
        clear: none;
      }
      h4 {
        padding-left: 45vw;
        margin-bottom: -30px;
      }
      #prod-drop{
        display: inline-block;
      }
      #hints {
        position: absolute;
        background-color: lightgrey;
        padding: 10px;
      }
      #hints li {
        list-style: none;
        padding: 5px;
        cursor: pointer;
      }
      .BtnOtherType, #save{
        margin:10px;
        margin-left: 50px;
        padding: 3px;
      }
      .hidden {
          visibility: hidden;
          position: absolute;
      }
    </style>
    <script type="text/javascript">
    $(document).ready(function(){
      var arrayIndex = 0;
      $(".hiddenIndex").text(arrayIndex);
      $("select").load("categoryTableServer.php?action=options");
      $(".content").load("scripts/getText.php?action=getText&prodList=0&categoryIndex=0&typedata=V1&arrayIndex="+arrayIndex);

      $("select").change(function() {
        $(".hiddenIndex").text("0");
        $(".content").load("scripts/getText.php?action=getText&arrayIndex=0"+$("select").val());
      })
      $("#btnLeft").click(function(){
        $("#btnRight").removeClass("hidden");
        var arrayIndex = $(".hiddenIndex").text() - 1;
        if (arrayIndex === 0){
          $("#btnLeft").addClass("hidden");
        }
        $(".hiddenIndex").text(arrayIndex);
        $(".content").load("scripts/getText.php?action=getText&arrayIndex="+arrayIndex+$("select").val());
      })
      $("#btnRight").click(function(){
        $("#btnLeft").removeClass("hidden");
        var arrayIndex = parseInt($(".hiddenIndex").text()) + 1;
        arrayIndex +="";
        $(".hiddenIndex").text(arrayIndex);
        if (arrayIndex === $(".hiddenCount").text()){
          $("#btnRight").addClass("hidden");
        }
        $(".content").load("scripts/getText.php?action=getText&arrayIndex="+arrayIndex+$("select").val());
      })
      $("#searchBar").keyup(function() {
        if($("#searchBar").val() === ""){
          $("#hints").addClass("hidden");
        }else{
          $("#hints").removeClass("hidden");
        }
        $.get("scripts/search.php?q="+$("#searchBar").val()+$("select").val(),function (data,stat) {
          $("#hints").html(data);
        })
      })
    })
    </script>
  </head>
  <body>
    <header>
      <p class="hiddenIndex hidden"></p>
      <select name="category" id="category-select">
      </select>
      <div id="prod-drop">
        <input id='searchBar' type="text" name="search" value="" autocomplete="off">
        <div id="hints" class="hidden">
        </div>
      </div>
      <div class="leftnright">
        <button id="btnLeft">&#8678;</button>
        <button id="btnRight">&#8680;</button>
      </div>
    </header>
    <div class="content">
    </div>
  </body>
</html>
