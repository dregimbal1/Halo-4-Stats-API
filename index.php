<?php
/* 
	Developed by David Regimbal
*/

#Request Service
include('includes/config.php');
$request = new Request($tokens['spartaToken'], 'xTACTICSx');
#end

// GetGlobalChallenges
$challenges = $request->get('GetGlobalChallenges');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Halo 4 Stats">
    <meta name="author" content="TACTICS">
    <link rel="icon" href="">

    <title>Halo 4 Stats</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/jumbotron/jumbotron.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">HaloStats</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="achievements.php">Achievements</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="jumbotron">
      <div class="container">
        <h1>Halo 4 Stats</h1>
        <p>Try out the new Halo 4 Stats API developed on PHP</p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Retrieve Stats</h2>
          <form role="form" action="record.php" method="GET">
            <div class="form-group">
              <input type="text" placeholder="xTACTICSx" name="gamertag" class="form-control" style="width:250px;">
            </div>
            <button type="submit" class="btn btn-success" style="width:250px;">View Service Record</button>
          </form>
        </div>
<style>
.xp{
	text-align:right;
	float:right;
	font-weight:bold;
}
</style>		
        <div class="col-md-8">

		
	
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active"><a href="#daily" data-toggle="tab">Daily Challenges</a></li>
        <li><a href="#weekly" data-toggle="tab">Weekly Challenges</a></li>
    </ul><br />
    <div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="daily">
		<?php
			foreach( $challenges['Challenges'] as $challenge ){
				if( $challenge->PeriodNamely == "Daily" ){
					echo '
					<div class="panel panel-default">
					  <div class="panel-heading">' . $challenge->Name . '<div class="xp">' . $challenge->XpReward . ' XP</div></div>
					  <div class="panel-body">				
					';
					printf("Type:" .
						   $challenge->CategoryName . "<br />" .
						   $challenge->Description
					);
					echo '
					  </div>
					</div>					
					';
				}
			}
		?>
        </div>
        <div class="tab-pane" id="weekly">
		<?php
			foreach( $challenges['Challenges'] as $challenge ){
				if( $challenge->PeriodNamely == "Weekly" ){
					echo '
					<div class="panel panel-default">
					  <div class="panel-heading">' . $challenge->Name . '<div class="xp">' . $challenge->XpReward . ' XP</div></div>
					  <div class="panel-body">				
					';
					printf("Type:" .
						   $challenge->CategoryName . "<br />" .
						   $challenge->Description
					);
					echo '
					  </div>
					</div>					
					';
				}
			}
		?>
        </div>
    </div>		
		
		
		
		
		
		
		
		
	  </div>
      </div>

      <hr>

      <footer>
        <p>Developed by xTACTICSx</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('#tabs').tab();
		});
	</script>   
  

</body></html>