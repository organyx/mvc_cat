<div id="PageHeading">
      <h1>Forgot Password</h1>
</div>
    <?php if(isset($_SESSION['MM_Username'])) { ?>
    
<div id="contentLeft">
    <h2><a href="Account.php">Account</a></h2>
</div>
     <?php }; ?>

     
<div id="contentRight">
	<form method="POST" id="sendPassForm" action="javascript:void(null);" >
       
        <div class="ui-form ui-600">
          <div class="ui-page">
               <div class="ui-field">
                  <div>
                      <p id="returnmessage"></p>
                  </div>
              </div>
              <div class="ui-field">
                  <div class="ui-table">
                      <label>Email:</label>
                      <input name="email" type="email" id="email" maxlength="100" size="51"/>
                  </div>
              </div>
          </div>
      
          <div class="ui-buttons">
              <button type="submit" id="sendPass" class="btn" name="send" >Send</button>
              <button type="button" id="reset" class="btn" name="reset" >Reset</button>
          </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="assets/js/newpass.js"></script>