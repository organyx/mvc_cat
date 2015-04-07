<div id="PageHeading">
      <h1>Main</h1>
</div>
    <?php 

    $pages = $data[1];
    // echo "<pre>".print_r($pages[])."</pre>";
    if(isset($_SESSION['Username'])) { ?>
    
<div id="contentLeft">
    <h2><a href="/account">Account</a></h2>
</div>
     <?php }; ?>

     
<div id="contentRight">
    <table class="width-670 center WidthAuto">
        <tr>
            <select id="perPage_html">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </select>
            <input type="hidden" value="<?php echo $data[1]['startRow']?>" id="startRow">
            <input type="hidden" value="<?php echo $data[1]['pageNum']?>" id="pageNum">
            <!-- <input type="hidden" value="<?php echo $data[1]['maxRows']?>" id="maxRows"> -->
            <input type="hidden" value="<?php echo $data[1]['totalRows']?>" id="totalRows">
            <input type="hidden" value="<?php echo $data[1]['totalPages']?>" id="totalPages">
            <td align="right" valign="top" id="top_row">Showing:
            <span id="result_start_page"><?php echo ($data[1]['startRow'] + 1) ?></span> to <span id="result_end_page"><?php echo min($data[1]['startRow'] + $data[1]['maxRows'], $data[1]['totalRows']) ?></span> of <span id="result_total"><?php echo $data[1]['totalRows'] ?></span>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
            <?php $i = 0; while ($row = $data[0]->fetch_assoc()) { ?>
                <table border="1" class="width-630 TableStyle center WidthAuto <?php echo 'cl_table'.$i ?>">
                    <tr>
                        <td></td>
                        <td width="400" height="50" align="center" ><h2><a href="/webitem/index/?site=<?php echo urlencode($row['userID']);?>" class="main_item_href <?php echo 'cl_item'.$i ?>"><span class="main_item_title <?php echo 'cl_title'.$i ?>"><?php echo $row['title']; ?></span></a></h2></td>
                        <td width="150" rowspan="2" align="center" ><a class="fancybox main_item_img_href <?php echo 'cl_img_href'.$i ?>"  href="../../<?php echo $row['preview_thumb']; ?>"> <img src="../../<?php echo $row['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail main_item_img_src <?php echo 'cl_img_src'.$i ?>"/></a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td height="50" align="center" ><a href="<?php echo $row['url']; ?>" class="main_item_url <?php echo 'cl_url_href'.$i ?>"><span class="main_item_url <?php echo 'cl_url'.$i ?>"><?php echo $row['url']; ?></span></a></td>
                    </tr>
                </table>
                <br>
                <?php $i++; }  ?>
               </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                <form method="POST">
                    <?php if ($data[1]['pageNum'] > 0) { // Show if not first page ?>
                    <a href="#" id="previous">Previous</a>
                    <?php } // Show if not first page ?>
                    |
                    <?php if ($data[1]['pageNum'] < $data[1]['totalPages']) { // Show if not last page ?>
                    <a href="#" id="next">Next</a>
                    <?php } // Show if not last page ?>
                </form>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript" src="../../assets/js/index.js"></script>
