<?php  
  ini_set('max_execution_time', 1000);

  include "../application.php";

  $users_obj = new clsUsers;
  $users_obj->table_name = "idx_users";
  if ($users_obj->GetUserAuthentication(0) != 0) {
    Redirect($site_url . "/login.php?f=1&b=" . urlencode($_SERVER['REQUEST_URI']));
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
      $data['category_id'] = $id;
      $data['parent_id'] = $parent_id;
      $data['title'] = $name;

      if ($i!=0) {
        dmozdata_save_categ($data);
      }

      print '.';
      flush();

      $i++;
    }

    print "<p>DONE.</p>";
    print "<p>The next step is to <a href='../admin/cat_path_update.php'>update category path</a> in admin panel.</p>";   
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
    global $dbConn; 

    $query = "INSERT INTO `idx_category` (`category_id`, `parent_id`, `name`, `description`, `image`, `content`, `visible`, `links`, `meta_keyword`, `meta_description`, `permission`, `registered_only`, `header`, `footer`, `related`, `page_title`, `hits`, `order_num`, `basic_price`, `premium_price`, `sponsored_price`) 
      VALUES 
      ({$data['category_id']}, {$data['parent_id']}, '{$data['title']}', '', 'folder.gif', '', '1', 0, '', '', '1', '0', '', '', 0, '', 0, 0, 0, 0, 0)";
    $result = $dbConn->Execute($query);
  }

  function dmozdata_save_listing($data) {
    global $dbConn; 

    $pwd = GenerateRandomString(6);

    $query = "INSERT INTO `idx_link` (`category_id`, `title`, `url`, `description`, `contact_name`, `email`, `hits`, `votes`, `rating`, `date`, `bid`, `new`, `hot`, `top_rated`, `pick`, `password`, `updated`, `reviews`, `avg_review`, `last_updated`, `official_review`, `keywords`, `cat1`, `cat2`, `suspended`, `reciprocal_url`) 
      VALUES
      ({$data['category_id']}, '{$data['title']}', '{$data['url']}', '{$data['description']}', '', '', 0, 0, 0.00, NOW(), 0, '1', '0', '0', '0', '$pwd', '0', 0, 0.00, '0000-00-00 00:00:00', '', '', 0, 0, '', '')";
    $result = $dbConn->Execute($query);    
  }

  function import_listing($filename) {
    $lines = file($filename);

    $i=0;
    while ($i<count($lines)) {

      $x = explode("\t", $lines[$i]);
      $id    = $x[0];
      $url = $x[1];
      $title   = $x[2];
      $description = $x[3];

      // save
      $data['category_id'] = $id;
      $data['title'] = $title;
      $data['url'] = $url;
      $data['description'] = $description;

      if ($i!=0) {
        dmozdata_save_listing($data);
      }

      print '.';
      flush();

      $i++;
    }

    print "<p>DONE.</p>";
    print "<p>The next step is to <a href='../admin/app_update_nol.php'>update number of links</a> in admin panel or you may want to <a href='index.php'>import other listing files</a>.</p>";    
  }
?>