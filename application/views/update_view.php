       
        <?php $user = $data[0]->fetch_assoc() ?>

        <div id="PageHeading">
    	  <h1>Welcome,  <?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?>!</h1>
        </div>

    	<div id="contentLeft">
          <h2><a href="/account">My Account</a></h2><br>
    	  <h2><a href="/admin/logout">Log Out</a></h2>
    	</div>

    <div id="contentRight">
      <form method="POST" id="updateForm" action="javascript:void(null);" >
      <div class="ui-form ui-600">
        <div class="ui-page">
          <div class="ui-field">
                <div>
                    <p id="returnmessage"></p>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="password">New Password:</label>
                    <input name="password" id="password" type="password" maxlength="100" size="51"/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="passwordwc">Confirm New Password:</label>
                    <input name="passwordwc" id="passwordwc" type="password" maxlength="100" size="51" />
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="lang">Language:</label>
                    <input name="lang" id="lang" type="text" maxlength="100" size="51" value="<?php echo $user['language']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="url">Url:</label>
                    <input name="url" id="url" type="text" maxlength="100" size="51" value="<?php echo $user['url']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="title">Title:</label>
                    <input name="title" id="title" type="text" maxlength="100" size="51" value="<?php echo $user['title']; ?>"/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="descr">Description:</label>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"><?php echo $user['description']; ?></textarea>
                </div>
            </div>
            <div class="ui-field">
                <div class="up_pic center">
                    <br>
                    <a class="fancybox"  href="../../<?php echo $user['preview_thumb']; ?>"> <img src="../../<?php echo $user['preview_thumb']; ?>" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail"/></a>
                    <br>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="file">New picture:</label>
                    <input name="file" id="file" type="file" title="file" style="width: 385px; height: 30px;"/>
                </div>
            </div>
            <input name="UserIDhiddenField" type="hidden" id="UserIDhiddenField"  value="<?php echo $user['userID']; ?>">  
            <input name="MM_update" type="hidden" id="MM_update" value="UpdateForm">
        </div>
        <div class="ui-buttons">
            <input type="submit" value="Update" name="update" id="update" class="btn">
        </div>
        </div>
    </form>
  </div>