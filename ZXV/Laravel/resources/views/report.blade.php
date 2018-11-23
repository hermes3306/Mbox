<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<script>
			$(document).ready(function() {
				/*
				$("a").click(function(){
					$("#div1").hide("slow");
				});
				*/
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
                <div class="top-left title m-b-md">
                    IOT Database - Report
                </div>

                <div class="links top-right">
                    <a href="#" onclick="mycoupon(0)">Coupon</a>
                    <a href="#" onclick="mycoupon(1)">1</a>
                    <a href="#" onclick="mycoupon(2)">R</a>
                    <a href="#" onclick="mycoupon(3)">L</a>
                    <a href="#" onclick="mycoupon(4)">H</a>

                    <a href="#" onclick="myvisitor(0)">Visitor</a>
                    <a href="#" onclick="myvisitor(1)">1</a>
                    <a href="#" onclick="myvisitor(2)">2</a>
                    <a href="#" onclick="myvisitor(3)">3</a>
                    <a href="#" onclick="myvisitor(4)">4</a>
                </div>

				<div id="mycontent" class="mycontent center">
					Contents
				</div>
        </div>
    </body>
</html>



<script>
function mycoupon(ty) {
	var sql="select * from Coupons ";
	if(ty != 0) sql= sql + "where type = " + ty;
	alert(sql);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asql/" + sql , true);
    xhttp.send();
}


function myvisitor(ty) {
	var sql="select * from Visitors ";
	if(ty == 1) sql += "where mail_ty = '1회방문'";
	if(ty == 2) sql += "where mail_ty  in ('2회방문', '3회방문', '4회방문')";
	if(ty == 3) sql += "where mail_ty  in ('우수고객','5회이상')";
	if(ty == 4) sql += "where mail_ty = '휴먼고객'";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/asql/" + sql , true);
    xhttp.send();
}
</script>
