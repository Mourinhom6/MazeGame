<!DOCTYPE html >
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Maze Your Way©</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="styling.css">
</head>
<body>
    <?php
		require_once("config.php");
		$ms= new mysqli($bd_host,$bd_user,$bd_password,$bd_database);
		if($ms->connect_error){
			$echo='<h3 class="erro">Error: ('.$ms->connect_errno.') ('.$ms->connect_error.')</h3>';
		}
        if (isset($_POST["page"])){
            $page=$_POST["page"];
        }
        else{
            $page=1;
        }
    ?>
    <script>
        function gobacker(){
            window.location.href="labirinto.php";
        }
    </script>
    <div id="header">
		<button class="myButton" id="voltar" style="visibility: visible;" onclick="gobacker()"><i class="bi bi-box-arrow-left"></i></button>
		<h1>Maze Your Way<sup>©</sup></h1>
		<button class="myButton" id="som" onclick="sons()"><i class="bi bi-volume-mute-fill"></i></button>
	</div>
    <div id="recordes" style="display: block;" class="container-fluid w-75 p-0">
    </div>
    
    <script src="scriptmaze.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>