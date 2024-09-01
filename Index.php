<!DOCTYPE html >
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Maze Your Way©</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="Index.css">
</head>
<body onkeydown="mover(event);">
        <div id="header">
            <button class="myButton" id="voltar" onclick="goback()"><i class="bi bi-box-arrow-left"></i></button>
                <h1>Maze Your Way<sup>©</sup></h1>
            <button class="myButton" id="som" onclick="sons()"><i class="bi bi-volume-mute-fill"></i></button>
        </div>
        <div id="options">
            <button class="myButton" id="button1" onclick="choosedif()">Jogar</button>
            <button class="myButton" id="button2" onclick="howplay()">Como Jogar</button>
            <button class="myButton" id="button3" onclick="makemap()">Crie um mapa!</button>
            <button class="myButton" id="button4" onclick="records()">Classificações</button>
        </div>
        <div id="diftable" class="row">
            <h1 class="mt-5 mb-5" style="font-size: 50px;">Escolha uma dificuldade:</h1>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <div class="card text-bg-success">
                <div class="card-body">
                    <h2 class="card-title text-center" onclick="geramap(1)">Fácil</h2>
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
                    <h2 class="card-title text-center" onclick="geramap(2)">Médio</h2>
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
                        <h2 class="card-title text-center" onclick="geramap(3)">Difícil</h2>
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
        <div id="tabeladiv"></div>
        <div id="stats">
            <div>
                <h2 id="mapcomplete">Mapa 1/5</h2>
            </div>
            <div>
                <h2>Tempo geral:</h2>
                <p id="tempoall">00:00:00</p>
            </div>
            <div>
                <h2>Tempo mapa atual:</h2>
                <p id="tempomap">00:00:00</p>
            </div>
            <div>
                <h2 id="points">Pontos: 0</h2>
            </div>
        </div>
        <div id="edit">
            <div id="container">
                <h2>Bloco:</h2>
                <img src="coin.png" onclick="troca=4">
                <img src="monster2.png" onclick="troca=5">
                <img src="player.png" onclick="troca=0">
            </div>
            <div id="labels">
                <h2>Legenda:</h2>
                <p id="ncoin">Moedas (x5)</p>
                <p id="nmonsterh">Inimigo (x5)</p>
                <p>Jogador</p>
            </div>
            <div id="container">
                <h2>Bloco:</h2>
                <img src="chao.jpg" onclick="troca=1">
                <img src="parede2.png" onclick="troca=2">
                <img src="end.png" onclick="troca=0">
            </div>
            <div id="labels">
                <h2>Legenda:</h2>
                <p>Chão</p>
                <p>Parede</p>
                <p>Fim</p>
            </div>
        </div>
        <div id="savemap">
            <button class="myButton" id="button5" onclick="savemap()">Salvar mapa</button>
        </div>
        <div id="howto">
            <div id="comojogar">
                <p>Movimente a sua personagem (<img src="player.png">) usando as setas do teclado, de forma a chegar ao final do labirinto (<img src="end.png">).
                    Colete as moedas (<img src="coin.png">) para ganhar pontos e evite os inimigos (<img src="monster1.png">), senão perderá o jogo. Para ganhar, tem de completar 5 mapas diferentes de labirintos!</p>
            </div>
        </div>
        <div id="howto">
            <div id="winner">
                <h2>Parabéns! Ganhou!</h2>
                <p>fsg</p>
            </div>
        </div>
        <div id="howto">
            <div id="loser">
                <h2>Perdeu! Tente novamente!</h2>
                <p>fsg</p>
            </div>
        </div>
    <script src="Index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>