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
map[0]=[
        [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
        [2,2,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2],
        [2,2,4,2,2,2,1,2,2,2,2,1,2,2,1,2,1,2,2,2,2,2,2,1,1,1,1,1,1,1,1,1,1,2,2,2,1,2,2,2],
        [2,2,2,2,2,1,1,2,1,1,1,1,1,1,1,1,1,1,1,2,2,2,1,1,1,1,2,2,1,2,2,2,1,1,1,1,1,1,1,2],
        [2,1,2,2,2,1,2,2,1,2,2,1,2,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,1,1,1,2,2,2,2,1,1,2],
        [2,1,1,1,1,6,1,1,1,2,2,1,2,2,1,1,1,1,1,1,6,1,1,1,2,2,2,2,2,1,1,2,2,2,2,2,1,1,1,2],
        [2,1,1,1,1,1,2,2,2,2,2,2,2,2,2,1,1,1,2,1,1,1,1,2,2,2,2,2,1,1,1,2,2,2,2,1,1,1,1,2],
        [2,2,2,2,2,1,2,2,2,2,2,1,1,1,1,1,2,2,2,2,1,2,2,2,2,2,2,1,1,2,1,2,2,2,2,1,2,2,2,2],
        [2,2,2,2,2,1,2,1,2,2,2,1,2,2,2,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,2,2,1,2,1,2,2,2,2],
        [2,2,2,2,1,1,1,1,1,2,2,1,2,2,2,2,2,2,1,2,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,1,2,2,2,2],
        [2,2,2,1,1,1,1,1,1,2,2,1,1,1,2,2,2,2,2,1,2,2,2,2,1,1,1,2,2,2,2,2,2,1,2,2,2,2,2,2],
        [2,2,2,2,1,1,1,1,1,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,1,2,2,2,2,1,1,1,5,1,1,2,2,2,2,2],
        [2,2,2,2,1,1,2,2,2,2,2,2,2,1,2,2,2,2,2,2,2,4,2,2,1,2,1,2,2,2,1,2,2,2,1,1,2,2,2,2],
        [2,2,2,2,1,2,2,2,2,2,2,2,2,1,2,2,2,2,2,2,2,2,1,2,1,1,1,2,2,2,1,2,2,2,2,1,2,2,2,2],
        [2,4,2,2,1,2,2,2,2,2,1,1,1,1,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,1,1,1,1,1,3],
        [2,1,1,2,1,2,2,2,2,1,1,1,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2,1,1,1,2,2],
        [2,1,2,2,1,1,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2,2,2,2,2],
        [2,1,2,1,1,2,2,2,2,2,2,2,2,2,1,1,1,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,1,2,2,2,2,2,2,2],
        [2,1,2,2,1,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2,1,1,2,2,2],
        [2,1,1,2,1,1,2,2,2,1,4,2,2,1,1,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2,1,1,2,2,2,2],
        [2,2,1,2,1,2,2,2,2,1,2,2,1,1,2,1,1,1,1,1,2,2,2,2,2,2,1,1,2,1,1,2,2,1,1,1,1,1,2,2],
        [2,1,1,5,1,1,2,2,2,1,2,1,1,2,2,2,2,2,1,2,2,2,2,2,2,2,1,2,2,2,1,2,2,2,1,2,4,1,2,2],
        [2,2,2,1,2,2,2,2,2,1,1,1,1,1,1,1,1,1,1,2,1,2,2,2,2,2,1,2,2,2,1,2,2,2,1,2,2,2,2,2],
        [2,2,2,1,1,1,2,2,2,1,1,1,1,1,2,1,1,1,1,2,1,2,2,2,2,2,1,1,1,1,5,1,1,1,1,2,1,1,2,2],
        [2,2,2,2,2,1,2,2,1,1,1,2,2,2,2,2,1,2,1,1,1,2,2,2,2,1,1,2,2,2,2,2,2,1,1,1,1,2,2,2],
        [2,2,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2,2,2,1,2,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,2,2,2,2],
        [2,1,1,1,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2],
        [2,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
        [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]];
coins[0]=[
        [83,0],
        [502,0],
        [877,0],
        [771,0],
        [562,0]];
monsters[0]=[
            [473,3,473],
            [844,3,844],
            [221,1,221],
            [206,4,206],
            [951,3,951]];
map[1]=[
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,2,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2],
    [2,2,1,2,2,2,1,2,2,2,2,1,2,2,1,2,4,2,2,2,2,2,2,4,1,6,1,1,1,1,1,1,1,2,2,2,1,2,2,2],
    [2,2,1,2,2,1,1,1,1,1,1,5,1,1,1,1,1,2,2,2,2,2,2,2,2,1,2,2,1,2,2,2,1,1,1,1,1,1,1,2],
    [2,1,1,2,1,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,2,2,2,2,1,1,2],
    [2,1,2,2,1,2,2,1,1,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2,2,1,1,1,2],
    [2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,1,2,1,1,1,1,1,1,1,2,2,2,2,2,1,1,2,2,2,2,1,1,1,1,2],
    [2,2,2,2,1,1,2,2,2,2,2,1,1,1,1,1,2,1,2,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,2,1,2,2,2,2],
    [2,2,2,2,2,1,1,1,2,2,2,1,2,2,2,1,1,1,2,1,2,2,2,1,2,2,1,1,1,1,1,2,2,1,2,1,2,2,2,2],
    [2,2,2,2,2,2,2,1,1,2,2,1,2,2,2,2,2,2,2,1,2,2,2,1,2,1,1,2,2,2,2,2,2,1,1,1,2,2,2,2],
    [2,2,2,1,1,2,2,1,1,2,2,1,1,1,2,2,2,2,2,1,1,4,2,1,1,1,1,2,2,2,2,2,2,1,2,2,2,2,2,2],
    [2,2,2,2,1,2,2,1,1,1,2,2,2,1,2,1,2,2,2,1,2,2,2,2,1,2,2,2,2,1,1,1,1,1,1,2,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,1,2,2,2,1,2,1,1,5,1,1,2,2,2,1,1,2,1,2,2,2,1,2,2,2,1,1,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,1,1,2,2,1,2,2,2,1,2,2,2,2,1,1,1,1,1,2,2,2,1,2,2,2,2,1,2,2,2,2],
    [2,1,2,2,1,2,2,2,2,2,1,1,1,1,1,1,1,1,2,2,1,1,2,2,2,2,2,2,2,2,1,2,2,2,1,5,1,1,1,3],
    [2,1,4,2,1,2,2,2,2,1,1,1,2,2,2,1,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,2,2,2,2,1,1,1,2,2],
    [2,1,2,2,1,1,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,2,2,2,1,1,1,1,2,2,2,1,2,2,2],
    [2,1,2,1,1,2,2,2,2,2,2,2,2,2,1,1,1,2,2,2,2,2,1,2,2,2,2,2,1,1,2,1,1,2,2,2,1,2,2,2],
    [2,1,2,2,1,2,2,2,2,2,2,2,2,2,1,1,1,2,2,2,2,1,1,2,2,2,2,2,1,2,2,1,2,2,2,2,1,2,2,2],
    [2,1,1,2,1,1,2,2,2,1,1,2,2,1,1,1,2,2,2,2,1,1,2,2,2,2,2,1,2,2,2,2,2,2,2,2,1,2,2,2],
    [2,2,1,2,1,2,2,2,2,1,2,2,1,1,2,2,2,2,2,1,1,2,2,2,2,2,1,1,2,2,2,2,2,2,2,1,1,2,2,2],
    [2,1,1,5,1,1,2,2,2,1,2,2,1,2,2,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,1,2,2,2,1,1,2,4,2,2],
    [2,2,2,1,2,2,2,2,2,1,2,2,1,2,2,2,2,2,2,1,1,2,2,2,2,2,1,2,2,2,1,2,2,1,1,2,2,1,1,2],
    [2,2,2,1,1,1,2,2,2,1,2,2,1,1,2,2,2,2,2,2,1,1,2,2,2,2,1,1,1,1,1,2,2,1,1,2,2,1,1,2],
    [2,2,2,2,2,1,2,1,1,1,1,2,2,1,2,2,2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2],
    [2,2,1,2,2,1,2,2,2,1,2,2,2,1,2,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2],
    [2,1,1,1,2,1,2,2,2,1,2,2,2,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]];
coins[1]=[
    [422,0],
    [104,0],
    [878,0],
    [603,0],
    [97,0]];
monsters[1]=[
    [498,2,498],
    [106,1,106],
    [844,2,844],
    [132,2,132],
    [596,2,596]];
map[2]=[
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2],
    [2,2,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,1,1,1,1,2,2,2,4,2,2,2],
    [2,2,1,2,2,1,2,2,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,2,1,1,1,1,5,1,1,2],
    [2,2,1,2,2,1,2,2,1,2,2,1,2,1,1,2,2,2,2,2,2,1,2,2,2,2,2,2,2,2,1,1,1,2,2,2,2,1,1,2],
    [2,1,1,2,2,1,2,2,1,1,2,1,2,2,1,1,2,2,1,1,1,6,1,1,1,2,2,2,2,1,1,2,2,2,2,2,1,1,1,2],
    [2,2,2,2,2,1,2,2,2,1,2,2,2,2,2,1,2,2,4,2,2,1,2,2,1,2,2,2,1,1,1,2,2,2,2,1,1,1,1,2],
    [2,2,2,2,2,1,2,2,2,1,2,1,1,1,1,1,2,1,2,2,2,2,2,2,1,2,2,1,1,2,1,2,2,2,2,1,2,2,2,2],
    [2,2,2,2,2,1,2,1,2,1,2,1,2,2,2,1,1,1,1,2,2,2,2,2,1,1,1,1,1,1,1,2,2,1,2,1,2,2,2,2],
    [2,2,2,2,1,1,1,1,1,1,2,1,2,2,2,2,2,2,1,2,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,1,2,2,2,2],
    [2,2,2,1,1,2,2,2,2,2,2,1,1,1,2,2,2,2,1,1,1,2,2,2,1,1,1,2,2,2,2,2,2,1,2,2,2,2,2,2],
    [2,2,2,2,1,1,1,1,1,1,2,2,2,1,2,2,2,2,2,2,1,2,2,2,1,2,2,2,2,1,1,1,1,1,1,2,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,1,2,2,2,1,2,2,2,2,2,2,1,1,1,2,1,2,1,2,2,2,1,2,2,2,1,1,2,2,2,2],
    [2,2,2,2,1,2,2,4,1,1,2,2,2,1,2,2,2,2,2,2,2,2,1,1,1,1,1,2,2,2,1,2,2,2,2,1,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,2,2,1,1,1,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,2,1,2,2,2,1,6,1,1,1,3],
    [2,2,2,2,1,2,2,2,2,1,1,1,2,2,2,1,2,2,2,2,2,2,1,1,2,2,2,2,2,1,1,2,2,2,2,1,1,1,2,2],
    [2,2,2,2,1,1,1,1,1,1,2,2,2,2,2,1,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,1,1,2,2,1,2,2,2,2],
    [2,2,2,1,1,2,2,2,2,2,2,2,2,2,1,1,1,2,2,2,1,1,2,2,2,2,2,2,2,2,2,1,1,2,2,1,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,2,2,2,2,2,1,2,1,1,2,1,1,2,2,2,2,2,2,2,1,1,1,1,2,2,2,1,1,2,2,2],
    [2,2,2,2,1,1,2,2,2,2,2,2,2,1,1,2,2,1,1,1,2,2,2,2,2,2,2,1,1,1,1,2,2,2,1,1,2,2,2,2],
    [2,2,2,2,1,2,2,2,2,2,2,2,1,1,2,2,2,2,1,1,2,2,2,1,1,1,1,1,2,2,2,2,2,1,6,1,1,1,2,2],
    [2,2,2,2,1,2,2,2,1,1,1,1,1,2,2,2,2,2,2,1,1,2,4,1,2,1,6,2,2,2,2,2,2,1,1,2,1,1,2,2],
    [2,2,2,1,1,1,2,2,1,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2,1,2,2,2,2,2,2,2,1,4,2,1,2,2],
    [2,2,1,1,2,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]];
