@include ('coupon.style')

<body>

<div class="top-right links">

<text id="msg"> <font color="00FFFF"> </font></text>

<button type="button" onclick="backup()"> backup asyn. </button>
<script>
function backup() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
    	    document.getElementById("msg").innerHTML = this.responseText;
         }
    };
    xhttp.open("GET", "/sheet/abackup", true);
    xhttp.send();
}
</script>

<a href='/'>all</a> 
<a href='/show/1'>1</a> 
<a href='/show/2'>2</a> 
<a href='/show/3'>3</a> 
<a href='/show/4'>4</a> 
<a href='/sheet/view'>sheet<a>
<a href='/sheet/backup'>backup<a>

<select id="yymmdd" onchange="myFunction()">
<?php
	$inx=0;
	foreach($yymmdds as $y) {
		if(count($yymmdds) ==  ($inx+1)) {
			print("<option value='$y->yymmdd' selected>$y->yymmdd</option>");
		}else {
			print("<option value='$y->yymmdd'>$y->yymmdd</option>");
		}
		$inx = $inx+1;
	}
?>
</select>

<a id="a0" href='/showbackup/0/{{$yymmdd}}'>all</a> 
<a id="a1" href='/showbackup/1/{{$yymmdd}}'>1</a> 
<a id="a2" href='/showbackup/2/{{$yymmdd}}'>2</a> 
<a id="a3" href='/showbackup/3/{{$yymmdd}}'>3</a> 
<a id="a4" href='/showbackup/4/{{$yymmdd}}'>4</a> 
<a href='/sql'>sql</a>

</div>

<script>
function myFunction() {
    var x = document.getElementById("yymmdd");
    var i = x.selectedIndex;
    var s = x.options[i].text;

    document.getElementById("a0").href = "/showbackup/0/" + s;
    document.getElementById("a1").href = "/showbackup/1/" + s;
    document.getElementById("a2").href = "/showbackup/2/" + s;
    document.getElementById("a3").href = "/showbackup/3/" + s;
    document.getElementById("a4").href = "/showbackup/4/" + s;
}
</script>

