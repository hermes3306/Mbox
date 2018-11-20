@include ('coupon.header')

<div class="title m-b-md">
sql - {{$type}}
</div>

<p id="result"> </p>

<button type="button" onclick="mysql()"> SQL </button>
<script>
function mysql() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
         }
    };
    xhttp.open("GET", "/asql" . "?q='select * from Visitors'", true);
    xhttp.send();
}
</script>

@include ('coupon.tail')
