<?php
$TITLE = "THETA V";
$PATH = "./";
require_once($PATH."core/metaHeader/common.php");
require_once($PATH."function.php"); //POST/GETの関数など

$result = httpGet($baseUrl.'osc/info');

?>


</script>
</head>
<body>
<div class="container-fluid">
<?php
require_once($PATH."core/pageHeader/common.php");
?>
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
</body>
</html>