<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="googlebot" content="noindex">
        <meta name="robots" content="noindex">
        <title><?php echo $pageTitle; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
    </head>
    <body>
				<?php
				$jsData = GetFile($url->category->jsonName);
				$href = substr(RELATIVE_LOC, -1) === "/" ? substr(RELATIVE_LOC, 0, -1): RELATIVE_LOC;
				$pageTitle = $url->category->pageTitle;

 switch ($url->firstFolder) {
            case 'ExampleCategory1':
                  echo '<h2>Yayy</h2>';
              break;
            case 'ExampleCategory2':
                echo '<h2>Yayy</h2>';
                break;
            case 'ExampleCategory3':
                echo '<h2>Yayy</h2>';
                  break;
            default:
                  break;
          }
      MakeNav(RELATIVE_LOC, $jsFile, "product");

      switch ($url->firstFolder) {
        case 'Templates':
              echo $url->category->name;
          break;
        case 'PowerPointCountries':
          echo '';
          break;
      }
			if($url->category->V2 === "TRUE"){
				echo '<div class="powerpoint-text">';
				include $url->category->text;
				echo '</div><div class="point-box">';
				$i = 1;
				$divBox ="";
				foreach ($jsData as $value ) {
					$path = str_replace(" ","_",$value["name"]);
          $_wrds = (substr_count($value["name"]," ") + 1) / 2 >= 1 ? floor((substr_count($value["name"]," ") + 1) / 2) : ceil((substr_count($value["name"]," ") + 1) / 2);
          $_wrdPos=0;
          for($stlp=0;$stlp<$_wrds;$stlp++){
            $_wrdPos = strpos($value["name"]," ",$_wrdPos+1);
          }
          if ($_wrdPos){
            $_name = "<strong>".substr($value["name"],0,$_wrdPos)."</strong>".substr($value["name"],$_wrdPos);
          }
          else {
            $_name = "<strong>".$value["name"]."</strong>";
          }
					$divBox .= "<div class='point-box-inner'><h2>".$_name."</h2><div
					>";
					if (array_key_exists("V1",$value)) {
            var_dump("fileBool");  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
						$fullImagePath ="";
						$fileBool = $url->category->imgPath.$url->category->link."/".$value["V1"]["image"];
            if(file_exists($fileBool.".png") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["V1"]["image"].".png";
          	}
          	elseif(file_exists($fileBool.".PNG") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["V1"]["image"].".PNG";
          	}
          	elseif(file_exists($fileBool.".jpg") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["V1"]["image"].".jpg";
          	}
          	else {
          		$fullImagePath = IMAGES."Images/noImageAvailable.png";
          	}

						$divBox .= "<a style='
						background:url({$fullImagePath})
						;background-size: cover;' class='item'";
						$divBox .= "href='{$href}/{$path}=V1'><div class='overlay'><div class='overlay-inner'><h2>V1</h2><p></p></div></div></a>";
						$i+=1;
					}
					if (array_key_exists("V2",$value)) {
						$fullImagePath ="";
						$fileBool = $url->category->imgPath.$url->category->link."/V2/".$value["V2"]["image"];
            // var_dump($fileBool);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
            if(file_exists($fileBool.".png") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/V2/".$value["V2"]["image"].".png";
          	}
          	elseif(file_exists($fileBool.".PNG") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/V2/".$value["V2"]["image"].".PNG";
          	}
          	elseif(file_exists($fileBool.".jpg") ){
          		$fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/V2/".$value["V2"]["image"].".jpg";
          	}
          	else {
          		$fullImagePath = IMAGES."Images/noImageAvailable.png";
          	}
						$divBox .= "<a style='background:url({$fullImagePath});background-size: cover;'
						class='item' href='{$href}/{$path}=V2'><div class='overlay'><div class='overlay-inner'>
						<h2>V2</h2><p></p></div></div></a>";
						$i+=1;
					}
					$divBox .= "</div></div>";


				}
				echo $divBox."</div>";
			}

