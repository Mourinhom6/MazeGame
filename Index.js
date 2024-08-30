function goback(){
    if(tabelas==1){
        document.getElementById("tabela").style.display="none";
    }
    troca=0;
    for(i=0; i<ncoins; i++){
        tempcoins[i][0]=-1;
    }
    for(i=0; i<coins[mapnumber].length; i++){
        coins[mapnumber][i][1]=0;
    }
    for(i=0; i<monsters[mapnumber].length; i++){
        monsters[mapnumber][i][2]=monsters[mapnumber][i][0];
    }
    for(i=0; i<nmonsters; i++){
        tempmonsters[i][0]=-1;
        tempmonsters[i][1]=-1;
        tempmonsters[i][2]=-1;
    }
    for(i=0; i<nmaps; i++){
        mapuse[i]=0;
    }
    clearInterval(moves);
    clearInterval(timemap);
    clearInterval(timeall);
    mm1=c1=s1=m1=mm2=c2=s2=m2=0;
    flag=0;
    tabelas=0;
    pts=0;
    mapcomplete=0;
    mapnumber=0;
    ncoins=0;
    nmonsters=0;
    result=0;
    iplay=5;
    jplay=0;
    idplay=iplay*40+jplay+1;
    if(som){
            music1.pause();
            music2.pause();
            music3.pause();
            music4.pause();
            music5.pause();
            music0.play();
    }
    document.getElementById("tabeladiv").innerHTML="";
    document.getElementById("stats").style.display="none";
    document.getElementById("comojogar").style.display="none";
    document.getElementById("edit").style.display="none";
    document.getElementById("savemap").style.display="none";
    document.getElementById("winner").style.display="none";
    document.getElementById("loser").style.display="none";
    if(mode==1){
        document.getElementById("diftable").style.display="flex";
        mode=0;
    }
    else{
        document.getElementById("diftable").style.display="none";
        for(i=1; i<=4; i++){
            document.getElementById("button"+i).style.display="inline-block";
        }
        document.getElementById("voltar").style.visibility="hidden";
    }
}