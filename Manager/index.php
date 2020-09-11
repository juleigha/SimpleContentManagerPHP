<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Manager</title>
    <style media="screen">

      html {
        margin: 0;
        padding: 0;
        height:100vh;
        width:100vw;
      }
      header {
        margin: 0;
        padding: 0;
        /* margin-bottom: calc(5vw * 0.25); */
        width: 100%;
        height: 5vh;
        /* height: calc(5vh + (5vw * 0.25)); */
        align-items: stretch;
        display: flex;
      }
      iframe{
        border: none;
        clear: both;
        width:calc(100% - 10px);
        height:calc(92vh - 10px);
        bottom: 0;
      }
      .hidden {
          visibility: hidden;
          position: absolute;
      }
      .tab{
        background-color: lightgrey;
        border:darkgrey solid 1pt;
        border-bottom: none;
        width: 20vw !important;
        font-size: 20px;
        font-weight: 300;
        font-family: inherit;
        align-content: center;
        text-align: center;
        line-height: 100%;
        flex-grow:1;
      }
      .Title{
        background-color: inherit;
      }

    </style>
    <script src="scripts\jquery3.5.1.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script> -->
    <script type="text/javascript">
      $(document).ready(function(){
        $("#BtnCate").click(function() {
          $("iframe").attr("src","CategoryView.php");
          $("#BtnText").removeClass("hidden");
          $("#BtnDesc").removeClass("hidden");
          $("#BtnCate").addClass("hidden");
          $(".Title").eq(0).removeClass("hidden");
          $(".Title").eq(1).addClass("hidden");
          $(".Title").eq(0).text("Category View");
        })
        $("#BtnText").click(function() {
          $("iframe").attr("src","TextView.php");
          $("#BtnCate").removeClass("hidden");
          $("#BtnDesc").removeClass("hidden");
          $("#BtnText").addClass("hidden");
          $(".Title").eq(1).addClass("hidden");
          $(".Title").eq(0).removeClass("hidden");
          $(".Title").eq(0).text("Text View");
        })
        $("#BtnDesc").click(function() {
          $("iframe").attr("src","DescriptionView.php");
          $("#BtnCate").removeClass("hidden");
          $("#BtnText").removeClass("hidden");
          $("#BtnDesc").addClass("hidden");
          $(".Title").eq(0).addClass("hidden");
          $(".Title").eq(1).removeClass("hidden");
          $(".Title").eq(1).text("Description View");
        })
      })
    </script>
  </head>
  <body>
      <header>
        <button id="BtnCate" class="hidden Btn-main-page tab" name="button">Products By Category</button>
        <div class="Title tab">Category View</div>
        <button id="BtnText"  class="Btn-main-page tab "name="button">Product Text View</button>
        <div class="Title tab hidden"></div>
        <button id="BtnDesc"  class="Btn-main-page tab "name="button">Category Descriptions View</button>
        <!-- <button type="button" class="Btn-main-page"name="button">Products By Missing Info</button> -->
      </header>
      <iframe src="CategoryView.php">Loading, please wait.</iframe>
  </body>
</html>