if ($url->category->V2 === "SUBCATS"){
				echo '<div class="powerpoint-text template-text-banner">
          <div class="template-details-banner">';
				include $url->category->text;
        echo '						</div>
        				</div>
        				<div class="banner-line">';
				$i=1;
				foreach ($jsData[0]["options"] as  $value ) {
					echo '<a href="#link-target'.$i.'" class="target-title1">'
								. $value["name"]
								. '</a>';
                $i++;
				}
				echo '</div>';
				$i=1;
				foreach ($jsData[0]["options"] as  $value ) {
          echo '<div class="description-banner" class="target-title1">
          <div id="link-target'.$i.'" class="target-title">'
          .$value["name"].'</div>';
          include $value["text"];
          echo '</div><br>';
          if ($value["2Versions"] === "TRUE"){
            $href = GetRoot()."/".CURRENT_PHP_FOLDER."/".$value["href"];
            $itemArr = GetFile($value["json"]);
            echo '<div class="point-box">';
    				$divBox ="";
    				foreach ($itemArr as $item ) {
    					$path = str_replace(" ","_",$item["name"]);
              $_wrds = (substr_count($item["name"]," ") + 1) / 2 >= 1 ? floor((substr_count($item["name"]," ") + 1) / 2) : ceil((substr_count($item["name"]," ") + 1) / 2);
              $_wrdPos=0;
              for($stlp=0;$stlp<$_wrds;$stlp++){
                $_wrdPos = strpos($item["name"]," ",$_wrdPos+1);
              }
              if ($_wrdPos){
                $_name = "<strong>".substr($item["name"],0,$_wrdPos)."</strong>".substr($item["name"],$_wrdPos);
              }
              else {
                $_name = "<strong>".$item["name"]."</strong>";
              }
              $divBox .= "<div class='point-box-inner'><h2>".$_name."</h2><div
    					class='img-accordion accordion-direction-horizontal' data-img-accordion-id='90b4283'
    					data-img-accordion-type='on-hover' id='img-accordion-90b4283'>";
    					if (array_key_exists("V1",$item)) {
                // var_dump(IMAGES.$url->category->imgPath.$url->category->link."/".$value["href"]);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
    						$fullImagePath ="";
    						$fileBool = $url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["V1"]["image"];
                // var_dump(file_exists($fileBool.".jpg"));  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
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
              		$fullImagePath = IMAGES."Images/noImageAvailable.png";
              	}

    						$divBox .= "<a style='
    						background:url(".IMAGES."{$fullImagePath})
    						;background-size: cover;' class='item'";
    						$divBox .= "href='{$href}/{$path}=V1'><div class='overlay'><div class='overlay-inner'><h2>V1</h2><p></p></div></div></a>";
    					}
    					if (array_key_exists("V2",$item)) {
    						$fullImagePath ="";
                // var_dump($fileBool);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
                $fileBool = $url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["V2"]["image"];
                if(file_exists($fileBool."png") ){
              		$fullImagePath = $fileBool.".png";
              	}
              	elseif(file_exists($fileBool.".PNG") ){
              		$fullImagePath = $fileBool.".PNG";
              	}
              	elseif(file_exists($fileBool.".jpg") ){
              		$fullImagePath = $fileBool.".jpg";
              	}
              	else {
              		$fullImagePath = IMAGES."Images/noImageAvailable.png";
              	}
    						$divBox .= "<a style='background:url(".IMAGES."{$fullImagePath});background-size: cover;'
    						class='item' href='{$href}/{$path}=V2'><div class='overlay'><div class='overlay-inner'>
    						<h2>V2</h2><p></p></div></div></a>";
    					}
    					$divBox .= "</div></div>";


    				}
    				echo $divBox."</div>";
          }
          else {
            echo '<div class="template-box">';
            $itemArr = GetFile($value["json"]);
            foreach ( $itemArr as $key => $item) {
              $fullImagePath ='';
              $fileBool = $url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["image"];
              // var_dump($fileBool);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
              if(file_exists($fileBool.".png") ){
                $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["image"].".png";
              }
              elseif(file_exists($fileBool.".PNG") ){
                $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["image"].".PNG";
              }
              elseif(file_exists($fileBool.".jpg") ){
                $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$value["href"]."/".$item["image"].".jpg";
              }
              else {
                $fullImagePath = IMAGES."Images/noImageAvailable.png";
              }
              $path = $value["href"]."/".str_replace(" ","_",$item["name"]);
              ?>
              <div>
                <h3><?php echo $item["name"] ?></h3>
                <img src="<?php echo $fullImagePath
                ?>" loading="lazy">
                <a href="<?php echo $path ?>" class="view-btn">
                  <i aria-hidden="true" class="fa fa-eye"></i>
                  View Product

                </a>
              </div>
              <?php
            }
            echo '</div>';
            }
            $i++;
          }
          echo '</div>';
				echo '</div>';
			}
      elseif($url->category->V2 === "FALSE") {
        foreach ($jsData as $key => $item) {
          $fullImagePath ='';
          $fileBool = $url->category->imgPath.$url->category->link."/".$item["image"];
          // var_dump($fileBool);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
          if(file_exists($fileBool.".png") ){
            $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$item["image"].".png";
          }
          elseif(file_exists($fileBool.".PNG") ){
            $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$item["image"].".PNG";
          }
          elseif(file_exists($fileBool.".jpg") ){
            $fullImagePath = IMAGES.$url->category->imgPath.$url->category->link."/".$item["image"].".jpg";
          }
            else {
            $fullImagePath = IMAGES."Images/noImageAvailable.png";
          }
          $path = $url->category->link."/".str_replace(" ","_",$item["name"]);
          // var_dump($path);  ///////////////////////////!!!!!!!!!!REMOVE!!!!!!TODO
          echo "<div>
              <h3>{$item["name"]}</h3>
              <img src='{$fullImagePath}' loading='lazy' style='max-width:200px;'>
              <a href='{$path}' >
                  <i aria-hidden='true' class='fa fa-eye'></i>
                  View Product

              </a>
          </div>";
        }
      }
			 ?>

</body></html>
