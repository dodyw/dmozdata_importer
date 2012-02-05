<?php  
  ini_set('max_execution_time', 1000);

  define('ADMIN_PAGE','1');  
  include "../global.php";
  
  /****************************************************************************
    main
  /***************************************************************************/

  if (!login_check_admin()) {
    etc_redirect('../login.php?ref='.urlencode($_SERVER['REQUEST_URI']));
  }

  $filename = $_FILES['userfile']['tmp_name'];

  $lines = file($filename);
  $x = explode("\t", $lines[0]);
  $base_parent_id = $x[0];
  $path_to_id = array();
  unset($lines);

  if ($_POST['type']=='category') {
    import_categ($filename);      
  }
  elseif ($_POST['type']=='listing') {
    import_listing($filename);      
  }

  function import_categ($filename) {
    global $base_parent_id, $path_to_id;

    $lines = file($filename);

    $x = explode("\t", $lines[0]);
    $base_parent_id = $x[0];

    $path_to_id = array();

    $i=0;
    while ($i<count($lines)) {

      $x = explode("\t", $lines[$i]);
      $id   = $x[0];
      $path = $x[1];
      $name = trim($x[2]);

      $name = str_replace('_', ' ', $name);

      // populate to path_list
      $path_to_id[$path] = $id;

      // get parent_id
      $parent_id = dmozdata_get_parent($path);

      // save
      $data['created_at'] = time();
      $data['category_id'] = $id;
      $data['parent_id'] = $parent_id;
      $data['title'] = $name;
      $data['status'] = '1';

      if ($i!=0) {
        dmozdata_save_categ($data);
      }

      print '.';
      flush();

      $i++;
    }

    print "<p>DONE.</p>";
    print "<p>The next step is to <a href='../admin/category.php?act=update_category_path'>update category path</a> in admin panel.</p>";    
  }

  function dmozdata_get_parent($path) {
    global $path_to_id, $base_parent_id;
  
  	$x = explode("/", $path);

    array_pop($x);
    $parent_path = join("/",$x);
    $parent_id = $path_to_id[$parent_path];

    if ($parent_id == $base_parent_id) {
      $parent_id = 0;
    }

  	return $parent_id;
  }

  function dmozdata_save_categ($data) {
    global $lep; 
    $lep->db->AutoExecute('lep_category', $data, 'INSERT');
  }

  function dmozdata_save_listing($data) {
    global $lep; 
    $lep->db->AutoExecute('lep_resource', $data, 'INSERT');
  }

  function import_listing($filename) {
    $lines = file($filename);

    $i=0;
    while ($i<count($lines)) {

      $x = explode("\t", $lines[$i]);
      $id    = $x[0];
      $title = $x[1];
      $url   = $x[2];
      $description = $x[3];

      // save
      $data['created_at'] = time();
      $data['category_id'] = $id;
      $data['title'] = $title;
      $data['url'] = $url;
      $data['description'] = $description;
      $data['status'] = '1';
      $data['listing_type'] = 'basic';

      if ($i!=0) {
        dmozdata_save_listing($data);
      }

      print '.';
      flush();

      $i++;
    }

    print "<p>DONE.</p>";
    print "<p>Go to <a href='../admin/link.php'>admin panel</a>.</p>";    
  }
?>