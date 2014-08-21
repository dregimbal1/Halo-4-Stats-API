<?php
/* 
	Developed by David Regimbal
*/

#Get Gamertag
$gamertag = $_GET['gamertag'];
#end

if(empty($gamertag)){
	$gamertag = "xTACTICSx";
}

#Request Service
include('includes/config.php');
$request = new Request($tokens['spartaToken'], $gamertag);
#end

if($request == false){
	die();
}


// Display Service Record
$record = $request->get('GetServiceRecord');
// Display Game History
$gameHistory = $request->get('GetGameHistory');
// Display Commendations
$commendations = $request->get('GetCommendations');

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
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="jumbotron" style="
		background-image:url('<?php echo $record['spartanBody']; ?>'),url('<?php echo $request->emblemAsset($record['EmblemImageUrl']->AssetUrl, 120); ?>'); background-repeat:no-repeat,no-repeat;background-position:30% 0px,35% 0px;">
		  <div class="container" style="text-align:right;">
			<h1>
				<?php
					echo $record['Gamertag'] . "<br />";
					echo $record['ServiceTag'];
				?>
			</h1>
		  </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
		
		
		
			<div class="FavWeapon" style="text-align:center;margin:0 auto;">
				<div id="stats" style="font-weight:bold;font-size:25pt;">
					 <?php echo $record['FavoriteWeaponName'] . "<br />"; ?>
				</div>
					<?php echo $request->asset($record['FavoriteWeaponImageUrl']->AssetUrl, 'large') . "<br />"; ?>
				<div id="stats" style="font-weight:bold;font-size:25pt;">
					<?php echo $record['FavoriteWeaponTotalKills'] . "<br />"; ?>
				</div>
				<p id="info" style="font-size:15pt;">
					kills
				</p>
					<?php echo $record['LevelName']; ?>
			</div>

			<div class="panel panel-default" style="background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%); /* IE10+ */
				background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 ); /* IE6-9 */
			">
			  <div class="panel-body">
				<p id="info" style="font-size:15pt;">
					<?php echo $request->rankAsset($record['RankImageUrl']->AssetUrl, 'large'); ?>
					<?php echo $record['Specializations']->Specialization->LevelName; ?>
				</p>
			  </div>
			</div>

        </div>
        <div class="col-md-8">
          <h2></h2>
          <p id="info" style="font-size:15pt;">
			<?php
				echo $record['FavoriteWeaponDescription'];
			?>
		  </p>
       </div>
      </div>

	  
	  
	  
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active"><a href="#history" data-toggle="tab">Game History</a></li>
		<li><a href="#commendations" data-toggle="tab">Commendations</a></li>
    </ul><br />
    <div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="history">
		
			<table class="table">
				<thead>
					<tr>
						<td>Map</td>
						<td>Win/Loss</td>
						<td>Mode</td>
						<td>GameType</td>
						<td>Date</td>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach( $gameHistory['Games']->Game as $game ){
								echo '						
									<tr>
										<td><a href="gameDetails.php?gameid=' . $game->Id . '">' . $game->MapVariantName . '</a></td>
										<td>' . $game->Result . '</td>
										<td>' . $game->ModeName . '</td>
										<td>' . $game->PlayListName . '</td>
										<td>' . date("m/d/Y h:ia", strtotime($game->EndDateUtc)) . '</td>
									</tr>
								
								';
						}
					?>
				</tbody>
			</table>
        </div>
		<div class="tab-pane" id="commendations">
			Coming soon
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
    <script src="bootstrap.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('#tabs').tab();
		});
	</script>  

</body></html>