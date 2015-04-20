<?php 	
    $user = $data[0]->fetch_assoc();
		$manage_users = $data[1][0]->fetch_assoc(); 
		$totalRows_users = $data[1][0]->num_rows; 
		//echo "<pre>".print_r($manage_users)."</pre>";
    $editFormAction = "/admin/index/";
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
		?>
<div id="PageHeading">
	<h1><?php echo escape($user['first_name']); ?> <?php echo escape($user['last_name']); ?></h1>
</div>

<div id="contentLeft">
          <?php if ($_SESSION['lvl'] == 2) { ?>
          <h2><a href="/admin/">Manage Users</a></h2><br>
          <?php } ?>
    	  <h2><a href="/update/">Update Account</a></h2><br>
    	  <h2><a href="/admin/logout/">Log Out</a></h2>
</div>

<div id="contentRight">
	<div id="user_search">
		<div id="grid" class="search">
			<form id="searchForm" class="searchForm" method="post" action="javascript:void(null);">  
		    <label for="email">Find User: </label>
		    <input type="text" id="email" class="email" name="email" placeholder="Email..." />
		    <button type="submit" id="btnSearch" class="btnSearch">Search</button>  
		    <button type="button" id="reset" class="reset">Reset</button>  
		</form>
		</div>

		<div class="ret" id="ret">
      <br>
      <div id="result" class="result"></div>
      <br>
      <div id="returnmessage" class="returnmessage"></div>
      <br>
      <table class="width-700 center WidthAuto off" id="result_table">
                <tr>
                  <td align="center">Account: </td>
                </tr>
                <tr>
                  <td>
                    <table class="width-500 TableStyle center WidthAuto">
                      <tr>
                        <td valign="top">Status : <span id="found_approval"></span></td>
                        <td align="right" valign="top">Registration date : </td>
                      </tr>
                      <tr>
                        <td>Title: <span id="found_title"></span> </td>
                        <td><span id="found_reg"></span></td>
                      </tr>
                      <tr>
                        <td>URL: <a id="found_url_href" target="_blank"><span id="found_url"></span></a></td>
                        <td width="150" height="150" rowspan="3" class="TableStyleBorderLeft">
                  <a class="fancybox" id="found_img_href"  href="../../">
                  <img src="../../" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail" id="found_img">
                        </td>
                      </tr>
                      <tr>
                        <td>Languages: <span id="found_lang"></span></td>
                        </tr>
                      <tr>
                        <td>Description: </td>
                        </tr>
                      <tr>
                        <td colspan="2"><span id="found_descr"></span></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                      <tr>
                        <td>
                          <div class="list">
                            <table class="center">
                              <tr>
                                <td>
                                  <form class="DeleteUserForm" name="DeleteUserForm" method="POST">
                                    <input name="DeleteUserHiddenField" type="hidden"  class="DeleteUserHiddenField" value="">
                                    <input type="submit" name="DeleteUserButton"  class="DeleteUserButton" value="Delete User">
                                  </form>
                                </td>
                                <td>
                                  <form class="ApproveUserForm" name="ApproveUserForm" method="POST">
                                    <input name="ApproveUserHiddenField" type="hidden"  class="ApproveUserHiddenField" value="CURRENT_TIMESTAMP()">
                                    <input name="ApproveIDhiddenField" type="hidden"  class="ApproveIDhiddenField" value="">
                                    <input type="submit" name="ApproveUserButton"  class="ApproveUserButton" value="Approve User">
                                  </form>
                                </td>
                              </tr>
                            </table>
                          </div>
                        </td>
                      </tr>
              </table>
      <br>
      
			
		</div>

	</div>
	<div id="user_list">
		<table class="width-670 center WidthAuto">
        <tr>
          <td align="center" valign="top">
            <table width="200px">
              <tr><td>Total records:</td><td align="right"><?php echo $data[1][1]['totalRows'] ?></td></tr>
              <tr><td>Approved records:</td><td align="right"><?php echo $data[1][1]['totalApproved'] ?></td></tr>
              <tr><td>Awaiting approval:</td><td align="right"><?php echo $data[1][1]['totalAwaiting'] ?></td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top">Showing:&nbsp;<?php echo ($data[1][1]['startRow'] + 1) ?> - <?php echo min($data[1][1]['startRow'] + $data[1][1]['maxRows'], $data[1][1]['totalRows']) ?> of <?php echo $data[1][1]['totalRows'] ?></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php $i=0; if ($totalRows_users > 0) { // Show if recordset not empty ?>
            <?php do { ?>
                <table class="width-600 TableStyle center WidthAuto">
                  <tr>
                    <td style="width:300px;">Registration Date: <?php echo escape($manage_users['registration']); ?></td>
                    <td 

                    <?php if($manage_users['approval'] == "0000-00-00 00:00:00") {?> 
                      style="color:red; width:300px;"
                    <?php } else { ?>
                      style="color:green; width:300px;"
                     <?php } ?>

                    >Approval Date: <?php echo escape($manage_users['approval']); ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td style="width:300px;">User: <?php echo escape($manage_users['first_name']); ?> <?php echo escape($manage_users['last_name']); ?> | Account: <?php echo escape($manage_users['email']); ?></td>
                    <td style="width:300px;">Status: <?php echo ($manage_users['approval'] !== "0000-00-00 00:00:00" ? "Approved" : "Awaiting Approval"); ?></td>
                  </tr>               
                </table>
                <br>
                <?php } while ($manage_users = $data[1][0]->fetch_assoc()) ?>
          <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td align="right" valign="top">
              <!-- PAGINATION -->
              <?php if ($data[1][1]['pageNum'] > 0) { // Show if not first page ?>
              <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], 0, $data[1][1]['queryString']); ?>"> << </a>
              |
                <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], max(0, $data[1][1]['pageNum'] - 1), $data[1][1]['queryString']); ?>"> < </a>
                |...|
                <?php if($data[1][1]['pageNum'] != 1) {?>
                  <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], max(0, $data[1][1]['pageNum'] - 2), $data[1][1]['queryString']); ?>"><?php echo ($data[1][1]['pageNum'] -1) ?></a>
                |
                <?php } ?>
                <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], max(0, $data[1][1]['pageNum'] - 1), $data[1][1]['queryString']); ?>"><?php echo ($data[1][1]['pageNum']) ?></a>
              <?php } // Show if not first page ?>
              |
              <span class="current"><?php echo ($data[1][1]['pageNum'] + 1) ?></span>
              |
              <?php if($data[1][1]['pageNum'] < $data[1][1]['totalPages']){?>
              <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], min($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 1), $data[1][1]['queryString']); ?>"><?php echo ($data[1][1]['pageNum'] + 2) ?></a>
              |
              <?php } ?>
              <?php if(($data[1][1]['totalPages'] ) != min($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 1)) { ?>
              
              <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], min($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 2), $data[1][1]['queryString']); ?>"><?php echo ($data[1][1]['pageNum'] + 3) ?></a>
              |...|
              <?php } ?>
              <?php if ($data[1][1]['pageNum'] < $data[1][1]['totalPages']) { // Show if not last page ?>
              <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], min($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 1), $data[1][1]['queryString']); ?>"> > </a>
              |
              <a href="<?php printf("/admin%s?pageNum=%d%s", $data[1][1]['currentPage'], max($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 1), $data[1][1]['queryString']); ?>"> >> </a>
              <?php } // Show if not last page ?>
              
          </td>
        </tr>
      </table>	
	</div>
</div>

<script type="text/javascript" src="../../assets/js/admin.js"></script>
