var tecla;
var i, j, t='', jplay=0, iplay=5, ids, endi=14, endj=39;
var map=new Array(20);
var coins=new Array(5), ncoins=0;
var monsters= new Array(5), nmonsters=0;
var mapuse=new Array(20);
var idplay=iplay*40+jplay+1;
var pts=0;
var timeall, timemap;
var mapcomplete=0;
var tabelas=1;
for(i=0; i<20; i++){
    map[i]=[];
    for(j=0; j<29; j++){
        map[i][j]=[];
        
    }
}
for(i=0; i<20; i++){
    coins[i]=[];
    monsters[i]=[];
    for(j=0; j<5; j++){
        coins[i][j]=[];
        coins[i][j][0]=-1;
        coins[i][j][1]=-1;
        monsters[i][j]=[];
        monsters[i][j][0]=-1;
        monsters[i][j][1]=-1;
        monsters[i][j][2]=-1;
    }
}
//  Try to create something like: 
// map[0]
// coins[0]
// monsters[0]
// map[1]
// coins[1]
// monsters[1]
// map[2]
// coins[2]
// monsters[2]
var mapnumber=0;
var nmaps=5;
var p;
var mm1,c1,s1,m1,mm2,c2,s2,m2, flag=0;
mm1=c1=s1=m1=mm2=c2=s2=m2=0;
var tempomap, tempoall;
var difficult;
for(i=0; i<nmaps; i++){
    mapuse[i]=0;
}
function choosedif(){
    tabelas=0;
    for(i=1; i<=4; i++){
        document.getElementById("button"+i).style.display="none";
    }
    document.getElementById("diftable").style.display="flex";
    document.getElementById("voltar").style.visibility="visible";
}
function cronoall(){
}
function cronomap(){
}
function geramap(dif){
    tabelas=1;
    if(mapcomplete==0){
        mapcomplete=1;
        difficult=dif;
    }
    mode=1;
    document.getElementById("tabeladiv").innerHTML=t;
    p=document.getElementById(idplay);
    document.getElementById("tabela").style.display="table";
    document.getElementById("stats").style.display="flex";
    document.getElementById("points").innerHTML="Pontos: "+pts;
    document.getElementById("mapcomplete").innerHTML="Mapa "+mapcomplete+"/5";
    document.getElementById("diftable").style.display="none";
    if(difficult>1){
        moves=setInterval(monstermove, 750);
    }
    else{
        moves=setInterval(monstermove, 1000);
    }
    if(flag!=1){
        timeall=setInterval(cronoall, 10);
        flag=1;
    }
    timemap=setInterval(cronomap, 10);
}
function howplay(){
    tabelas=0;
    for(i=1; i<=4; i++){
        document.getElementById("button"+i).style.display="none";
    }
    document.getElementById("voltar").style.visibility="visible";
    document.getElementById("comojogar").style.display="block";
}
function makemap(){
    mode=2;
    saving=1;
    t='<table id="tabela">';
    for(i=0; i<29; i++){
        t+='<tr>';
        for(j=0; j<40; j++){
            ids=i*40+j+1;
            map[nmaps][i][j]=2;
            if(iplay==i && jplay==j){
                t+='<td class="jogador" id="'+ids+'">&nbsp;</td>';
            }
            else{
                if(endi==i && endj==j){
                    t+='<td class="fim" id="'+ids+'">&nbsp;</td>';
                    map[nmaps][i][j]=3;
                }
                else{
                    if(i==0 || j==0 || i==28 || j==39){
                        t+='<td class="parede" id="'+ids+'">&nbsp;</td>';
                    }
                    else{
                        t+='<td class="parede" id="'+ids+'" onclick="tdedit(troca, this)">&nbsp;</td>';
                    }
                }
            }
        }
        t+='</tr>';
    }
    t+='</table>';
    document.getElementById("tabeladiv").innerHTML=t;
    for(i=1; i<=4; i++){
        document.getElementById("button"+i).style.display="none";
    }
    document.getElementById("tabela").style.display="table";
    document.getElementById("edit").style.display="flex";
    document.getElementById("ncoin").innerHTML="Moedas (x"+(5-ncoins)+")";
    document.getElementById("nmonsterh").innerHTML="Inimigo (x"+(5-nmonsters)+")";
    document.getElementById("savemap").style.display="flex";
    document.getElementById("voltar").style.visibility="visible";
}
var troca=0;
var tempid;
function tdedit(troca, tds){
}
var saving=0;
function savemap(){
    saving=0;
    p=document.getElementById(idplay);
    moves=setInterval(monstermove, 1000);
}
function records(){
    window.location.href="records.php";
}

// Ãdd Monster Movement Logic  function monstermove(){
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
var som=0;
var music0= new Audio("musica.mp3");
var music1= new Audio("lvl1.mp3");
var music2= new Audio("lvl2.mp3");
var music3= new Audio("lvl3.mp3");
var music4= new Audio("lvl4.mp3");
var music5= new Audio("lvl5.mp3");
music0.loop=true;
music1.loop=true;
music2.loop=true;
music3.loop=true;
music4.loop=true;
music5.loop=true;
function sons(){
    if(som==1){
        document.getElementById("som").innerHTML='<i class="bi bi-volume-mute-fill"></i>';
        som=0;
        switch(mapcomplete){
            case 0:
                music0.pause();
                break;
            case 1:
                music1.pause();
                break;
            case 2:
                music2.pause();
                break;
            case 3:
                music3.pause();
                break;
            case 4:
                music4.pause();
                break;
            case 5:
                music5.pause();
                break;
        }
    }
    else{
        document.getElementById("som").innerHTML='<i class="bi bi-volume-up-fill"></i>';
        som=1;
        switch(mapcomplete){
            case 0:
                music0.play();
                break;
            case 1:
                music0.pause();
                music1.play();
                break;
            case 2:
                music1.pause();
                music2.play();
                break;
            case 3:
                music2.pause();
                music3.play();
                break;
            case 4:
                music3.pause();
                music4.play();
                break;
            case 5:
                music4.pause();
                music5.play();
                break;
        }
    }
}