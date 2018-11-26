@include ('coupon.style')

<body>

<div id="myheader" class="top-right links">

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

<!-- backup - date -->
<select id="yymmdd" onchange="myFunction()">
<?php
	$inx=0;
	foreach($yymmdds as $y) {
		if(count($yymmdds) ==  ($inx+1)) {
			print("<option value='$y->yymmdd'>$y->yymmdd</option>");
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

<!-- sql table list -->
<select id="tables" onchange="myTables()">
<?php
	foreach($tables as $t) {
		print("<option value='$y->yymmdd'>$t->name</option>");
	}
?>
</select>

</div>

<script>
function myFunction() {
    var x = document.getElementById("yymmdd");
    var i = x.selectedIndex;
    var s = x.options[i].text;
	var sql = "select * from Visitors where yymmdd ='" + s + "'";

    document.getElementById("a0").href = "/showbackup/0/" + s;
    document.getElementById("a1").href = "/showbackup/1/" + s;
    document.getElementById("a2").href = "/showbackup/2/" + s;
    document.getElementById("a3").href = "/showbackup/3/" + s;
    document.getElementById("a4").href = "/showbackup/4/" + s;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mytitle").innerHTML = "backup - " + s ;
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };

	//alert("sql" + sql);

    xhttp.open("GET", "/asql/" + sql , true);
    xhttp.send();
}

function myTables() {
	var x = document.getElementById("tables");
	var i = x.selectedIndex;
	var s = x.options[i].text;
	var sql = "select * from " + s ;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mytitle").innerHTML = "table - " + s ;
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };

	xhttp.open("GET", "/asql/" + sql +"/table", true);
	xhttp.send();
}
</script>
