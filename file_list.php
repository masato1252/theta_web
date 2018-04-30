<?php
$TITLE = "THETA V";
$PATH = "./";
require_once($PATH."core/metaHeader/common.php");
require_once($PATH."function.php");

$mode = $_GET["mode"];
if($mode=="" || empty($mode)){

}else if($mode==1){
  //削除
  $url = $_GET["url"];

  $data = array(
  'name'=>'camera.delete',
  'parameters'=> array(
      'fileUrls'=> array($url)
  )
);
  $data_json = json_encode($data);
  $result2 = httpPost($baseUrl.'osc/commands/execute', $data_json);

}else if($mode==2){
	//天頂補正
	$url = $_GET["url"];
	$reso = $_GET["reso"];
	if($reso==1){
		//4K
		$size = "3840x1920";
	}else{
		//Full-HD
		$size = "1920x960";
	}

	$url = $_GET["url"];

  	$data = array(
  		'name'=>'camera._convertVideoFormats',
  		'parameters'=> array(
      		'fileUrl'=> $url,
      		'size'=> $size,
      		'projectionType'=> 'Equirectangular',
      		'codec'=> 'H.264/MPEG-4 AVC',
      		'topBottomCorrection'=> 'Apply' 
  		)
	);
  $data_json = json_encode($data);
  $result2 = httpPost($baseUrl.'osc/commands/execute', $data_json);

}

//LIST
$data = array(
  'name'=>'camera.listFiles',
  'parameters'=> array(
    'fileType'=>'all',
    'entryCount'=>50,
    'maxThumbSize'=>400,
    '_sort'=>'newest',
  )
);

$data_json = json_encode($data);


$result = httpPost($baseUrl.'osc/commands/execute', $data_json);

$list = $result["results"]["entries"];

$thumb = "?type=thumb";




function hoseiType($str){
  if(strcmp($str, "Equirectangular")==0){
    return "あり";
  }else if(strcmp($str, "Dual-Fisheye")==0){
    return "なし";
  }else{
    return "不明";
  }
}


?>
<script type="text/javascript" src="<?php printf($PATH); ?>js/vue.min.js"></script>
<script type="text/javascript">

</script>
</head>
<body>
<div class="container-fluid">

  <div v-html="pageHeader"></div>

	<div id="content">
		<div class="row">
      <div class="col-sm-3">
      <?php require_once($PATH."right_menuBar.php"); ?>
      </div>

      <div class="col-sm-9">
      	<br><br>
      	<div class="panel panel-default">
      		<div class="panel-heading">

      		</div>
      		<div class="panel-body">

          <?php
             for($i=0; $i<count($list); $i++){
          ?>
            <div class="row">
              <div class="col-sm-6">
                <?php
                  if($network==1){
                    $fileUrl = $list[$i]["fileUrl"];
                  }else if($network==2){
                    $fileUrl = str_replace($homeUrl, $baseUrl, $list[$i]["fileUrl"]);
                  }
                ?>
                <a href="<?php printf($fileUrl); ?>"><img src="<?php printf($fileUrl.$thumb); ?>" width="430"></a>
              </div><!-- col -->

              <div class="col-sm-6">

                <div class="table-responsive scroll-box">
                  <table class="table table-bordered table-condensed table-striped">
                    <tr>
                        <th colspan="1">項目</th>
                        <th colspan="1">値</th>
                    </tr>
                    <?php
                      printf("<tr>");
                        printf("<td>ファイル名</td>");
                        printf("<td>".$list[$i]["name"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>撮影日時</td>");
                        printf("<td>".$list[$i]["dateTimeZone"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>WIDTH</td>");
                        printf("<td>".$list[$i]["width"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>HEIGHT</td>");
                        printf("<td>".$list[$i]["height"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>天頂補正</td>");
                        printf("<td>".hoseiType($list[$i]["_projectionType"])."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>処理</td>");
                        if(strcmp(hoseiType($list[$i]["_projectionType"]),"あり")==0){
                        	printf("<td><a href='./file_list.php?mode=1&url=".$fileUrl."'>削除</a></td>");
                        }else if(strcmp(hoseiType($list[$i]["_projectionType"]),"なし")==0){
                        	printf("<td>");
                        	printf("[天頂補正]");
                        	printf("<a href='./file_list.php?mode=2&reso=1&url=".$list[$i]["fileUrl"]."'>4K</a>／");
                        	printf("<a href='./file_list.php?mode=2&reso=2&url=".$list[$i]["fileUrl"]."'>full-HD</a>　");
                        	printf("　<a href='./file_list.php?mode=1&url=".$fileUrl."'>削除</a></td>");
                        }
                      printf("</tr>");
                    ?>
                  </table>
                </div><!-- div table -->

              </div><!-- col -->

            </div><!-- row -->
          <?php
            }
          ?>
            <p>CONTROL</p>
            <?php
              echo('<pre>');
              var_dump($result2);
              echo('</pre>');
            ?>
            <p>LIST</p>
            <?php
              echo('<pre>');
              var_dump($result);
              echo('</pre>');
            ?>
			    </div><!-- panel-body -->

      	</div><!-- panel -->

      </div><!-- col -->


    </div><!-- row -->
	</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="test.js"></script>
</body>
</html>