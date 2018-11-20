@include ('coupon.header')

<div class="title m-b-md">
sql - {{$sql}}
</div>

<p id="sqlresult"> result </p>

<button type="button" onclick="myquery()"> SQL </button>

<script>
function myquery() {
    alert("1");
    var xhttp = new XMLHttpRequest();
    alert("2");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sqlresult").innerHTML = this.responseText;
        }
    };

    alert("2");
    xhttp.open("GET", "/asql/select * from dual", true);
    alert("2");
    alert($sql);
    xhttp.send();
}
</script>

@include ('coupon.tail')
