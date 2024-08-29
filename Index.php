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
    <div id="header">
            <button class="myButton" id="voltar">i class="bi bi-box-arrow-left"></i></button>
            <h1>Maze Your Way<sup>©</sup></h1>
            <button class="myButton" id="som">i class="bi bi-volume-mute-fill"></i></button>
        </div>
        <div id="options">
            <button class="myButton" id="button1">Jogar</button>
            <button class="myButton" id="button2">Como Jogar</button>
            <button class="myButton" id="button3">Crie um mapa!</button>
            <button class="myButton" id="button4">Classificações</button>
        </div>
        <div id="diftable" class="row">
            <h1 class="mt-5 mb-5" style="font-size: 50px;">Escolha uma dificuldade:</h1>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <div class="card text-bg-success">
                <div class="card-body">
                    <h2 class="card-title text-center">Fácil</h2>
                    <p class="card-text">
                        <ul>
                            <li>Inimigos movem-se lentamente</li>
                            <li>Moedas não são obrigatórias</li>
                        </ul>
                    </p>
                </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-bg-warning text-white">
                <div class="card-body">
                    <h2 class="card-title text-center">Médio</h2>
                    <p class="card-text">
                        <ul>
                            <li>Inimigos movem-se mais rápido</li>
                            <li>Moedas não são obrigatórias</li>
                        </ul>
                    </p>
                </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-bg-danger">
                <div class="card-body">
                    <h2 class="card-title text-center">Difícil</h2>
                    <p class="card-text">
                        <ul>
                            <li>Inimigos movem-se mais rápido</li>
                            <li>Moedas são obrigatórias</li>
                        </ul>
                    </p>
                </div>
                </div>
            </div>
        </div>
    <script src="scriptmaze.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>