@include ('coupon.header')

<div id="mytitle" class="title m-b-md">
show - {{$type}}
</div>

<div id="mycontent" class="content">
<table>
<tr>
<th>coupon</th>
<th>type</th>
<th>userid</th>
<th>email</th>
<th>created_at</th>
<th>issued_at</th>
<th>sent_at</th>
<th>used_at</th>
</tr>
<?php
	foreach ($coupons as $c) {
		print("<tr>");
		print("<td>$c->coupon</td>");
		print("<td>$c->type</td>");
		print("<td>$c->userid</td>");
		print("<td>$c->email</td>");
		print("<td>$c->created_at</td>");
		print("<td>$c->issued_at</td>");
		print("<td>$c->sent_at</td>");
		print("<td>$c->used_at</td>");
		print("</tr>");
	}
?>
</table>
</div>

@include ('coupon.tail')
