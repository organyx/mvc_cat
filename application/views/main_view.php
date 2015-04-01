<div id="PageHeading">
      <h1>Main</h1>
</div>
    <?php 
    if(isset($_SESSION['Username'])) { ?>
    
<div id="contentLeft">
    <h2><a href="/account">Account</a></h2>
</div>
     <?php }; ?>

     
<div id="contentRight">
    <table class="width-670 center WidthAuto">
        <tr>
            <td align="right" valign="top">Showing:&nbsp;<?php echo ($data[1]['startRow'] + 1) ?> to <?php echo min($data[1]['startRow'] + $data[1]['maxRows'], $data[1]['totalRows']) ?> of <?php echo $data[1]['totalRows'] ?></td>
        </tr>
        <tr>
            <td align="center" valign="top">
            <?php while ($row = $data[0]->fetch_assoc()) { ?>
                <table border="1" class="width-630 TableStyle center WidthAuto">
                    <tr>
                        <td></td>
                        <td width="400" height="50" align="center" ><h2><a href="/webitem/index/?site=<?php echo urlencode($row['userID']);?>"><?php echo $row['title']; ?></a></h2></td>
                        <td width="150" rowspan="2" align="center" ><a class="fancybox"  href="../../<?php echo $row['preview_thumb']; ?>"> <img src="../../<?php echo $row['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail"/></a></td>
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
        <tr>
            <td align="right" valign="top">
                <?php if ($data[1]['pageNum'] > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum=%d%s", $data[1]['currentPage'], max(0, $data[1]['pageNum'] - 1), $data[1]['queryString']); ?>">Previous</a>
                <?php } // Show if not first page ?>
                |
                <?php if ($data[1]['pageNum'] < $data[1]['totalPages']) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum=%d%s", $data[1]['currentPage'], min($data[1]['totalPages'], $data[1]['pageNum'] + 1), $data[1]['queryString']); ?>">Next</a>
                <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>
</div>
