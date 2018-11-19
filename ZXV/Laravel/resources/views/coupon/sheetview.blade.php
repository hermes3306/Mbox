@include ('coupon.header')

<div class="title m-b-md">
sheet
</div>
<div class="content">
<table>
<tr>
<th>id</th>
<th>sns</th>
<th>email</th>
<th>collect_dt</th>
<th>visit_cnt</th>
<th>visit_dt</th>
<th>mail_ty</th>
<th>coupon_num</th>
<th>fv_mail_dt</th>
<th>rv_mail_dt</th>
<th>lv_mail_dt</th>
<th>hv_mail_dt</th>
<th>coupon_used_dt</th>
</tr>
<?php
	foreach ($visitors as $v) {
		print("<tr>");
		print("<td>$v->id</td>");
		print("<td>$v->sns</td>");
		print("<td>$v->email</td>");
		print("<td>$v->collect_dt</td>");
		print("<td>$v->visit_cnt</td>");
		print("<td>$v->visit_dt</td>");
		print("<td>$v->mail_ty</td>");
		print("<td>$v->coupon_num</td>");
		print("<td>$v->fv_mail_dt</td>");
		print("<td>$v->rv_mail_dt</td>");
		print("<td>$v->lv_mail_dt</td>");
		print("<td>$v->hv_mail_dt</td>");
		print("<td>$v->coupon_used_dt</td>");
		print("</tr>");
	}
?>
</table>
</div>

@include ('coupon.tail')
