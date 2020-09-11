<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <style media="screen">
    /* * {
      margin: 0;
      padding: 0;
      border: red solid 1pt;
    } */
    header{
      position: sticky;
      position: -webkit-sticky;
      top:0;
      min-width: 99vw;
      display: inline-block;
      background: white;
      z-index: 11;
      padding: 5px;
    }
      td {
        padding: 0;
        margin: 0;
        min-height: 50px;
        border: lightgrey solid 1pt;
      }
      td:nth-child(3){
        min-width: 300px;
      }
      td:nth-child(6){
        min-width: 150px;
      }
      td:nth-child(2) img{
        width: 60px;
        height: 60px;
      }
      td:nth-child(2), td:nth-child(4), td:nth-child(6), td:nth-child(8),td:nth-child(10),td:nth-child(12){
        background-color: lightgrey;
      }
      td:nth-child(3), td:nth-child(5), td:nth-child(7), td:nth-child(9),td:nth-child(11),td:nth-child(13){
        background-color: darkgrey;
      }
      tbody{
        align-items: flex-start;
        min-width: 100%;
      }
      tr{
        width:100%;
        min-height: 50px;
        text-align: left;
      }
      .between{
        height:10px;
      }
      .between > td{
        border:none;
        max-height: 10px !important;
        min-height: 10px !important;
        width: 100% ;
        right:0;
        position:  absolute;
        margin-top: -4px;
      }
      .move {
        cursor: grab;
      }
      td.keywrds {
        border: lightgrey solid 1pt;
        width: 100% ;
        position:  absolute;
        /* background-color: lightgrey; */
      }
      tr.empty {
        height:60px;
        margin-bottom: 10px;
      }
      tr.headerRow >* {
        position: -webkit-sticky;
        position: sticky;
        top:20px;
        z-index: 10;
        height:30px;
        text-align: center;
        padding:5px;
        margin: -5px;
        background-color: lightblue;
      }
      .loading {
        position: fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        text-align: center;
        display: flex;
        vertical-align: middle;
        z-index: 100;
        background-color: lightyellow;
        opacity: .6;
      }
    </style>
    <meta charset="utf-8">
    <title>Category View</title>
    <script src="scripts/jquery3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("select").load("categoryTableServer.php?action=options");
        $("tbody").load("categoryTableServer.php?action=table&prodList=0&categoryIndex=0");
        $("select").change(function() {
          $("tbody").load("categoryTableServer.php?action=table"+$("select").val());
        })
      })
    </script>
  </head>
  <body>
    <header>
      <label for="category">Category:</label>
      <select name="category" id="category-select">

      </select>
    </header>

    <table>
      <tbody>

      </tbody>
    </table>
  </body>
</html>
