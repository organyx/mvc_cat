<div id="PageHeading">
      <h1>Main</h1>
</div>
    <?php 
    if(isset($_SESSION['MM_Username'])) { ?>
    
<div id="contentLeft">
    <h2><a href="/account">Account</a></h2>
</div>
     <?php }; ?>

     
<div id="contentRight">
    <table class="width-670 center WidthAuto">
        <tr>
            <td align="center" valign="top">
            <!--
            <pre><?php print_r($data)  ?></pre>
            -->
            <?php while ($row = $data->fetch_assoc()) { ?>
                <table border="1" class="width-630 TableStyle center WidthAuto">
                    <tr>
                        <td></td>
                        <td width="400" height="50" align="center" ><h2><a href="/webitem/index/?site=<?php echo urlencode($row['userID']);?>"><?php echo $row['title']; ?></a></h2></td>
                        <td width="200" rowspan="2" align="center" ><a class="fancybox"  href="<?php echo $row['preview_thumb']; ?>"> <img src="<?php echo $row['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail"/></a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td height="50" align="center" ><a href="<?php echo $row['url']; ?>"><?php echo $row['url']; ?></a></td>
                    </tr>
                </table>
                <br>
                <?php }  ?>
               </td>
        </tr>
    </table>
</div>