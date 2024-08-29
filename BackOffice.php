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
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
