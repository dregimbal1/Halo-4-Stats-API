<?php
/* 
	Developed by David Regimbal
*/

#Request Service
include('includes/config.php');
$request = new Request($tokens['spartaToken'], 'xTACTICSx');
#end

// GetGameMetadata
$metadata = $request->get('GetGameMetadata');

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
            <li class="active"><a href="achievements.php">Achievements</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
<style>
.xp{
	text-align:right;
	float:right;
	font-weight:bold;
}
</style>	
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
	  <br />
	  <p>
		List of possible achievements in Halo 4. To see your progress check out your profile.
	  </p>
 
		<?php
			foreach( $metadata['AchievementsMetadata']->Achievements->AchievementMetadata as $achievement ){
					echo '
					<div class="panel panel-default">
					  <div class="panel-heading">' . $achievement->Name . '<div class="xp">' . $achievement->GamerPoints . '  Gamer Points</div></div>
					  <div class="panel-body">				
					';
					printf($achievement->LockedDescription);
					echo '
					  </div>
					</div>					
					';
			}
		?>
     
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