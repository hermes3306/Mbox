@include ('coupon.header')

<div id="mytitle" class="title m-b-md">
sql
</div>

<input type="text" id="sqlin" size=85 value="SELECT *FROM sqlite_master WHERE type = 'table'">
<button type="button" onclick="myquery()"> Execute </button>




<script>
function myquery() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mycontent").innerHTML = this.responseText;
        }
    };

    var sql = document.getElementById("sqlin").value;
    xhttp.open("GET", "/asql/" + sql + "/table" , true);
    xhttp.send();
}
</script>

<div id="mycontent" class="content">
</div>

@include ('coupon.tail')
