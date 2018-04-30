<?php
$TITLE = "THETA V";
$PATH = "./";
require_once($PATH."core/metaHeader/common.php");
require_once($PATH."function.php");

$mode = $_GET["mode"];

if($mode=="" || empty($mode)){

}else if($mode==1){

  $data = array(
    "name"=>"camera.takePicture"
  );
  $data_json = json_encode($data);
  $result2 = httpPost($baseUrl.'osc/commands/execute', $data_json);

}else if($mode==2){

  $data = array(
    "name"=>"camera.startCapture"
  );
  $data_json = json_encode($data);
  $result2 = httpPost($baseUrl.'osc/commands/execute', $data_json);

}else if($mode==3){

  $data = array(
    "name"=>"camera.stopCapture"
  );
  $data_json = json_encode($data);
  $result2 = httpPost($baseUrl.'osc/commands/execute', $data_json);
}

$data = array();
$data_json = json_encode($data);

$result = httpPost($baseUrl.'osc/state', $data_json);


function statusStr($str){
  if(strcmp($str, "idle")==0){
    return "待機中";
  }else if(strcmp($str, "shooting")==0 || strcmp($str, "bracket shooting")==0){
    return "撮影中";
  }else if(strcmp($str, "self-timer countdown")==0){
    return "ｾﾙﾌﾀｲﾏｰ起動中";
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

      <div class="col-sm-8">
      	<br><br>
      	<div class="panel panel-default">
      		<div class="panel-heading">

      		</div>
      		<div class="panel-body">

          <a href="./control.php">状態更新</a>
            <div class="table-responsive scroll-box">
              <table class="table table-bordered table-condensed table-striped">
                <tr>
                    <th colspan="1">項目</th>
                    <th colspan="1">値</th>
                </tr>
                <?php
                      printf("<tr>");
                        printf("<td>状態ID</td>");
                        printf("<td>".$result["fingerprint"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>ステータス</td>");
                        printf("<td>".statusStr($result["state"]["_captureStatus"])."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>バッテリー残量</td>");
                        printf("<td>".$result["state"]["batteryLevel"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>充電状況</td>");
                        printf("<td>".$result["state"]["_batteryState"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>撮影経過時間</td>");
                        printf("<td>".$result["state"]["_recordedTime"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>撮影可能時間</td>");
                        printf("<td>".$result["state"]["_recordableTime"]."</td>");
                      printf("</tr>");
                      printf("<tr>");
                        printf("<td>最終保存ファイル</td>");

                        $tmp = explode("/", $result["state"]["_latestFileUrl"]);
                        if($network==1){
                          $fileUrl = $result["state"]["_latestFileUrl"];
                        }else if($network==2){
                          $fileUrl = str_replace($homeUrl, $baseUrl, $result["state"]["_latestFileUrl"]);
                        }
                        printf("<td><a href='".$fileUrl."'>".$tmp[(count($tmp)-1)]."</a></td>");
                      printf("</tr>");
                ?>
              </table>
            </div><!-- div table -->

            <p>静止画モードの時</p>
            <h3><a href="./control.php?mode=1">静止画撮影</a></h3><br>

            <p>動画モードの時</p>
            <h3><a href="./control.php?mode=2">撮影開始</a>　／　<a href="./control.php?mode=3">撮影停止</a></h3>
            
            <br><br><br>
            <p>CONTROL</p>
            <?php
              echo('<pre>');
              var_dump($result2);
              echo('</pre>');
            ?>
            <p>STATE</p>
            <?php
              echo('<pre>');
              var_dump($result);
              echo('</pre>');
            ?>
			    </div><!-- panel-body -->

      	</div><!-- panel -->

      </div><!-- col -->

      <div class="col-sm-1">

      </div>

    </div><!-- row -->
	</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="test.js"></script>
</body>
</html>