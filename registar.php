<?php
    require_once("cnfig.php");
    $ms=new mysqli($bd_host, $bd_user, $bd_password, $bd_database);
    if($ms->connect_error){
        $msg='<h3 class="erro">Error: ('.$ms->connect_errno.') ('.$ms->connect_error.')</h3>';
    }
    if(isset($_POST["OK"])){
        if(isset($_POST["nome"]) && isset($_POST["time"]) && isset($_POST["score"])){
            if($_POST["nome"]!="" && $_POST["time"]!="" && $_POST["score"]!=""){
                $query="insert into a16078_recordes(nome, tempo, score, datahora) values(?,?,?,NOW())";
                $statement=$ms->prepare($query);
                $statement->bind_param('sss',$_POST["nome"],$_POST["time"],$_POST["score"]);
                if($statement->execute() && $statement->affected_rows>0){}
                else{
                    die('Erro: ('. $ms->errno .') '. $ms->error);
                }
            }
        }
    }