coins[2]=[
    [528,0],
    [259,0],
    [863,0],
    [916,0],
    [117,0]];
monsters[2]=[
    [835,1,835],
    [867,1,867],
    [222,1,222],
    [157,2,157],
    [596,1,596]];
map[3]=[
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,1,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,2,4,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,4,2,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,4,3],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,1,2],
    [2,4,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]];
coins[3]=[
    [599,0],
    [922,0],
    [557,0],
    [1020,0],
    [204,0]];
monsters[3]=[
    [-1,-1,-1],
    [-1,-1,-1],
    [-1,-1,-1],
    [-1,-1,-1],
    [-1,-1,-1]];
map[4]=[
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2],
    [2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,1,2,2,2,1,1,1,1,1,2,2,1,2,2,1,1,1,2],
    [2,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,1,1,1,1,1,2,2,2,1,2,2,1,2,2,1,2,1,2],
    [2,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,1,2,2,2,2,1,2,1,2,2,2,2,1,2,2,1,2,2,1,2,1,2],
    [2,2,2,2,2,2,2,2,2,1,1,1,1,1,1,1,2,2,1,2,2,2,2,1,2,1,2,1,1,1,1,1,1,1,1,2,1,2,1,2],
    [2,1,1,1,2,2,2,2,2,2,2,2,1,2,2,1,1,1,1,1,1,2,2,1,2,1,2,2,2,2,2,2,2,2,1,2,1,2,1,2],
    [2,2,1,2,2,2,1,1,1,1,1,2,1,2,2,1,2,2,2,1,2,2,2,1,2,1,2,2,2,2,2,2,2,2,1,1,1,2,1,2],
    [2,2,1,2,2,2,1,2,2,1,2,2,1,2,2,1,2,1,2,1,2,1,2,1,2,1,1,1,1,1,1,1,2,2,1,2,2,2,1,2],
    [2,2,1,1,1,1,1,2,2,1,2,2,1,2,2,1,2,1,2,1,2,1,2,1,2,1,2,2,2,2,2,2,2,2,2,2,2,2,1,2],
    [2,2,1,2,2,2,2,2,2,1,2,2,1,2,2,1,1,1,2,1,2,1,2,1,2,6,2,2,2,2,2,2,2,1,1,1,1,1,1,2],
    [2,2,2,2,2,1,1,1,1,1,2,2,1,2,2,2,2,1,2,1,2,1,1,1,2,1,2,1,1,1,1,1,1,1,2,2,2,2,2,2],
    [2,2,2,2,2,1,2,2,2,1,2,2,1,2,2,2,2,1,2,2,2,1,2,2,2,1,2,2,2,2,2,1,2,1,2,2,2,2,2,2],
    [2,1,1,1,1,1,2,2,2,2,2,2,1,2,4,2,2,1,2,2,2,1,2,2,2,1,1,1,1,4,2,1,2,1,1,1,1,4,2,2],
    [2,2,1,2,2,1,1,1,1,1,1,1,1,2,1,2,2,1,2,2,2,1,2,2,2,1,2,2,2,2,2,1,2,6,2,2,2,2,2,2],
    [2,2,1,2,2,1,2,2,1,2,2,2,2,2,1,2,2,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,2,1,2,1,2,1,1,3],
    [2,2,1,1,1,1,2,2,1,2,2,2,2,2,1,2,2,1,2,2,2,1,2,2,2,2,1,2,1,2,2,1,2,1,2,1,2,1,2,2],
    [2,2,1,2,2,1,2,2,1,2,1,1,1,1,5,1,1,1,1,2,2,1,1,1,1,2,1,2,1,2,2,2,2,1,2,1,2,1,2,2],
    [2,2,1,2,2,1,2,2,1,2,1,2,1,2,2,2,2,2,2,2,2,1,2,2,2,2,1,2,1,1,1,1,1,1,2,1,2,1,2,2],
    [2,1,1,2,2,1,2,2,1,2,1,2,1,1,2,1,1,1,1,1,1,1,2,2,1,1,1,2,1,2,2,2,2,1,1,1,1,1,1,2],
    [2,1,2,2,2,2,2,2,1,2,1,2,2,2,2,1,2,2,1,2,2,2,2,2,1,2,2,2,1,2,2,2,1,1,2,2,2,2,2,2],
    [2,1,1,1,1,2,1,1,1,1,1,2,2,1,1,1,1,1,1,1,2,2,2,2,1,2,4,2,1,2,2,1,1,2,2,2,2,2,2,2],
    [2,1,2,2,2,2,1,2,2,2,1,2,2,1,2,1,2,2,1,2,2,1,1,1,1,2,1,2,1,1,1,1,1,1,1,1,1,1,2,2],
    [2,1,1,1,1,1,1,2,2,2,1,2,2,1,2,1,1,1,1,1,2,1,2,2,6,2,1,2,1,2,2,1,1,2,2,2,2,1,2,2],
    [2,2,2,2,1,2,1,1,1,1,5,1,1,1,2,1,2,2,2,2,2,1,2,2,1,2,1,2,1,2,2,2,1,1,2,2,1,1,2,2],
    [2,2,2,2,1,2,2,1,2,2,1,2,2,1,2,1,2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,1,2,2],
    [2,1,1,1,1,2,1,4,1,2,1,2,2,1,2,1,1,1,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2,2,1,1,2,1,2,2],
    [2,2,2,2,1,2,2,2,2,2,1,2,2,1,2,1,2,2,1,2,2,1,2,2,1,2,2,2,2,2,2,2,2,2,2,1,1,1,2,2],
    [2,2,2,2,1,1,1,1,1,1,1,1,1,1,1,1,2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2],
    [2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]];
