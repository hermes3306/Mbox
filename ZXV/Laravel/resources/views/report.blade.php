<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<script>
			$(document).ready(function() {
				myinit();

			});
		</script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IOT Database - Report</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            table {
        width: 100%;
        border-top: 1px solid #C0C0C0;
        border-collapse: collapse;

            }

            th {
        background-color: #C0C0C0;
        border-bottom: 1px solid #C0C0C0;
        padding: 10px;
            }

            td {
        border-bottom: 1px solid #C0C0C0;
        padding: 10px;
            }


            .full-height {
                height: 100vh;
            }

            .flex-top {
                left: 20px;
                align-items: top;
                display: flex;
                justify-content: top;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 20px;
                top: 20px;
            }

            .top-left {
                position: absolute;
                left: 20px;
                top: 20px;
            }

            .mycontent {
                position: absolute;
                left: 40px;
                top: 100px;
			}

            .content {
                text-align: center;
            }

            .title {
                font-size: 30px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 15px;
                font-size: 10px;
                font-weight: 600;
                letter-spacing: .03rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="div1">
            <div class="content">
                <div id="mytitle"  class="top-left title m-b-md">
                    IOT Database - Report
                </div>

                <div class="links top-right">
                    <a href="#" onclick="mycoupon(0)">Coupon</a>
                    <a href="#" onclick="mycoupon(1)">1</a>
                    <a href="#" onclick="mycoupon(2)">R</a>
                    <a href="#" onclick="mycoupon(3)">L</a>
                    <a href="#" onclick="mycoupon(4)">H</a>

					<a href="#" onclick="mysheet()"> Sheet </a>
					<a href="#" onclick="mybackup()"> Backup </a>
                    <a href="#" onclick="myvisitor(0)">Visitor</a>
					<select id="myyymmdd" onchange="myyymmdd2()"> </select>	
                    <a href="#" onclick="myvisitor(1)">1</a>
                    <a href="#" onclick="myvisitor(2)">2</a>
                    <a href="#" onclick="myvisitor(3)">3</a>
                    <a href="#" onclick="myvisitor(4)">4</a>
                </div>

				<div id="mycontent" class="mycontent center">
				</div>
        </div>
    </body>
</html>



<script>
function myinit() {
	myyymmdd();
	mycoupon(0);
}

function myyymmdd() {
	var sql="select distinct yymmdd from Visitors order by yymmdd desc  ";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("myyymmdd").innerHTML = this.responseText;

        }
    };
    xhttp.open("GET", "/asql/" + sql + "/option" , true);
    xhttp.send();
}

function myyymmdd2() {
 	var x = document.getElementById("myyymmdd");
	var i = x.selectedIndex;
	var s = x.options[i].text;

	var sql="select * from Visitors where yymmdd = '" + s + "'";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asql/" + sql + "/table" , true);
    xhttp.send();
}

function mycoupon(ty) {
	var tstr = "Coupon";	
	if(ty != 0) {
		if(ty == 1) tstr = tstr + " - 1st visitors";
		if(ty == 2) tstr = tstr + " - repeat visitors";
		if(ty == 3) tstr = tstr + " - loyal visitors";
		if(ty == 4) tstr = tstr + " - inactive visitors";
	}
 
	document.getElementById("mytitle").innerHTML = tstr;

	var sql="select * from Coupons ";
	if(ty != 0) sql= sql + "where type = " + ty;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asql/" + sql + "/table" , true);
    xhttp.send();
}

function mysheet() {
	document.getElementById("mytitle").innerHTML = "Sheet";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asheet/" , true);
    xhttp.send();
}


function mybackup() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			alert("Backup completed...");
        }
    };
    xhttp.open("GET", "/sheet/abackup/", true);
    xhttp.send();
}

function myvisitor(ty) {
    var x = document.getElementById("myyymmdd");
    var i = x.selectedIndex;
    var yymmdd = x.options[i].text;
	var tstr = "Visitors";

	if(ty != 0) {
		tstr = "";
		if(ty == 1) tstr = tstr + "1st visitors";
		if(ty == 2) tstr = tstr + "Repeat visitors";
		if(ty == 3) tstr = tstr + "Loyal visitors";
		if(ty == 4) tstr = tstr + "Inactive visitors";
	}
	tstr = tstr + " on " + yymmdd;
	document.getElementById("mytitle").innerHTML = tstr;


	var sql="select * from Visitors where yymmdd = '" +  yymmdd + "' ";
	if(ty == 1) sql += "and mail_ty = '1회방문'";
	if(ty == 2) sql += "and mail_ty  in ('2회방문', '3회방문', '4회방문')";
	if(ty == 3) sql += "and mail_ty  in ('우수고객','5회이상')";
	if(ty == 4) sql += "and mail_ty = '휴먼고객'";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asql/" + sql + "/table" , true);
    xhttp.send();
}
</script>
