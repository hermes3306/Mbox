@include ('coupon.header')

<div class="title m-b-md">
sql
</div>

<input type="text" id="sqlin" size=35 value="select * from Visitors">
<button type="button" onclick="myquery()"> Execute </button>

<p id="sqlresult">  </p>


<script>
function myquery() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sqlresult").innerHTML = this.responseText;
        }
    };

    var sql = document.getElementById("sqlin").value;
    xhttp.open("GET", "/asql/" + sql , true);
    xhttp.send();
}
</script>

@include ('coupon.tail')
