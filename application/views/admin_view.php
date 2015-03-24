<?php 	$user = $data[0]->fetch_assoc();
		$manage_users = $data[1][0]->fetch_assoc(); 
		$totalRows_users = $data[1][0]->num_rows; 
		//echo "<pre>".print_r($manage_users)."</pre>";

		?>
<div id="PageHeading">
	<h1><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></h1>
</div>

<div id="contentLeft">
          <?php if ($_SESSION['lvl'] == 2) { ?>
          <h2><a href="/admin">Manage Users</a></h2><br>
          <?php } ?>
    	  <h2><a href="/update">Update Account</a></h2><br>
    	  <h2><a href="/admin/logout">Log Out</a></h2>
</div>

<div id="contentRight">
	<div id="user_search">
		<div id="grid" class="search">
			<form id="searchForm" class="searchForm" method="post">  
		    <label for="email">Find User: </label>
		    <input type="text" id="email" class="emal" name="email" placeholder="Email..." />
		    <button type="submit" id="btnSearch" class="btnSearch">Search</button>  
		    <button type="button" id="reset" class="reset">Reset</button>  
		</form>
		</div>

		<div class="ret">
			<div id="result" class="result"></div>
			<div id="returnmessage" class="returnmessage"></div>
		</div>
	</div>
	<div id="user_list">
		<table class="width-670 center WidthAuto">
        <tr>
          <td align="right" valign="top">Showing:&nbsp;<?php echo ($data[1][1]['startRow'] + 1) ?> to <?php echo min($data[1][1]['startRow'] + $data[1][1]['maxRows'], $data[1][1]['totalRows']) ?> of <?php echo $data[1][1]['totalRows'] ?></td>
        </tr>
        <tr>
          <td align="center" valign="top"><?php if ($totalRows_users > 0) { // Show if recordset not empty ?>
            <?php do { ?>
                <table class="width-500 TableStyle center WidthAuto">
                  <tr>
                    <td>Registration Date: <?php echo $manage_users['registration']; ?></td>
                  </tr>
                  <tr>
                    <td 

                    <?php if($manage_users['approval'] == "0000-00-00 00:00:00") {?> 
                      style="color:red;"
                    <?php } else { ?>
                      style="color:green;"
                     <?php } ?>

                    >Approval Date: <?php echo $manage_users['approval']; ?></td>
                  </tr>
                  <tr>
                    <td>User: <?php echo $manage_users['first_name']; ?> <?php echo $manage_users['last_name']; ?> | Account: <?php echo $manage_users['email']; ?></td>
                  </tr>
                  <tr>
                  	<td>Status: <?php echo ($manage_users['approval'] !== "0000-00-00 00:00:00" ? "Approved" : "Awaiting Approval"); ?></td>     
                  </tr>
                  <tr>
                    <td><table class="center">
                      <tr>
                        <td><form id="DeleteUserForm" name="DeleteUserForm" method="POST">
                          <input name="DeleteUserHiddenField" type="hidden" id="DeleteUserHiddenField" value="<?php echo $manage_users['userID']; ?>">
                          <input type="submit" name="DeleteUserButton" id="DeleteUserButton" value="Delete User">
                        </form></td>
                        <td><form action="<?php echo $editFormAction; ?>" id="ApproveUserForm" name="ApproveUserForm" method="POST">
                          <input name="ApproveUserHiddenField" type="hidden" id="ApproveUserHiddenField" value="<?php echo "CURRENT_TIMESTAMP()"; ?>">
                          <input name="ApproveIDhiddenField" type="hidden" id="ApproveIDhiddenField" value="<?php echo $manage_users['userID']; ?>">
                          <input type="submit" name="ApproveUserButton" id="ApproveUserButton" value="Approve User">
                          <input type="hidden" name="MM_update" value="ApproveUserForm">
                        </form></td>
                        <!--
                        <td><form action="<?php echo $editFormAction; ?>" id="MakeAdminForm" name="MakeAdminForm" method="POST">
                        <input name="MakeUserAdminHiddenField" type="hidden" id="ApproveUserHiddenField" value="<?php echo "2"; ?>">
                          <input type="submit" name="MakeAdminButton" id="MakeAdminButton" value="Give Admin Rights">
                          <input name="MakeUserAdminIDhiddenField" type="hidden" id="ApproveIDhiddenField" value="<?php echo $row['userID']; ?>">
                          <input type="hidden" name="MM_update" value="MakeAdminForm">
                        </form></td>
                        -->
                      </tr>
                    </table></td>
                  </tr>
                  
                </table>
                <br>
                <?php } while ($manage_users = $data[1][0]->fetch_assoc()) ?>
          <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td align="right" valign="top">
           	<?php if ($data[1][1]['pageNum'] < $data[1][1]['totalPages']) { // Show if not last page ?>
              <a href="<?php printf("/admin%s?pageNum_ManageUsers=%d%s", $data[1][1]['currentPage'], min($data[1][1]['totalPages'], $data[1][1]['pageNum'] + 1), $data[1][1]['queryString']); ?>">Next</a>
              <?php } // Show if not last page ?>
              |
              <?php if ($data[1][1]['pageNum'] > 0) { // Show if not first page ?>
                <a href="<?php printf("/admin%s?pageNum_ManageUsers=%d%s", $data[1][1]['currentPage'], max(0, $data[1][1]['pageNum'] - 1), $data[1][1]['queryString']); ?>">Previous</a>
              <?php } // Show if not first page ?>
          </td>
        </tr>
      </table>	
	</div>
</div>