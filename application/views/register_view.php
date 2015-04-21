<div id="PageHeading">
      <h1>Registration</h1>
</div>
    <?php if(isset($_SESSION['Username'])) { ?>
    
<div id="content_top">
    <h2><a href="/account/">Account</a></h2>
</div>
     <?php }; ?>

     
<div id="content_bottom">
    <form method="POST" id="registrationForm" action="javascript:void(null);" >
    <div class="ui-form ui-600">
        <div class="ui-page">
          <div class="ui-field">
                <div>
                    <p id="returnmessage"></p>
                </div>
            </div>
            <div class="ui-field">       
                <div class="ui-table">
                    <label for="first_name">First Name<span class="required">*</span>:</label>
                    <input name="first_name" id="first_name" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="last_name">Last Name<span class="required">*</span>:</label>
                    <input name="last_name" id="last_name" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="email">Email<span class="required">*</span>:</label>
                    <input name="email" id="email" type="email" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="password">Password<span class="required">*</span>:</label>
                    <input name="password" id="password" type="password" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="passwordwc">Confirm Password<span class="required">*</span>:</label>
                    <input name="passwordwc" id="passwordwc" type="password" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="lang">Language:</label>
                    <input name="lang" id="lang" type="text" maxlength="100" size="51"/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="url">Url<span class="required">*</span>:</label>
                    <input name="url" id="url" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="title">Title<span class="required">*</span>:</label>
                    <input name="title" id="title" type="text" maxlength="100" size="51" required/>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="descr">Description:</label>
                    <textarea name="descr" id="descr" style="width: 385px; height: 80px;"></textarea>
                </div>
            </div>
            <div class="ui-field">
                <div class="ui-table">
                    <label for="file">Preview picture:</label>
                    <input name="file" id="file" type="file" title="file" style="width: 385px; height: 30px;"/>
                </div>
            </div>
            <input type="hidden" name="MM_insert" id="MM_insert" value="RegisterForm">
        </div>

        <div class="ui-buttons"> 
            <input type="button" value="Reset" name="reset" id="reset" class="btn" />
            <input type="submit" value="Register" name="submit" id="register" class="btn" />
        </div>
    </div>
</form>
</div>

<script type="text/javascript" src="../../assets/js/registration.js"></script>