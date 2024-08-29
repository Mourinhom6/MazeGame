<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root{
            --bs-body-bg: #ffca9b;
            --bs-link-color: black;
            --bs-link-hover-color: white;
            --bs-border-color: #a14c00;
        }
        .nav-tabs{
            --bs-nav-tabs-link-active-bg: #ffe8d4 !important; 
        }
        .border-primary{
            border-color: #cd853f !important;
            background-color: #ffe8d4 !important;
        }
        .dropdown-menu {
            --bs-dropdown-link-active-bg: #ffe8d4 !important;
            --bs-dropdown-link-active-color: black !important;
        }
        .fabutton{
            background-color: transparent;
            border: none;
        }
        input{
            background-color: transparent;
            border: none;
            padding: 0px;
        }
        .erro{
            background-color:red;
            color:white;
            width:100%;
            padding:20px;
            text-align:center;
        }
        .sucesso{
            background-color:green;
            color: white;
            width:100%;
            padding:20px;
            text-align:center;
        }
        * { 
            -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box;    /* Firefox, other Gecko */
            box-sizing: border-box;         /* Opera/IE 8+ */
        }
        fieldset {
            float: left;
            margin: auto;
        }
        label {
            width: 100px;
            text-align: right;
            display: inline-block;
        }
        input, select {
            width: 300px;
        }
        .buttons {
            margin: 5px 105px;
        }
        table {
            float: left;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }	
        th {
            height: 50px;
            text-align: left;
        }
        td {
            padding: 15px;
            height: 50px;
            vertical-align: bottom;
        }
        .alert {
            font-size: 120%;
            text-align: center;
            color: white;
            width: 100%;
            border: 1px solid #e84e4f;
            background: #9c2b2e;
        }
    </style>
