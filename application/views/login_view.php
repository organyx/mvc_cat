<h1>Autorization page</h1>
<p>
<form action="" method="post">
<table class="login">
	<tr>
		<th colspan="2">Autorization</th>
	</tr>
	<tr>
		<td>Login</td>
		<td><input type="text" name="login"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password"></td>
	</tr>
	<th colspan="2" style="text-align: right">
	<input type="submit" value="Enter" name="btn"
	style="width: 150px; height: 30px;"></th>
</table>
</form>
</p>

<?php extract($data); ?>
<?php if($login_status=="access_granted") { ?>
<p style="color:green">Autorization successful.</p>
<?php } elseif($login_status=="access_denied") { ?>
<p style="color:red">Username or/and Password is incorrect.</p>
<?php } ?>
