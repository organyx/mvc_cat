
    <?php $user = $data->fetch_assoc(); ?>

      <div id="PageHeading">
    	  <h1>Welcome,  <?php echo escape($user['first_name']); ?> <?php echo escape($user['last_name']); ?>!</h1>
      </div>

    	<div id="contentLeft">
          <?php if ($_SESSION['lvl'] == 2) { ?>
          <h2><a href="/admin">Manage Users</a></h2><br>
          <?php } ?>
    	  <h2><a href="/update">Update Account</a></h2><br>
    	  <h2><a href="/account/logout">Log Out</a></h2>
    	</div>

    <div id="contentRight">
      <table class="width-670 center WidthAuto">
        <tr>
          <td align="center">Account: <?php echo $user['email']; ?></td>
        </tr>
        <tr>
          <td><table class="width-500 TableStyle center WidthAuto">
            <tr>
              <td><?php echo ($user['approval'] == "0000-00-00 00:00:00") ? "Awaiting Approval" : "Approved" ?></td>
              <td align="right" valign="top">Registration date : </td>
            </tr>
            <tr>
              <td>Title: <?php echo $user['title']; ?></td>
              <td><?php echo $user['registration']; ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $user['url']; ?>"> <?php echo $user['url']; ?></a></td>
              <td width="150" height="150" rowspan="3" class="TableStyleBorderLeft">
        			  <a class="fancybox"  href="../../<?php echo $user['preview_thumb']; ?>">
        			  <img src="../../<?php echo $user['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo $user['language']; ?></td>
              </tr>
            <tr>
              <td>Description:</td>
              </tr>
            <tr>
              <td colspan="2"><?php echo $user['description']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>