coins[4]=[
    [1008,0],
    [827,0],
    [510,0],
    [495,0],
    [518,0]];
monsters[4]=[
    [931,2,931],
    [905,1,905],
    [386,1,386],
    [655,2,655],
    [554,1,554]];
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
        mm1++;
        if(mm1==10){
            c1++;
            mm1=0;
        }
        if(c1==10){
            s1++;
            c1=0;
        }
        if(s1==60){
            m1++;
            s1=0;
        }
        if(s1<10){
            st1="0"+s1;
        }
        else st1=s1;
        if(m1<10){
            mt1="0"+m1;
        }
        else mt1=m1;
        tempoall=mt1+":"+st1+":"+c1+""+mm1;
        document.getElementById("tempoall").innerHTML=tempoall;
        if(mapcomplete==1 && som){
            music0.pause();
            music1.play();
        }
        if(mapcomplete==2 && som){
            music1.pause();
            music2.play();
        }
        if(mapcomplete==3 && som){
            music2.pause();
            music3.play();
        }
        if(mapcomplete==4 && som){
            music3.pause();
            music4.play();
        }
        if(mapcomplete==5 && som){
            music4.pause();
            music5.play();
        }
}
function cronomap(){
    mm2++;
    if(mm2==10){
        c2++;
        mm2=0;
    }
    if(c2==10){
        s2++;
        c2=0;
    }
    if(s2==60){
        m2++;
        s2=0;
    }
    if(s2<10){
        st2="0"+s2;
    }
    else st2=s2;
    if(m2<10){
        mt2="0"+m2;
    }
    else mt2=m2;
    tempomap=mt2+":"+st2+":"+c2+""+mm2;
    document.getElementById("tempomap").innerHTML=tempomap;
}
function geramap(dif){
    tabelas=1;
    if(mapcomplete==0){
        mapcomplete=1;
        difficult=dif;
    }
    mode=1;
    do{
        mapnumber=(Math.ceil(Math.random()*nmaps))-1;
    }while(mapuse[mapnumber]==1);
    mapuse[mapnumber]=1;
    t='<table id="tabela">';
    for(i=0; i<29; i++){
        t+='<tr>';
        for(j=0; j<40; j++){
            ids=i*40+j+1;
            if(iplay==i && jplay==j){
                t+='<td class="jogador" id="'+ids+'">&nbsp;</td>';
            }
            else{
                switch(map[mapnumber][i][j]){
                    case 1: t+='<td class="chao" id="'+ids+'">&nbsp;</td>';
                        break;
                    case 2: t+='<td class="parede" id="'+ids+'">&nbsp;</td>';
                        break;
                    case 3: t+='<td class="fim" id="'+ids+'">&nbsp;</td>';
                        break;
                    case 4: t+='<td class="coin" id="'+ids+'">&nbsp;</td>';
                        break;
                    case 5: 
                        t+='<td class="monster1" id="'+ids+'">&nbsp;</td>';
                        break;
                    case 6:
                        t+='<td class="monster1" id="'+ids+'">&nbsp;</td>';
                        break;
                }
            }
        }
        t+='</tr>';
    }
    t+='</table>';
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
    if(saving==1){
        tempid=tds.id;
        j=(tempid-1)%40;
        i=parseInt((tempid-1)/40);
        if(troca==1 || troca==2){
            if(map[nmaps][i][j]==4){
                for(k=0; k<ncoins; k++){
                    if(tempcoins[k][0]==tempid){
                        tempcoins.splice(k, 1);
                        tempcoins.push([-1, 0]);
                        ncoins--;
                        document.getElementById("ncoin").innerHTML="Moedas (x"+(5-ncoins)+")";
                    }
                }
            }
            if(map[nmaps][i][j]==5 || map[nmaps][i][j]==6){
                for(k=0; k<nmonsters; k++){
                    if(tempmonsters[k][0]==tempid){
                        tempmonsters.splice(k, 1);
                        tempmonsters.push([-1, -1, -1]);
                        nmonsters--;
                        document.getElementById("nmonsterh").innerHTML="Inimigo (x"+(5-nmonsters)+")";
                    }
                }
            }
            map[nmaps][i][j]=troca;
        }
        switch(troca){
            case 1: // chao
                tds.className="chao";
                break;  
            case 2: // parede
                tds.className="parede";
                break;
            case 4: // Coins
                if(ncoins<5){
                    if(map[nmaps][i][j]==5 || map[nmaps][i][j]==6){
                        for(k=0; k<nmonsters; k++){
                            if(tempmonsters[k][0]==tempid){
                                tempmonsters.splice(k, 1);
                                tempmonsters.push([-1, -1, -1]);
                                nmonsters--;
                                document.getElementById("nmonsterh").innerHTML="Inimigo (x"+(5-nmonsters)+")";
                            }
                        }
                    }
                    if(map[nmaps][i][j]==4){ //IMPEDIR PERDA DE MOEDAS
                        for(k=0; k<ncoins; k++){
                            if(tempcoins[k][0]==tempid){
                                tempcoins.splice(k, 1);
                                tempcoins.push([-1, 0]);
                                ncoins--;
                            }
                        }
                    }
                    map[nmaps][i][j]=troca;
                    tds.className="coin";
                    tempcoins[ncoins][0]=tempid;
                    ncoins++;
                    document.getElementById("ncoin").innerHTML="Moedas (x"+(5-ncoins)+")";
                }
                break;
            case 5: // Monsters
                if(nmonsters<5){
                    if(map[nmaps][i][j]==4){
                        for(k=0; k<ncoins; k++){
                            if(tempcoins[k][0]==tempid){
                                tempcoins.splice(k, 1);
                                tempcoins.push([-1, 0]);
                                ncoins--;
                                document.getElementById("ncoin").innerHTML="Moedas (x"+(5-ncoins)+")";
                            }
                        }
                    }
                    if(map[nmaps][i][j]==5 || map[nmaps][i][j]==6){
                        for(k=0; k<nmonsters; k++){
                            if(tempmonsters[k][0]==tempid){
                                tempmonsters.splice(k, 1);
                                tempmonsters.push([-1, -1, -1]);
                                nmonsters--;
                            }
                        }
                    }
                    map[nmaps][i][j]=troca;
                    tds.className="monster1";
                    tempmonsters[nmonsters][0]=tempid;
                    tempmonsters[nmonsters][1]=2;
                    tempmonsters[nmonsters][2]=tempid;
                    nmonsters++;
                    document.getElementById("nmonsterh").innerHTML="Inimigo (x"+(5-nmonsters)+")";
                }
                break;
            case 6:
                if(nmonsters<5){
                    if(map[nmaps][i][j]==4){
                        for(k=0; k<ncoins; k++){
                            if(tempcoins[k][0]==tempid){
                                tempcoins.splice(k, 1);
                                tempcoins.push([-1, 0]);
                                ncoins--;
                                document.getElementById("ncoin").innerHTML="Moedas (x"+(5-ncoins)+")";
                            }
                        }
                    }
                    if(map[nmaps][i][j]==5 || map[nmaps][i][j]==6){
                        for(k=0; k<nmonsters; k++){
                            if(tempmonsters[k][0]==tempid){
                                tempmonsters.splice(k, 1);
                                tempmonsters.push([-1, -1, -1]);
                                nmonsters--;
                            }
                        }
                    }
                    map[nmaps][i][j]=troca;
                    tds.className="monster1";
                    tempmonsters[nmonsters][0]=tempid;
                    tempmonsters[nmonsters][1]=1;
                    tempmonsters[nmonsters][2]=tempid;
                    nmonsters++;
                    document.getElementById("nmonsterh").innerHTML="Inimigo (x"+(5-nmonsters)+")";
                }
                break;
        }
    }
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
function mover(t){
    tecla=t.keyCode? t.keyCode : t.charCode;
    movimenta();
}
var mode=0;
var moves;
var coinscoll=0;
function movimenta(){
    if(mode==2){
        movimedit();
    }
    else{
        if(mode==1){
            if(map[mapnumber][iplay][jplay]==2){
                p.className="parede";
            }
            else{
                p.className="chao";
            }
            if(difficult>2){
                ncoins=0;
                for(i=0; i<coins[mapnumber].length; i++){
                    if(coins[mapnumber][i][0]!=-1){
                        ncoins++;
                    }
                }
                switch(tecla){
                    case 37: 
                        if(jplay>0 && map[mapnumber][iplay][jplay-1]!=2)
                            jplay--;
                        break;
                    case 39: 
                        if(jplay<40 && ((map[mapnumber][iplay][jplay+1]!=2 && map[mapnumber][iplay][jplay+1]!=3) || (coinscoll==ncoins && map[mapnumber][iplay][jplay+1]==3)))
                            jplay++;
                        break;
                    case 38: 
                        if(iplay>0 && map[mapnumber][iplay-1][jplay]!=2)
                            iplay--;
                        break;
                    case 40: 
                        if(iplay<29 && map[mapnumber][iplay+1][jplay]!=2)
                            iplay++;
                        break;
                }
            }
            else{
                switch(tecla){
                    case 37: 
                        if(jplay>0 && map[mapnumber][iplay][jplay-1]!=2)
                            jplay--;
                        break;
                    case 39: 
                        if(jplay<40 && map[mapnumber][iplay][jplay+1]!=2)
                            jplay++;
                        break;
                    case 38: 
                        if(iplay>0 && map[mapnumber][iplay-1][jplay]!=2)
                            iplay--;
                        break;
                    case 40: 
                        if(iplay<29 && map[mapnumber][iplay+1][jplay]!=2)
                            iplay++;
                        break;
                }
            }
            idplay=iplay*40+jplay+1;
            for(i=0; i<coins[mapnumber].length; i++){
                if(coins[mapnumber][i][0]==idplay && coins[mapnumber][i][1]==0){
                    coins[mapnumber][i][1]=1;
                    coinscoll++;
                    pts+=(difficult*100);
                    document.getElementById("points").innerHTML="Pontos: "+pts;
                }
            }
            for(i=0; i<monsters[mapnumber].length; i++){
                if(monsters[mapnumber][i][2]==idplay){
                    result=-2;
                    gameresult();
                }
            }
            if(iplay==endi && jplay==endj){
                mapcomplete++;
                if(mapcomplete==6){
                    result=3;
                }
                else{
                    result=2;
                }
                gameresult();
            }
            p=document.getElementById(idplay);
            p.className="jogador";
            tecla=0;
        }
    }
}
var tempcoins= new Array(5);
var tempmonsters= new Array(5);
for(i=0; i<5; i++){
    tempcoins[i]=[];
    tempmonsters[i]=[];
    tempcoins[i][0]=-1;
    tempcoins[i][1]=0;
    tempmonsters[i][0]=-1;
    tempmonsters[i][1]=-1;
    tempmonsters[i][2]=-1;
}
var inregist=0;
function movimedit(){
    if(saving==0){
        switch(map[nmaps][iplay][jplay]){
            case 1:
                p.className="chao";
                break;
            case 2:
                p.className="parede";
                break;
            case 4:
                p.className="coin";
                break;
            case 5:
                p.className="chao";
                break;
            case 6:
                p.className="chao";
                break;
        }
        switch(tecla){
            case 37: 
                if(jplay>0 && map[nmaps][iplay][jplay-1]!=2)
                    jplay--;
                break;
            case 39: 
                if(jplay<40 && map[nmaps][iplay][jplay+1]!=2)
                    jplay++;
                break;
            case 38: 
                if(iplay>0 && map[nmaps][iplay-1][jplay]!=2)
                    iplay--;
                break;
            case 40: 
                if(iplay<29 && map[nmaps][iplay+1][jplay]!=2)
                    iplay++;
                break;
        }
        tecla=0;
        idplay=iplay*40+jplay+1;
        p=document.getElementById(idplay);
        for(i=0; i<nmonsters; i++){
            if(tempmonsters[i][2]==idplay){
                result=-1;
                gameresult();
            }
        }
        if(iplay==endi && jplay==endj){
            result=1;
            gameresult();
        }
        p=document.getElementById(idplay);
        p.className="jogador";
    }
}
var idmuda=0, coinint=0;
function monstermove(){
    if(mode==2){
        for(i=0; i<nmonsters; i++){
            coinint=0;
            for(j=0; j<ncoins; j++){
                if(tempmonsters[i][2]==tempcoins[j][0]){
                    document.getElementById(tempmonsters[i][2]).className="coin";
                    coinint=1;
                }
            }
            if(coinint==0){
                document.getElementById(tempmonsters[i][2]).className="chao";
            }
            do{
                tempmonsters[i][1]=(Math.ceil(Math.random()*4));
                switch(tempmonsters[i][1]){
                    case 1:
                        idmuda=40;
                        break;
                    case 2:
                        idmuda=-1;
                        break;
                    case 3:
                        idmuda=1;
                        break;
                    case 4:
                        idmuda=-40;
                        break;
                }
            }while(document.getElementById(parseInt(tempmonsters[i][2])+parseInt(idmuda)).className=="parede" || document.getElementById(parseInt(tempmonsters[i][2])+parseInt(idmuda)).className=="fim");
            tempmonsters[i][2]=parseInt(tempmonsters[i][2])+parseInt(idmuda);
            document.getElementById(parseInt(tempmonsters[i][2])).className="monster"+tempmonsters[i][1];
            if(tempmonsters[i][2]==idplay){
                result=-1;
                gameresult();
            }
        }
    }
    else{
        nmonsters=0;
        ncoins=0;
        for(i=0; i<monsters[mapnumber].length; i++){
            if(monsters[mapnumber][i][0]!=-1){
                nmonsters++;
            }
        }
        for(i=0; i<coins[mapnumber].length; i++){
            if(coins[mapnumber][i][0]!=-1){
                ncoins++;
            }
        }
        for(i=0; i<nmonsters; i++){
            coinint=0;
            for(j=0; j<ncoins; j++){
                if(monsters[mapnumber][i][2]==parseInt(coins[mapnumber][j][0]) && coins[mapnumber][j][1]==0){
                    document.getElementById(monsters[mapnumber][i][2]).className="coin";
                    coinint=1;
                }
            }
            if(coinint==0){
                document.getElementById(monsters[mapnumber][i][2]).className="chao";
            }
            do{
                monsters[mapnumber][i][1]=(Math.ceil(Math.random()*4));
                switch(monsters[mapnumber][i][1]){
                    case 1:
                        idmuda=40;
                        break;
                    case 2:
                        idmuda=-1;
                        break;
                    case 3:
                        idmuda=1;
                        break;
                    case 4:
                        idmuda=-40;
                        break;
                }
            }while(document.getElementById(parseInt(monsters[mapnumber][i][2])+parseInt(idmuda)).className=="parede" || document.getElementById(parseInt(monsters[mapnumber][i][2])+parseInt(idmuda)).className=="fim");
            monsters[mapnumber][i][2]=parseInt(monsters[mapnumber][i][2])+parseInt(idmuda);
            document.getElementById(parseInt(monsters[mapnumber][i][2])).className="monster"+monsters[mapnumber][i][1];
            if(monsters[mapnumber][i][2]==idplay){
                result=-2;
                nmonsters=0;
                ncoins=0;
                gameresult();
            }
        }
    }
}
var result;
var copy;
function gameresult(){
    switch(result){ //case handling
        case -2:    //lose
            for(i=0; i<coins[mapnumber].length; i++){
                coins[mapnumber][i][1]=0;
            }
            for(i=0; i<monsters[mapnumber].length; i++){
                monsters[mapnumber][i][2]=monsters[mapnumber][i][0];
            }
            iplay=5;
            jplay=0;
            idplay=iplay*40+jplay+1;
            ncoins=0;
            nmonsters=0;
            mapnumber=0;
            coinscoll=0;
            for(i=0; i<nmaps; i++){
                mapuse[i]=0;
            }
            msg='<form name="registos" method="POST"><input class="nameuser" type="text" name="nome" placeholder="Insira o seu nome" autocomplete="off"><input type="hidden" name="time" value="'+tempoall+'"><input type="hidden" name="score" value="'+pts+'"><input type="submit" class="btn btn-dark ps-5 pe-5" name="registar" value="OK" onclick="refresher.submit();"></form>';
            document.getElementById("loser").style.display="block";
            document.getElementById("tabela").style.display="none";
            document.getElementById("stats").style.display="none";
            document.getElementById("loser").innerHTML="<h2>Perdeu. Tente Novamente!</h2><p>Tempo:<br>"+tempoall+"</p><p>Pontos:<br>"+pts+"</p>"+msg;
            mm1=c1=s1=m1=mm2=c2=s2=m2=0;
            pts=0;
            clearInterval(moves);
            clearInterval(timemap);
            clearInterval(timeall);
            break;
            case -1:
                for(i=0; i<nmonsters; i++){
                    coinint=0;
                    for(j=0; j<ncoins; j++){
                        if(tempmonsters[i][2]==tempcoins[j][0]){
                            document.getElementById(tempmonsters[i][2]).className="coin";
                            coinint=1;
                        }
                    }
                    if(coinint==0){
                        document.getElementById(tempmonsters[i][2]).className="chao";
                    }
                    tempmonsters[i][2]=tempmonsters[i][0];
                    document.getElementById(tempmonsters[i][0]).className="monster1";
                }	
                saving=1;
                iplay=5;
                jplay=0;
                idplay=iplay*40+jplay+1;
                p=document.getElementById(idplay);
                p.className="jogador";
                clearInterval(moves);
                break;
        case 1:
            for(i=0; i<ncoins; i++){
                coins[nmaps][i][0]=tempcoins[i][0];
                coins[nmaps][i][1]=tempcoins[i][1];
                tempcoins[i][0]=-1;
            }
            for(i=0; i<nmonsters; i++){
                monsters[nmaps][i][0]=tempmonsters[i][0];
                monsters[nmaps][i][1]=tempmonsters[i][1];
                monsters[nmaps][i][2]=tempmonsters[i][0];
                tempmonsters[i][0]=-1;
                tempmonsters[i][1]=-1;
                tempmonsters[i][2]=-1;
            }
            nmaps++;
            for(i=1; i<=4; i++){
                document.getElementById("button"+i).style.display="inline-block";
            }
            document.getElementById("tabela").style.display="none";
            document.getElementById("edit").style.display="none";
            document.getElementById("savemap").style.display="none";
            iplay=5;
            jplay=0;
            ncoins=0;
            nmonsters=0;
            idplay=iplay*40+jplay+1;
            p=document.getElementById(idplay);
            clearInterval(moves);
            break;
        case 2:
            for(i=0; i<coins[mapnumber].length; i++){
                coins[mapnumber][i][1]=0;
            }
            for(i=0; i<monsters[mapnumber].length; i++){
                monsters[mapnumber][i][2]=monsters[mapnumber][i][0];
            }
            iplay=5;
            jplay=0;
            idplay=iplay*40+jplay+1;
            ncoins=0;
            nmonsters=0;
            coinscoll=0;
            clearInterval(moves);
            clearInterval(timemap);
            mm2=c2=s2=m2=0;
            document.getElementById("mapcomplete").innerHTML="Mapa "+mapcomplete+"/5";
            geramap(difficult);
            break;
        case 3: // winn
            for(i=0; i<coins[mapnumber].length; i++){
                coins[mapnumber][i][1]=0;
            }
            for(i=0; i<monsters[mapnumber].length; i++){
                monsters[mapnumber][i][2]=monsters[mapnumber][i][0];
            }
            iplay=5;
            jplay=0;
            idplay=iplay*40+jplay+1;
            nmonsters=0;
            ncoins=0;
            coinscoll=0;
            for(i=0; i<nmaps; i++){
                mapuse[i]=0;
            }
            document.getElementById("winner").style.display="block";
            document.getElementById("tabela").style.display="none";
            document.getElementById("stats").style.display="none";
            pts+=difficult*500;
            msg='<form name="registos" method="POST"><input class="nameuser" type="text" name="nome" placeholder="Insira o seu nome" autocomplete="off"><input type="hidden" name="time" value="'+tempoall+'"><input type="hidden" name="score" value="'+pts+'"><input type="submit" class="btn btn-dark ps-5 pe-5" name="registar" value="OK" onclick="refresher.submit();"></form>';
            document.getElementById("winner").innerHTML="<h2>Parabéns! Ganhou!</h2><p>Tempo:<br>"+tempoall+"</p><p>Pontos:<br>"+pts+"</p>"+msg;
            clearInterval(moves);
            clearInterval(timemap);
            clearInterval(timeall);
            break;
    }
}
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