</head>
<body>
    <?php
        $msg=$namesearch="";
        $existe=false;
        require_once("config.php");
        $ms= new mysqli($bd_host,$bd_user,$bd_password,$bd_database);
        if($ms->connect_error){
            $echo='<h3 class="erro">Error: ('.$ms->connect_errno.') ('.$ms->connect_error.')</h3>';
        }
        if (isset($_POST["Login"]) && isset($_POST["password"])  && isset($_POST["username"])) {
            $verif = "select * FROM a16078_users WHERE username=?";
            $statement = $ms->prepare($verif);
            $statement->bind_param('s',$_POST["username"]);
            $statement->execute();
            $statement->bind_result($userid,$username,$phash,$admin);
            if ($statement->fetch()) {
                if (password_verify($_POST['password'], $phash)) {
                    $existe=true;
                    $_SESSION["userid"] = $userid;
                    $_SESSION["username"] = $username;
                    $_SESSION["admin"] = $admin;
                    $_SESSION["id"] = session_id();
                    echo "<div class='sucesso'>Bem vindo, ".$_SESSION["username"]."!</div>";
                }
                else{
                    echo "<div class='erro'>Login Inválido!</div>";
                }
            }
            else {
                echo "<div class='erro'>Login Inválido!</div>";
            }
            $statement->close();   
        }
        if(isset($_POST['Register'])){
            if(isset($_POST["username"]) && isset($_POST["password"])){
                if($_POST["username"]=="" || $_POST["password"]==""){
                    $msg='<h3 class="erro">Preencha todos os campos!</h3>';
                }
                else{
                    $admins="insert into a16078_users(username,password,admin) values(?,?,1)";
                    $ordem=$ms->prepare($admins);
                    $phash=password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $ordem->bind_param("ss",$_POST["username"],$phash);
                    if($ordem->execute() && $ordem->affected_rows>0){
                        $msg='<h3 class="sucesso">O contacto foi inserido!</h3>';
                    }
                    else{
                        $msg='<h3 class="erro">Error: '.'('.$ms->connect_errno.')'.'('.$ms->connect_error.')</h3>';
                    }
                    $ordem->close();
                }
            }
            else{
                $msg='<h3 class="erro">Preencha todos os campos!</h3>';
            }
        }
        if (isset($_POST["end"])){
            $_SESSION["userid"]=$_SESSION["username"]=$_SESSION["admin"]=$_SESSION["id"]="";
            $existe=false;
            // remove all session variables
            session_unset();
            // destroy the session
            session_destroy();
        }
        // $mainpage=$page="";
        if (isset($_POST["mainpage"])){
            $mainpage=$_POST["mainpage"];
        }
        else{
            $mainpage=1;
        }
        if (isset($_POST["page"])){
            $page=$_POST["page"];
        }
        else{
            if($mainpage==1){
                $page=1;
            }
            else{
                $page=3;
            }
        }
        // Add Change and Delete Logic
        if(isset($_POST["altera"])){
            if(isset($_POST["iduser"])){
                $qr = "update a16078_users set username=?, admin=? where iduser=?";
                $ordem = $ms->prepare($qr);
                $ordem->bind_param("sii", $_POST["username"], $_POST["admin"], $_POST["iduser"]); 
                if ($ordem->execute() && $ordem->affected_rows > 0){
                    echo "<script>window.location.href='backoffice.php'</script>";
                }
                else{
                    echo "Erro";
                }
            }
            else{
                if(isset($_POST["codreg"])){
                    $qr = "update a16078_recordes set nome=?, tempo=?, score=? where codreg=?";
                    $ordem = $ms->prepare($qr);
                    $ordem->bind_param("ssii", $_POST["nome"], $_POST["tempo"], $_POST["score"], $_POST["codreg"]); 
                    if ($ordem->execute() && $ordem->affected_rows > 0){
                        echo "<script>window.location.href='backoffice.php'</script>";
                    }
                    else{
                        echo "Erro";
                    }
                }
            }
            $ordem->close();
        }
        else{
            if(isset($_POST["elimina"])){
                if(isset($_POST["iduser"])){
                    $qr = "delete from a16078_users where iduser=?";
                    $ordem = $ms->prepare($qr);
                    $ordem->bind_param("i", $_POST["iduser"]); 
                    if ($ordem->execute() && $ordem->affected_rows > 0){
                        echo "<script>window.location.href='backoffice.php'</script>";
                    }
                    else{
                        echo "Erro";
                    }
                }
                else{
                    if(isset($_POST["codreg"])){
                        $qr = "delete from a16078_recordes where codreg=?";
                        $ordem = $ms->prepare($qr);
                        $ordem->bind_param("i", $_POST["codreg"]); 
                        if ($ordem->execute() && $ordem->affected_rows > 0){
                            echo "<script>window.location.href='backoffice.php'</script>";
                        }
                        else{
                            echo "Erro";
                        }
                    }
                }
                $ordem->close();
            }
        }
        ?>
        <div class="container-fluid w-100 pt-3 pb-2 p-0 d-flex justify-content-between" style="background-color: #cd853f;">
            <button id="submit" class="btn btn-danger m-4 fs-3 invisible" name="balancer" value="dontwork"><i class="bi bi-box-arrow-left"></i> Sair</button>
            <h1 class="text-center m-4 w-75">Maze Your Way<sup>©</sup>'s Back-Office</h1>
            <form method="post">
                <button id="submit" class="btn btn-danger m-4 fs-3" name="end" value="end"><i class="bi bi-box-arrow-left"></i> Sair</button>
            </form>
        </div>
        <?php
            if (!isset($_SESSION['id']) || $_SESSION['id']!=session_id())  {
                ?>
                <div class="w-25 d-flex justify-content-center flex-column m-auto mt-5 p-5 border border-3 border-primary rounded-4" >
                    <div>
                        <h2 class="text-center mb-4">Login</h2>
                    </div>
                    <div>
                        <form name="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Alberto">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mt-4 row">
                                <div class="col">
                                    <input class="btn btn-info w-100 text-center " type="submit" value="Entrar" name="Login">
                                </div>
                                <div class="col">
                                    <input class="btn btn-info w-100 text-center" type="submit" value="Registar" name="Register">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            <?php
            }
            else{
                if ($_SESSION["admin"]==1) {
            ?>
    <div class="container-fluid w-100 p-0">
        <ul class="nav nav-tabs nav-fill" id="myTab1" role="tablist">
            <li class="nav-item" role="presentation">
                <!-- Admins Registados  -->
                <button class="nav-link <?php if($mainpage==1){echo "active";}?>" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-tab-pane" type="button" role="tab" aria-controls="users-tab-pane" aria-selected="<?php echo $mainpage==1 ?'true':'false'; ?>">Utilizadores Registados</button>
            </li>
            <li class="nav-item" role="presentation">
                 <!-- Registos do Jogo  -->
                <button class="nav-link <?php if($mainpage==2){echo "active";}?>" id="records-tab" data-bs-toggle="tab" data-bs-target="#records-tab-pane" type="button" role="tab" aria-controls="records-tab-pane" aria-selected="<?php echo $mainpage==2 ?'true':'false'; ?>">Histórico de Partidas</button>
            </li>
        </ul>
        <div class="tab-content" id="MainTabContent">
            <div class="tab-pane fade <?php if($mainpage==1){echo "show active";}?>" id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="0">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    <!-- Ver -->
                    <li class="nav-item" style="width:33%;" role="presentation">
                        <button class="nav-link <?php if($page==1){echo "active";}?> w-100" id="geral-tab" data-bs-toggle="tab" data-bs-target="#geral-tab-pane" type="button" role="tab" aria-controls="geral-tab-pane" aria-selected="<?php echo $page!=1 ?'false':'true'; ?>" onclick="page1.submit();">Vista Geral</button>
                    </li>
                      <!-- Cosultar-->
                    <div class="dropdown" style="width:33%;">
                        <button class="btn dropdown-toggle w-100 <?php if($page==2){echo "active";}?>" type="button" id="consulta-dropdown1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php echo $page==2 ?'true':'false'; ?>">
                            Consulta
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="consulta-dropdown1" id="consulta-tab-pane1">
                            <button class="dropdown-item w-100" type="button" id="usersearch-tab" data-bs-toggle="tab" data-bs-target="#usersearch-tab-pane" aria-controls="usersearch-tab-pane">por nome</button>
                        </div>
                    </div>
                     <!-- Filtrar-->
                    <div class="dropdown" style="width:33%;">
                        <button class="btn dropdown-toggle w-100 <?php if($page>=7 && $page<=10){echo "active";}?>" type="button" id="consulta-dropdown2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php echo ($page>=7 && $page<=10) ?'true':'false'; ?>">
                            Filtragem
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="consulta-dropdown2" id="consulta-tab-pane2">
                            <button class="dropdown-item w-100" type="button" id="usersort-tab" data-bs-toggle="tab" data-bs-target="#usersort-tab-pane" aria-controls="usersort-tab-pane">Ordenar por nome</button>
                            <button class="dropdown-item w-100" type="button" id="adminsort-tab" data-bs-toggle="tab" data-bs-target="#adminsort-tab-pane" aria-controls="adminsort-tab-pane">Administradores/Não Administradores</button>
                        </div>
                    </div>
                </ul>
                <div class="tab-content" id="UsersTabContent">
                    <div class="tab-pane fade <?php if($page==1){echo "show active";}?>" id="geral-tab-pane" role="tabpanel" aria-labelledby="geral-tab" tabindex="1">
                        <form method="post" name="page1" class="row g-0 align-items-center m-4">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="mainpage" value="1">
                            <input hidden type="submit" value="Consultar" name="namesearch">
                        </form>
                        <?php
                            $totalusers= "select * from a16078_users";
                            $results= $ms->prepare($totalusers);
                            $results->execute();
                            $results->bind_result($iduser,$username, $password, $admin);
                            echo '<table class="table table-secondary table-striped table-hover">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                            echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                            echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                            echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody class="table-group-divider">';
                            while($results->fetch()){
                                echo '<tr><td colspan="4">';
                                echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                echo '</form>';
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            $results->close();
                        ?>
                    </div>
                    <div class="tab-pane fade <?php if($page==2){echo "show active";}?>" id="usersearch-tab-pane" role="tabpanel" aria-labelledby="usersearch-tab" tabindex="1">
                        <form method="post" class="row g-0 align-items-center m-4">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nameuser" name="nameuser" placeholder="Nome">
                                    <label for="nameuser">Nome</label>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="2">
                            <input type="hidden" name="mainpage" value="1">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input class="btn btn-info w-100 text-center p-3" type="submit" value="Consultar" name="usersearch">
                                </div>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['usersearch'])){
                                $nomeusers= "select * from a16078_users where username=?";
                                $statement= $ms->prepare($nomeusers);
                                $statement->bind_param('s',$_POST['nameuser']);
                                $statement->execute();
                                $statement->bind_result($iduser,$username, $password, $admin);
                                echo '<table class="table table-secondary table-striped table-hover">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                                echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                                echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                                echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="table-group-divider">';
                                while($statement->fetch()){
                                    echo '<tr><td colspan="4">';
                                    echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                    echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                    echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                    echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                    echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                    echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                    echo '</form>';
                                    echo '</td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                $statement->close();
                            }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="usersort-tab-pane" role="tabpanel" aria-labelledby="usersort-tab" tabindex="1">
                        <ul class="nav nav-tabs nav-fill" id="myTab3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ordasc-tab" data-bs-toggle="tab" data-bs-target="#ordasc-tab-pane" type="button" role="tab" aria-controls="ordasc-tab-pane" aria-selected="false">Ordenar ASC</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ordesc-tab" data-bs-toggle="tab" data-bs-target="#ordesc-tab-pane" type="button" role="tab" aria-controls="ordesc-tab-pane" aria-selected="false">Ordenar DESC</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="Filter1TabContent">
                            <div class="tab-pane fade" id="ordasc-tab-pane" role="tabpanel" aria-labelledby="ordasc-tab" tabindex="2">
                                <form method="post" name="page7" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="7">
                                    <input type="hidden" name="mainpage" value="1">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $ordasc= "select * from a16078_users order by username asc";
                                    $statement= $ms->prepare($ordasc);
                                    $statement->execute();
                                    $statement->bind_result($iduser,$username, $password, $admin);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="4">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                        echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                        echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                            <div class="tab-pane fade" id="ordesc-tab-pane" role="tabpanel" aria-labelledby="ordesc-tab" tabindex="2">
                                <form method="post" name="page8" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="8">
                                    <input type="hidden" name="mainpage" value="1">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $ordesc= "select * from a16078_users order by username desc";
                                    $statement= $ms->prepare($ordesc);
                                    $statement->execute();
                                    $statement->bind_result($iduser,$username, $password, $admin);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="4">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                        echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                        echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="adminsort-tab-pane" role="tabpanel" aria-labelledby="adminsort-tab" tabindex="1">
                        <ul class="nav nav-tabs nav-fill" id="myTab4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-tab-pane" type="button" role="tab" aria-controls="admin-tab-pane" aria-selected="false">Administradores</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="noadmin-tab" data-bs-toggle="tab" data-bs-target="#noadmin-tab-pane" type="button" role="tab" aria-controls="noadmin-tab-pane" aria-selected="false">Outros Utilizadores</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="Filter2TabContent">
                            <div class="tab-pane fade" id="admin-tab-pane" role="tabpanel" aria-labelledby="admin-tab" tabindex="2">
                                <form method="post" name="page9" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="9">
                                    <input type="hidden" name="mainpage" value="1">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $filteradmin= "select * from a16078_users where admin=1";
                                    $statement= $ms->prepare($filteradmin);
                                    $statement->execute();
                                    $statement->bind_result($iduser,$username, $password, $admin);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="4">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                        echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                        echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                            <div class="tab-pane fade" id="noadmin-tab-pane" role="tabpanel" aria-labelledby="noadmin-tab" tabindex="2">
                                <form method="post" name="page10" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="10">
                                    <input type="hidden" name="mainpage" value="1">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $noadmin= "select * from a16078_users where admin=0";
                                    $statement= $ms->prepare($noadmin);
                                    $statement->execute();
                                    $statement->bind_result($iduser,$username, $password, $admin);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:25%;text-align:center">ID Utilizador</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Username</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Admin</th>';
                                    echo '<th scope="col" style="width:25%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="4">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:25%;text-align:center" type="text" name="iduser" value='.$iduser.'>';
                                        echo '<input style="width:25%;text-align:center" type="text" name="username" value='.$username.'>';
                                        echo '<input style="width:25%;text-align:center" type="number" name="admin" value='.$admin.'>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:12%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($mainpage==2){echo "show active";}?>" id="records-tab-pane" role="tabpanel" aria-labelledby="records-tab" tabindex="0">
                <ul class="nav nav-tabs" id="myTab5" role="tablist">
                    <!-- Ver -->
                    <li class="nav-item" role="presentation" style="width:33%;">
                        <button class="nav-link <?php if($page==3){echo "active";}?> w-100" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="<?php echo $page!=3 ?'false':'true'; ?>" onclick="page3.submit();">Vista Geral</button>
                    </li>
                    <!-- Consultar -->
                    <div class="dropdown" style="width:33%;">
                        <button class="btn dropdown-toggle w-100 <?php if($page>=4 && $page<=6){echo "active";}?>" type="button" id="consulta-dropdown3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php echo ($page>=4 && $page<=6)?'true':'false'; ?>">
                            Consulta
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="consulta-dropdown3" id="consulta-tab-pane3">
                            <button class="dropdown-item w-100" id="gamesearch-tab" type="button" data-bs-toggle="tab" data-bs-target="#gamesearch-tab-pane" aria-controls="gamesearch-tab-pane">por nome</button>
                            <button class="dropdown-item w-100" id="scoresearch-tab" type="button" data-bs-toggle="tab" data-bs-target="#scoresearch-tab-pane" aria-controls="scoresearch-tab-pane">por pontuação</button>
                            <button class="dropdown-item w-100" id="datesearch-tab" type="button" data-bs-toggle="tab" data-bs-target="#datesearch-tab-pane" aria-controls="datesearch-tab-pane">por data de registo</button>
                        </div>
                    </div>
                    <!-- Filtrar -->
                    <div class="dropdown" style="width:33%;">
                        <button class="btn dropdown-toggle w-100 <?php if($page>=11 && $page<=16){echo "active";}?>" type="button" id="consulta-dropdown4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php echo ($page>=11 && $page<=16)?'true':'false'; ?>">
                            Filtragem
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="consulta-dropdown4" id="consulta-tab-pane4">
                            <button class="dropdown-item w-100" id="namesort-tab" type="button" data-bs-toggle="tab" data-bs-target="#namesort-tab-pane" aria-controls="namesort-tab-pane">Ordenar por nome</button>
                            <button class="dropdown-item w-100" id="scoresort-tab" type="button" data-bs-toggle="tab" data-bs-target="#scoresort-tab-pane" aria-controls="scoresort-tab-pane">Ordenar por pontuação</button>
                            <button class="dropdown-item w-100" id="timesort-tab" type="button" data-bs-toggle="tab" data-bs-target="#timesort-tab-pane" aria-controls="timesort-tab-pane">Ordenar por tempo</button>
                        </div>
                    </div>
                </ul>
                <div class="tab-content" id="RecordsTabContent">
                    <div class="tab-pane fade <?php if($page==3){echo "show active";}?>" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="1">
                        <form method="post" name="page3" class="row g-0 align-items-center m-4">
                            <input type="hidden" name="page" value="3">
                            <input type="hidden" name="mainpage" value="2">
                            <input hidden type="submit" value="Consultar" name="namesearch">
                        </form>
                        <?php
                            $totalgames= "select * from a16078_recordes";
                            $results= $ms->prepare($totalgames);
                            $results->execute();
                            $results->bind_result($codreg,$nome, $tempo, $score, $datahora);
                            echo '<table class="table table-secondary table-striped table-hover">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                            echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                            echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                            echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                            echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                            echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody class="table-group-divider">';
                            while($results->fetch()){
                                echo '<tr><td colspan="6">';
                                echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                echo '</form>';
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            $results->close();
                        ?>
                    </div>
                    <div class="tab-pane fade <?php if($page==4){echo "show active";}?>" id="gamesearch-tab-pane" role="tabpanel" aria-labelledby="gamesearch-tab" tabindex="1">
                        <form method="post" class="row g-0 align-items-center m-4">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="namegame" name="namegame" placeholder="Nome">
                                    <label for="namegame">Nome</label>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="4">
                            <input type="hidden" name="mainpage" value="2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input class="btn btn-info w-100 text-center p-3" type="submit" value="Consultar" name="namesearch">
                                </div>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['namesearch'])){
                                $nomegames= "select * from a16078_recordes where nome=?";
                                $statement= $ms->prepare($nomegames);
                                $statement->bind_param('s',$_POST['namegame']);
                                $statement->execute();
                                $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                echo '<table class="table table-secondary table-striped table-hover">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="table-group-divider">';
                                while($statement->fetch()){
                                    echo '<tr><td colspan="6">';
                                    echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                    echo '</form>';
                                    echo '</td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                $statement->close();
                            }
                        ?>
                    </div>
                    <div class="tab-pane fade <?php if($page==5){echo "show active";}?>" id="scoresearch-tab-pane" role="tabpanel" aria-labelledby="scoresearch-tab" tabindex="1">
                        <form method="post" class="row g-0 align-items-center m-4" action="<?php echo $_SERVER["PHP_SELF"];?>">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="scoregame" name="scoregame" placeholder="Pontos">
                                    <label for="scoregame">Pontos</label>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="5">
                            <input type="hidden" name="mainpage" value="2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input class="btn btn-info w-100 text-center p-3" type="submit" value="Consultar" name="scoresearch">
                                </div>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['scoresearch'])){
                                $scoregames= "select * from a16078_recordes where score=?";
                                $statement= $ms->prepare($scoregames);
                                $statement->bind_param('i',$_POST['scoregame']);
                                $statement->execute();
                                $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                echo '<table class="table table-secondary table-striped table-hover">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="table-group-divider">';
                                while($statement->fetch()){
                                    echo '<tr><td colspan="6">';
                                    echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                    echo '</form>';
                                    echo '</td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                $statement->close();
                            }
                        ?>
                    </div>
                    <div class="tab-pane fade <?php if($page==6){echo "show active";}?>"  id="datesearch-tab-pane" role="tabpanel" aria-labelledby="datesearch-tab" tabindex="1">
                        <form method="post" class="row g-0 align-items-center m-4" action="<?php echo $_SERVER["PHP_SELF"];?>">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="dategame" name="dategame" placeholder="Data">
                                    <label for="dategame">Data</label>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="6">
                            <input type="hidden" name="mainpage" value="2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input class="btn btn-info w-100 text-center p-3" type="submit" value="Consultar" name="datesearch">
                                </div>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['datesearch'])){
                                $dategames= "select * from a16078_recordes where date_format(Datahora, '%Y-%m-%d')=?";
                                $statement= $ms->prepare($dategames);
                                $statement->bind_param('s',$_POST['dategame']);
                                $statement->execute();
                                $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                echo '<table class="table table-secondary table-striped table-hover">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="table-group-divider">';
                                while($statement->fetch()){
                                    echo '<tr><td colspan="6">';
                                    echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                    echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                    echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                    echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                    echo '</form>';
                                    echo '</td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                $statement->close();
                            }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="namesort-tab-pane" role="tabpanel" aria-labelledby="namesort-tab" tabindex="1">
                        <ul class="nav nav-tabs nav-fill" id="myTab6" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nameasc-tab" data-bs-toggle="tab" data-bs-target="#nameasc-tab-pane" type="button" role="tab" aria-controls="nameasc-tab-pane" aria-selected="false">Ordenar ASC</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="namedesc-tab" data-bs-toggle="tab" data-bs-target="#namedesc-tab-pane" type="button" role="tab" aria-controls="namedesc-tab-pane" aria-selected="false">Ordenar DESC</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="Filter3TabContent">
                            <div class="tab-pane fade <?php if($page==11){echo "show active";}?>" id="nameasc-tab-pane" role="tabpanel" aria-labelledby="nameasc-tab" tabindex="2">
                                <form method="post" name="page11" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="11">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $nameasc= "select * from a16078_recordes order by nome asc";
                                    $statement= $ms->prepare($nameasc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                            <div class="tab-pane fade <?php if($page==12){echo "show active";}?>" id="namedesc-tab-pane" role="tabpanel" aria-labelledby="namedesc-tab" tabindex="2">
                                <form method="post" name="page12" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="12">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $namedesc= "select * from a16078_recordes order by nome desc";
                                    $statement= $ms->prepare($namedesc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="scoresort-tab-pane" role="tabpanel" aria-labelledby="scoresort-tab" tabindex="1">
                        <ul class="nav nav-tabs nav-fill" id="myTab7" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="scoreasc-tab" data-bs-toggle="tab" data-bs-target="#scoreasc-tab-pane" type="button" role="tab" aria-controls="scoreasc-tab-pane" aria-selected="false">Ordenar ASC</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="scoredesc-tab" data-bs-toggle="tab" data-bs-target="#scoredesc-tab-pane" type="button" role="tab" aria-controls="scoredesc-tab-pane" aria-selected="false">Ordenar DESC</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="Filter4TabContent">
                            <div class="tab-pane fade <?php if($page==13){echo "show active";}?>" id="scoreasc-tab-pane" role="tabpanel" aria-labelledby="scoreasc-tab" tabindex="2">
                                <form method="post" name="page13" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="13">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $scoreasc= "select * from a16078_recordes order by score asc";
                                    $statement= $ms->prepare($scoreasc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                            <div class="tab-pane fade <?php if($page==14){echo "show active";}?>" id="scoredesc-tab-pane" role="tabpanel" aria-labelledby="scoredesc-tab" tabindex="2">
                                <form method="post" name="page14" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="14">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $scoredesc= "select * from a16078_recordes order by score desc";
                                    $statement= $ms->prepare($scoredesc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="timesort-tab-pane" role="tabpanel" aria-labelledby="timesort-tab" tabindex="1">
                        <ul class="nav nav-tabs nav-fill" id="myTab8" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timeasc-tab" data-bs-toggle="tab" data-bs-target="#timeasc-tab-pane" type="button" role="tab" aria-controls="timeasc-tab-pane" aria-selected="false">Ordenar ASC</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timedesc-tab" data-bs-toggle="tab" data-bs-target="#timedesc-tab-pane" type="button" role="tab" aria-controls="timedesc-tab-pane" aria-selected="false">Ordenar DESC</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="Filter5TabContent">
                            <div class="tab-pane fade <?php if($page==15){echo "show active";}?>" id="timeasc-tab-pane" role="tabpanel" aria-labelledby="timeasc-tab" tabindex="2">
                                <form method="post" name="page15" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="15">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $timeasc= "select * from a16078_recordes order by tempo asc";
                                    $statement= $ms->prepare($timeasc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                            <div class="tab-pane fade <?php if($page==16){echo "show active";}?>" id="timedesc-tab-pane" role="tabpanel" aria-labelledby="timedesc-tab" tabindex="2">
                                <form method="post" name="page16" class="row g-0 align-items-center m-4">
                                    <input type="hidden" name="page" value="16">
                                    <input type="hidden" name="mainpage" value="2">
                                    <input hidden type="submit" value="Consultar" name="namesearch">
                                </form>
                                <?php
                                    $timedesc= "select * from a16078_recordes order by tempo desc";
                                    $statement= $ms->prepare($timedesc);
                                    $statement->execute();
                                    $statement->bind_result($codreg,$nome, $tempo, $score, $datahora);
                                    echo '<table class="table table-secondary table-striped table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Código Registo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Nome</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Tempo</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Pontuação</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Data e Hora</th>';
                                    echo '<th scope="col" style="width:16%;text-align:center">Opções</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody class="table-group-divider">';
                                    while($statement->fetch()){
                                        echo '<tr><td colspan="6">';
                                        echo '<form method="post" style="display:flex;justify-content:space-between;align-items:center">';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="codreg" value='.$codreg.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="nome" value='.$nome.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="tempo" value='.$tempo.'>';
                                        echo '<input style="width:16%;text-align:center" type="text" name="score" value='.$score.'>';
                                        echo '<input readonly style="width:16%;text-align:center" type="text" name="datahora" value="'.$datahora.'">';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="altera"><i class="bi bi-pencil-square"></i></button>';
                                        echo '<button style="width:8%;text-align:center" type="submit" class="fabutton" name="elimina"><i class="bi bi-trash-fill"></i></button>';
                                        echo '</form>';
                                        echo '</td></tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    $statement->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                }
            }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>