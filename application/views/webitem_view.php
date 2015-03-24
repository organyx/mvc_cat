<div id="PageHeading">
    	  <h1><?php echo $data['first_name'][0]; ?> <?php echo $data['last_name'][0]; ?></h1>
      </div>
      <?php if(isset($_SESSION['MM_Username'])) { ?>
    	<div id="contentLeft">        
    	  <h2><a href="Account.php">Account</a></h2><br>
    	  <br>
    	</div>
      <?php } ?>
    <div id="contentRight">
      <table  class="width-670 center WidthAuto">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td><table id="selectedUser" class="TableStyle center WidthAuto">
            <tr>
              <td align="left" valign="top"></td>
              <td align="right" valign="top">Registration date : </td>
            </tr>
            <tr>
              <td>Title: <?php echo $data['title']; ?></td>
              <td><?php echo $data['registration']; ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $data['url']; ?>"> <?php echo $data['url']; ?></a></td>
              <td width="140" height="140" rowspan="3" class="TableStyleBorderLeft">
			  <a class="fancybox"  href="<?php echo $data['preview_thumb']; ?>">
			  <img src="<?php echo $data['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo $data['language']; ?></td>
              </tr>
            <tr>
              <td align="left" valign="bottom">Description:</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><?php echo $data['description']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
</div>