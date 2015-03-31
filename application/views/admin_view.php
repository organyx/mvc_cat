<?php 	
    $user = $data[0]->fetch_assoc();
		//$manage_users = $data[1][0]->fetch_assoc(); 
		//$totalRows_users = $data[1][0]->num_rows; 
		//echo "<pre>".print_r($manage_users)."</pre>";
    $editFormAction = "/admin/index/";
    if (isset($_SERVER['QUERY_STRING'])) {
      $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
		?>

<div id="PageHeading">
	<h1><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></h1>
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

		<div class="ret">
      <table class="width-670 center WidthAuto off" id="result_table">
                <tr>
                  <td align="center">Account: </td>
                </tr>
                <tr>
                  <td><table class="width-500 TableStyle center WidthAuto">
                    <tr>
                      <td valign="top">&nbsp;</td>
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
                  </table></td>
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
      <div id="returnmessage" class="returnmessage"></div>
      <br>
			<div id="result" class="result"></div>
		</div>

	</div>
	<div id="user_list">
		<div class="loading-div"><img src="../../assets/images/ajax-loader.gif" ></div>
    <div id="results"><!-- content will be loaded here --></div>
	</div>
</div>

<script type="text/javascript" src="../../assets/js/admin.js"></script>
