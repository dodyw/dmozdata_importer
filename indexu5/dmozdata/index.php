<?php  
  include "../application.php";
  
  /****************************************************************************
    main
  /***************************************************************************/

  $users_obj = new clsUsers;
  $users_obj->table_name = "idx_users";
  if ($users_obj->GetUserAuthentication(0) != 0) {
    Redirect($site_url . "/login.php?f=1&b=" . urlencode($_SERVER['REQUEST_URI']));
  }

?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Welcome to dmozdata.com data import</title>
  
  <!-- Included CSS Files -->
  <!-- Combine and Compress These CSS Files -->
  <link rel="stylesheet" href="stylesheets/globals.css">
  <link rel="stylesheet" href="stylesheets/typography.css">
  <link rel="stylesheet" href="stylesheets/grid.css">
  <link rel="stylesheet" href="stylesheets/ui.css">
  <link rel="stylesheet" href="stylesheets/forms.css">
  <link rel="stylesheet" href="stylesheets/orbit.css">
  <link rel="stylesheet" href="stylesheets/reveal.css">
  <link rel="stylesheet" href="stylesheets/mobile.css">
  <!-- End Combine and Compress These CSS Files -->
  <link rel="stylesheet" href="stylesheets/app.css">

  <!--[if lt IE 9]>
    <link rel="stylesheet" href="stylesheets/ie.css">
  <![endif]-->


  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

  <!-- container -->
  <div class="container">

    <div class="row">
      <div class="twelve columns">
        <h2>dmozdata.com data import ~ Indexu 5.x</h2>
        <hr />
      </div>
    </div>

    <div class="row">
      <div class="eight columns">

        <form class="nice" enctype="multipart/form-data" action="import.php" method="post">
        <input type="hidden" name="act" value="import">
        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->

          <label>Data Type</label>
          <select name='type'>
            <option value="category">Category</option>
            <option value="listing">Listing</option>
          </select>

          <label>DmozData file (.txt)</label>
          <input name="userfile" TYPE="file" class="input-text">

          <input type="submit" class="nice radius small blue button">
        

        </form>
      </div>

      <div class="four columns">      
        <h4>Getting Started</h4>
        <p>Make sure you have fresh install of Indexu 5.x</p>
        <p>Prepare dmozdata.com data in text file (uncompresses).</p>
        <p>You need to import categories before import the listing.</p>

        <h4>Resources</h4>
        <ul class="disc">
          <li><a href="http://www.dmoz.org">dmoz.org</a></li>
          <li><a href="http://www.dmozdata.com">DmozData.com</a></li>
          <li><a href="http://www.dodyrw.com">dodyrw.com</a></li>
          <li><a href="http://www.nicecoder.com">nicecoder.com</a></li>
        </ul>
      </div>
    </div>

  </div>
  <!-- container -->




  <!-- Included JS Files -->
  <script src="javascripts/jquery.min.js"></script>
  <script src="javascripts/modernizr.foundation.js"></script>
  <!-- Combine and Compress These JS Files -->
  <script src="javascripts/jquery.reveal.js"></script>
  <script src="javascripts/jquery.orbit-1.3.0.js"></script>
  <script src="javascripts/forms.jquery.js"></script>
  <script src="javascripts/jquery.customforms.js"></script>
  <script src="javascripts/jquery.placeholder.min.js"></script>
  <!-- End Combine and Compress These JS Files -->
  <script src="javascripts/app.js"></script>

</body>
</html>