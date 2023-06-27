var canvas1 = document.getElementById('ochart1');
var canvas2 = document.getElementById('ochart2');

fitToContainer(canvas1);
fitToContainer(canvas2);

function fitToContainer(canvas){
// Make it visually fill the positioned parent
canvas.style.width ='100%';
canvas.style.height='100%';
// ...then set the internal size to match
canvas.width  = canvas.offsetWidth;
canvas.height = canvas.offsetHeight;
}

var ctx = canvas1.getContext('2d');
var rgbSeries = [
    "<?=$data_colors[0]?>", 
    "<?=$data_colors[1]?>", 
    "<?=$data_colors[2]?>", 
    "<?=$data_colors[3]?>", 
    "<?=$data_colors[4]?>"];
var data = [
    [<?=$data[0]?>, <?=$data[1]?>, <?=$data[2]?>, <?=$data[3]?>],
    [<?=$data[4]?>, <?=$data[5]?>, <?=$data[6]?>, <?=$data[7]?>],
    [<?=$data[8]?>, <?=$data[9]?>, <?=$data[10]?>, <?=$data[11]?>],
    [<?=$data[12]?>, <?=$data[13]?>, <?=$data[14]?>, <?=$data[15]?>]
    ];
var saymons = ["<?=$data3_days[0]?>", "<?=$data3_days[1]?>", "<?=$data3_days[2]?>", "<?=$data3_days[3]?>"];    
const xBar = 45;
const xBetween = 1;
const pBetween = <?=$xspace ?>;
const xRight = 600;
const yBottom = 300;
const yTitleBottom = 330;
const points = 3;
// const series = 4;
const show_total = <?=$show_total?>;
const series = <?=$series ?>;
var x, y;
let idx;

ctx.lineWidth = 1;
ctx.strokeStyle = "#F0F0F0";

ctx.beginPath();
for(ix=0;ix<10;++ix) {
    y = ix*30+1;
    ctx.moveTo(0,  y);
    ctx.lineTo(xRight, y );
}
y += 28;
ctx.moveTo(0,  y);
ctx.lineTo(xRight, y );
ctx.stroke();

// border color
ctx.strokeStyle = "white";
ctx.font = "14px Arial";

for(ip=0;ip<points;++ip) {
    x0 = ip*((xBar+xBetween)*series+pBetween);
    idx = points - ip;
    for(ix=show_total; ix < series+show_total; ++ix) {

        ctx.fillStyle = rgbSeries[ix];
        x = ip*((xBar+xBetween)*series+pBetween) + ix*(xBar+xBetween);
        y = -data[idx][ix] * <?=$multy ?>;
        ctx.fillRect(x, yBottom, xBar, y);
        ctx.strokeRect(x, yBottom, xBar, y);
        //ctx.textAlign = "center";            
        ctx.fillText(data[idx][ix],x+2,yBottom + y - 5);
    }
    ctx.fillStyle = "#090909";
    ctx.fillText(saymons[idx],x0+2, yTitleBottom - 10);
}
// - - - - - - - - - - - - - - - - -
data = data[0]; // 15, 30, 80];
var total = -data[0]; // without 1st sum
data.forEach(element => {
    total += element;
});

ctx = canvas2.getContext('2d');
ctx.font = "14px Arial";
ctx.textAlign = "center";
var circle = 2 * Math.PI;
var end = circle / 4 * 3;
var centerX = 250, centerY = 150;
var radius = 125;
var sradius = 80;
ctx.strokeStyle = "white";
// let bk_clr = $('body').css('background-color');
// // let bk_clr = $('body').css('background-color');
// let bk_clr = document.body.style.backgroundColor;
// alert(bk_clr );
// bk_clr = 'rgb(255,100, 0)';
var grd = ctx.createRadialGradient(centerX, centerY, 90, centerX, centerY, 145);
grd.addColorStop(0, "<?=$data_colors[4] ?>");
// grd.addColorStop(1, "'"+bk_clr.toString()+"'" ); //"<?=$data_colors[5] ?>"); //"white");
// grd.addColorStop(1, bk_clr ); //"<?=$data_colors[5] ?>"); //"white");
grd.addColorStop(1, "<?=$data_colors[5] ?>"); //"white");

// Fill with gradient
ctx.fillStyle = grd;
ctx.fillRect(0, 0, 500, 300); 
ctx.lineWidth = 2;
var gdata = Array(3);
for(i=0;i<series;++i) {
    gdata[i] = data[i+1] / total * circle; 
    if(data[i+1] <= 0) continue;
    ctx.fillStyle = rgbSeries[i+1];
    start = end - gdata[i];
    ctx.beginPath();
    ctx.moveTo(centerX,centerY);
    ctx.arc(centerX, centerY, radius, start, end);
    ctx.closePath();
    ctx.fill();
    ctx.stroke();  
    angle = circle - start - gdata[i]/2;
    y = centerY - Math.sin(angle) * sradius;  
    x = centerX + Math.cos(angle) * sradius;  
    ctx.fillStyle = 'white';
    ctx.fillText(data[i+1], x, y);
    //ctx.arc(150, 150, 140, start, end);
    end -= gdata[i];
}
