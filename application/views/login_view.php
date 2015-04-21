


<div id="PageHeading">
      <h1>Autorization page</h1>
</div>     
<div id="content_bottom">
	<div class="center" id="login">
		<p>
			<form action="" method="post">
				<table class="center">
					<tr>
						<th colspan="2">Autorization</th>
					</tr>
					<tr>
						<td><label for="login_input">Login</label></td>
						<td><input type="text" name="login" id="login_input"></td>
					</tr>
					<tr>
						<td><label for="password_input">Password</label></td>
						<td><input type="password" name="password" id="password_input"></td>
					</tr>
					<th id="thead" colspan="2">
						<input type="submit" value="Enter" name="btn" style="width: 150px; height: 30px;">
					</th>
				</table>
			</form>
		</p>
		<div id="login_msg">
			<?php extract($data); ?>
			<?php if($login_status=="access_granted") { ?>
			<p style="color:green">Autorization successful.</p>
			<?php } elseif($login_status=="access_denied") { ?>
			<p style="color:red">Username or/and Password is incorrect.</p>
			<?php } ?>
		</div>
	</div>
</div>