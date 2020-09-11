<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="googlebot" content="noindex">
	<meta name="robots" content="noindex">
    <title><?php echo $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

</head>
<body>
<?php
$imgPath = $url->category->imgPath.$url->firstFolder;
$file = "Texts/".$url->category->link."/";
if($url->product->is404===True){
  include PAGE_NOT_FOUND;
}
else {
	if($url->firstFolder != $url->category->link){
		$file.=$url->firstFolder."/";
	}
	if ($url->product->typeFactor === "v1"){
    $imgPath .= "/v1";
    $file .= "v1/";
  }
  if (!file_exists($file . $url->product->text.".php")){
    $file .= $url->product->text.".txt";
  }
  else{
    $file .= $url->product->text.".php";
  }
  $fullImagePath ="";
  $fileBool = $imgPath.'/'.$url->product->image;
	// var_dump($fileBool);
	if(file_exists($fileBool."png") ){
		$fullImagePath = IMAGES.$imgPath.'/'.$url->product->image.".png";
	}
	elseif(file_exists($fileBool.".PNG") ){
		$fullImagePath = IMAGES.$imgPath.'/'.$url->product->image.".PNG";
	}
	elseif(file_exists($fileBool.".jpg") ){
		$fullImagePath = IMAGES.$imgPath.'/'.$url->product->image.".jpg";
	}
	else {
		$fullImagePath = IMAGES."/noImageAvailable.png";
	}

}

MakeNav(RELATIVE_LOC, $jsFile, "product");
include $url->category->link."/inner.txt";

?>
</body>
</html>
