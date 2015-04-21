<?php 
  $user = $data[0]->fetch_assoc();

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
    <div id="ret" class="ret">
      
    </div>
  </div>

  <div id="user_list">
    
  </div>
</div>
<script type="text/javascript" src="/../../assets/js/bowser/bowser.min.js"></script>
<script type="text/javascript" src="/../../assets/js/admin_search.js"></script>
<script type="text/javascript" src="/../../assets/js/admin_list.js"></script>