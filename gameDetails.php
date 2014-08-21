<?php
/* 
	Developed by David Regimbal (aka TACTICS)
	
*/

#Get Gamertag
$gameid = $_GET['gameid'];
#end

if(empty($gameid)){
	die();
}

#Request Service
include('config.php');
$request = new Request($tokens['spartaToken'], $gamertag);
#end

if($request == false){
	die();
}


// Display Game Details
$details = $request->get('GetGameDetails', $gameid);
$details = $details['Game'];

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
	
	
<style>
.circleBase {
    border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
}

.circle {
    width: 125px;
    height: 125px;
    background: aqua;
    border: 5px solid blue;
}
</style>
    <div class="jumbotron" style="
		background-image:url('<?php echo $request->mapAsset($details->MapImageUrl->AssetUrl, "large"); ?>'); background-repeat:no-repeat;background-position:center;background-size: 1170px 450px;height:425px;">
		  <div class="container" style="text-align:right;">
			<h1>
			
	
			</h1>
		  </div>
    </div>

    <div class="container">

      <div class="row">

		<?php var_dump($details); ?>

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

</body></html>