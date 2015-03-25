<div id="PageHeading">
        <?php  
        if(!is_string($data[0]))
        {
          $user = $data[0]->fetch_assoc();
        }
        $result = $data[1]->fetch_assoc();
        //echo $result['registration'] . "++++";
        ?>

    	  <h1><?php if (!is_string($data[0])) {
         echo $user['first_name']."&nbsp";  echo $user['last_name'];
        } ?></h1>
      </div>
      <?php if(isset($_SESSION['MM_Username'])) { ?>
    	<div id="contentLeft">        
    	  <h2><a href="Account.php">Account</a></h2><br>
    	  <br>
    	</div>
      <?php } 
      
      //echo "<pre>".print_r($result['title'])."</pre>";
      
      ?>
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
              <td>Title: <?php echo $result['title']; ?></td>
              <td><?php echo $result['registration']; ?></td>
            </tr>
            <tr>
              <td>URL: <a target="_blank" href="<?php echo $result['url']; ?>"> <?php echo $result['url']; ?></a></td>
              <td width="140" height="140" rowspan="3" class="TableStyleBorderLeft">
			  <a class="fancybox"  href="../../<?php echo $result['preview_thumb']; ?>">
			  <img src="../../<?php echo $result['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
              </td>
            </tr>
            <tr>
              <td>Languages: <?php echo $result['language']; ?></td>
              </tr>
            <tr>
              <td align="left" valign="bottom">Description:</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><?php echo $result['description']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
</div>