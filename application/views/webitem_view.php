<div id="PageHeading">
        <?php  
        if(!is_string($data[0]))
        {
          $user = $data[0]->fetch_assoc();
        }
        $result = $data[1]->fetch_assoc();
        ?>

    	  <h1><?php if (!is_string($data[0])) {
         echo escape($user['first_name'])."&nbsp";  echo escape($user['last_name']);
        } ?></h1>
      </div>
      <?php if(isset($_SESSION['Username'])) { ?>
    	<div id="content_top">        
    	  <h2><a href="/account/">Account</a></h2>
    	</div>
      <?php } ?>
    <div id="content_bottom">
      <table  class="width-670 center width_auto">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td><table id="selected_user" class="table_style center width_auto">
            <tr>
              <td align="left" valign="top"></td>
              <td align="right" valign="top">Registration date : </td>
            </tr>
            <tr>
              <td>Title: <?php echo escape($result['title']); ?></td>
              <td><?php echo escape($result['registration']); ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $result['url']; ?>"> <?php echo escape($result['url']); ?></a></td>
              <td width="150" height="150" rowspan="3" class="border_left">
			  <a class="fancybox"  href="../../<?php echo $result['preview_thumb']; ?>">
			  <img src="../../<?php echo $result['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo escape($result['language']); ?></td>
              </tr>
            <tr>
              <td align="left" valign="bottom">Description:</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><?php echo escape($result['description']); ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
</div>