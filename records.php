<!DOCTYPE html >
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Maze Your Way©</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
		require_once("cnfig.php");
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
            window.location.href="index.php";
        }
    </script>
    <div id="header">
		<button class="myButton" id="voltar" style="visibility: visible;" onclick="gobacker()"><i class="bi bi-box-arrow-left"></i></button>
		<h1>Maze Your Way<sup>©</sup></h1>
		<button class="myButton" id="som" onclick="sons()"><i class="bi bi-volume-mute-fill"></i></button>
	</div>
    <div id="recordes" style="display: block;" class="container-fluid w-75 p-0">
		<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if($page==1){echo "active";}?>" id="top10-tab" data-bs-toggle="tab" data-bs-target="#top10-tab-pane" type="button" role="tab" aria-controls="top10-tab-pane" aria-selected="<?php echo $page==1 ?'true':'false'; ?>" onclick="page1.submit();">Top 10</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if($page==2){echo "active";}?>" id="records-tab" data-bs-toggle="tab" data-bs-target="#records-tab-pane" type="button" role="tab" aria-controls="records-tab-pane" aria-selected="<?php echo $page==2 ?'true':'false'; ?>" onclick="page2.submit();">Todos os registos</button>
            </li>
			<li class="nav-item" role="presentation">
                <button class="nav-link <?php if($page==3){echo "active";}?>" id="filters-tab" data-bs-toggle="tab" data-bs-target="#filters-tab-pane" type="button" role="tab" aria-controls="filters-tab-pane" aria-selected="<?php echo $page==3 ?'true':'false'; ?>" onclick="page3.submit();">Filtros</button>
            </li>
        </ul>
		<div class="tab-content" id="MainTabContent">
			<div class="tab-pane fade <?php if($page==1){echo "show active";}?>" id="top10-tab-pane" role="tabpanel" aria-labelledby="top10-tab" tabindex="0">
                <form method="post" name="page1" class="row g-0 align-items-center m-4">
                    <input type="hidden" name="page" value="1">
                    <input hidden type="submit" value="Consultar" name="namesearch">
                </form>
            </div>
            <div class="tab-pane fade <?php if($page==2){echo "show active";}?>" id="records-tab-pane" role="tabpanel" aria-labelledby="records-tab" tabindex="0">
                <form method="post" name="page2" class="row g-0 align-items-center m-4">
                    <input type="hidden" name="page" value="2">
                    <input hidden type="submit" value="Consultar" name="namesearch">
                </form>
            </div>
            <div class="tab-pane fade <?php if($page==3){echo "show active";}?>" id="filters-tab-pane" role="tabpanel" aria-labelledby="filters-tab" tabindex="0">
                <form method="post" class="row g-0 align-items-center m-4">
					<div class="col-md">
						<div class="form-floating">
							<input type="text" class="form-control" id="filternome" name="filternome" placeholder="Nome">
							<label for="filternome">Nome</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-floating">
							<input type="time" class="form-control" id="filtertempo" name="filtertempo" placeholder="Tempo">
							<label for="filtertempo">Tempo</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-floating">
							<input type="number" class="form-control" id="filterscore" name="filterscore" placeholder="Pontos">
							<label for="filterscore">Pontos</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-floating">
							<input type="date" class="form-control" id="filterdate" name="filterdate" placeholder="Data">
							<label for="filterdate">Data</label>
						</div>
					</div>
					<input type="hidden" name="page" value="3">
					<div class="col-md">
						<div class="form-floating">
							<input class="btn btn-info w-100 text-center p-3" type="submit" value="Filtrar" name="filtragem">
						</div>
					</div>
                </form>
            </div>
		</div>
	</div>
    
    <script src="index.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>