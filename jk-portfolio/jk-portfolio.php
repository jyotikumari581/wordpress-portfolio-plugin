<?php
/*
	Plugin Name: JK Portfolio
	Plugin URI: https://freelancedeveloper.dev/
	Description: JK Portfolio
	Version: 4.1.0
	Author: Boffincoders
    Author URI: https://freelancedeveloper.dev/
    Text Domain: jk-portfolio 
*/

if ( ! defined( 'ABSPATH' ) ) exit;
  
	function boffincoders_portfolio() {
	global $wpdb; 

	$table_name = $wpdb->base_prefix.'boffin_portfolio';
	$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

	$table_name2 = $wpdb->base_prefix.'boffin_portfolio_categories';
	$query2 = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name2 ) );

	$table_name3 = $wpdb->base_prefix.'boffin_portfolio_styles';
	$query3 = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name3 ) );


  if ( ! $wpdb->get_var( $query ) == $table_name ) {
	$table_name = $wpdb->prefix . "boffin_portfolio";
 
	$charset_collate = $wpdb->get_charset_collate();
 
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	portfolio_id bigint(20) UNSIGNED NOT NULL auto_increment,
    portfolio_name varchar(100) NOT NULL DEFAULT '',
    portfolio_image varchar(200) NOT NULL DEFAULT '',
    portfolio_description varchar(1000) NOT NULL DEFAULT '',
    portfolio_categories varchar(20) NOT NULL DEFAULT '1',
    portfolio_category_slug varchar(255) NOT NULL,
    url_location varchar(255) NOT NULL,
    portfolio_url varchar(255) NOT NULL DEFAULT '',
    new_tab tinyint(4) NOT NULL,
    sort_order int(11) NOT NULL,
    platforms varchar(255) NOT NULL,
    bg_color varchar(255) NOT NULL,
    hover_color varchar(255) NOT NULL,
    title_color varchar(255) NOT NULL,
    description_color varchar(255) NOT NULL,
	button_text_color varchar(255) NOT NULL,
	button_color varchar(255) NOT NULL,
	autoload varchar(20) NOT NULL default 'yes',
	PRIMARY KEY  (portfolio_id),
	KEY autoload (autoload)

	) $charset_collate;";
 
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql); 
  }

  if (! $wpdb->get_var( $query2 ) == $table_name2 ) {
	$table_name2 = $wpdb->prefix . "boffin_portfolio_categories";
 
	$charset_collate = $wpdb->get_charset_collate();
 
	 $sql = "CREATE TABLE IF NOT EXISTS $table_name2 (
	   portfolio_cat_id bigint(20) UNSIGNED NOT NULL auto_increment,
       portfolio_cat_name varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
       portfolio_cat_slug varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
       sort_order int(11) NOT NULL,
	   autoload varchar(20) NOT NULL default 'yes',
	   PRIMARY KEY  (portfolio_cat_id),
	   KEY autoload (autoload)

	) $charset_collate;";
 
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql); 

  } 

 if ( ! $wpdb->get_var( $query3 ) == $table_name3 ) {
	$table_name3 = $wpdb->prefix . "boffin_portfolio_styles";
 
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS $table_name3 (
	    id int(10) NOT NULL auto_increment,
        title_size varchar(255) NOT NULL,
		button_text_color varchar(255) NOT NULL,
        description_size varchar(255) NOT NULL,
        title_color varchar(255) NOT NULL,
        description_color varchar(255) NOT NULL,
		button_size varchar(255) NOT NULL,
		button_color varchar(255) NOT NULL,
        background_color varchar(255) NOT NULL,
        border_radius varchar(255) NOT NULL,
        filter_button_text_color_active varchar(255) NOT NULL,
        filter_button_text_color_inactive varchar(255) NOT NULL,
        filter_button_bkg_color_active varchar(255) NOT NULL,
        filter_button_bkg_color_inactive varchar(255) NOT NULL,
        filter_btn_font_size varchar(255) NOT NULL,
        unique_for_everyone varchar(255) NOT NULL,
		autoload varchar(20) NOT NULL default 'yes',
		PRIMARY KEY  (id),
	    KEY autoload (autoload)

	) $charset_collate;";
 
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql); 
	
	
	$sql2 = $wpdb->insert( $table_name3, array(
            'id' => "1", 
            'title_size' => "25px",
			'button_text_color' => "#fff",
            'description_size' => "16px", 
			'button_size' => "16px", 
            'title_color' => "#000000",
            'description_color' => "#ff0000",
			'button_color' => "#fff",
            'background_color' => "#bdbdbd",
            'border_radius' => "10px",
            'filter_button_text_color_active' => "#ffffff",
            'filter_button_text_color_inactive' => "#000000",
            'filter_button_bkg_color_active' => "#000000",
            'filter_button_bkg_color_inactive' => "#e93a3a",
            'filter_btn_font_size' => "15px",
            'unique_for_everyone' => "no",
        ));
      dbDelta($sql2); 
   } 
  }
  add_action('init', 'boffincoders_portfolio');
 
  function boffincoders_portfolio_menu_pages(){
	 add_menu_page('Portfolio List', 'Boffin Portfolio', 'edit_posts','list-portfolio','boffincoders_portfolio_boffin_list','dashicons-format-gallery', 6 );
	 
	 add_submenu_page(
		'list-portfolio',         
		'Portfolios',			 
		'Portfolios',             
		'manage_options',		 
		'list-portfolio',			 
		'boffincoders_portfolio_boffin_list'  
	); 
	
	 add_submenu_page(
    'list-portfolio',          
    'Categories',                
    'Add Category',                
    'manage_options',              
    'portfolio-cat',   
    'boffincoders_portfolio_add_categories'  
  ); 

	 add_submenu_page(
    'list-portfolio',          
    'Categories',               
    'Categories',                
    'manage_options',             
    'portfolio-categories',  
    'boffincoders_portfolio_categories_list'  
  ); 


	add_submenu_page(
    '',          
    'Delete Category',              
    'Delete Category',              
    'manage_options',              
    'category-delete',   
    'boffincoders_portfolio_delete_category'  
	); 

	add_submenu_page(
    '',          
    'Edit Category',               
    'Edit Category',               
    'manage_options',              
    'category-edit',   
    'boffincoders_portfolio_edit_category'  
	); 

/* Portfolio edit */

	add_submenu_page(
    '',           
    'Edit Portfolio',         
    'Edit  Portfolio',          
    'manage_options',           
    'portfolio-edit',   
    'boffincoders_portfolio_edit_form_page_handler'  
	);  

 
	/* Portfolio add */
	add_submenu_page(
    'list-mobile',           
    'Add Portfolio',         
    'Add New Portfolio',          
    'manage_options',        
    'add-portfolio',  
    'boffincoders_portfolio_boffin_form_page_handler'  
	); 

	
	add_submenu_page(
    '',          
    'Delete Portfolio',              
    'Delete Portfolio',               
    'manage_options',               
    'portfolio-delete',   
    'boffincoders_portfolio_delete_single'  
	);  


	/* Portfolio add */
	add_submenu_page(
    'list-portfolio',         
    'Edit Styles',               
    'Edit Styles',                
    'manage_options',              
    'edit-styles',  
    'boffincoders_portfolio_boffin_edit_styles'  
	); 	
 
  }

add_action('admin_menu', 'boffincoders_portfolio_menu_pages');
 
	function boffincoders_portfolio_add_categories() 
   {	
	  global $wpdb;
	  $table_name =  $wpdb->prefix."boffin_portfolio_categories";
	  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
	 ?>
	  
	 <link rel="stylesheet" href="style.css">
	 <br/>
	 <form method="POST" action="?page=portfolio-categories" class="fom1">
	  <h1>Add new Category</h1>
	  <table class="form-table" id="ftable_apps" role="presentation">
	  <tbody>
	  <tr>
		<th scope="row"><label>Category Name: </label> </th>
		<td><input type="text" name="portfolio_cat_name" required="required"/> </td>
	  </tr>

	  <tr>
			<th scope="row"><label>Category Slug </label></th>
			<td><input type="text" name="portfolio_cat_slug" required="required"/></td> 
	  </tr>
	 
	 <tr>
	  <th scope="row"><label>sort order: </label></th>
	   <td>
		 <input type="number" class="sort-order-number" name="sort_order" required="required" />
	  </td>
	 </tr>
	 
      <tr>
	   <td> </td>
		 <td><input type="submit" name="form1" value="Save" /></td>
	  </tr>
	 </tbody>
	 </table>
	</form>
	 
	 <?php	
   }
 
/* Edit Styles */

function boffincoders_portfolio_boffin_edit_styles() {
  global $wpdb;
  $table_name =  $wpdb->prefix."boffin_portfolio_styles";
  $default_row = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1" );
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');


 if (isset($_POST['formedit']))
	{ 
	 	$title_size = sanitize_text_field($_POST['title_size']);
		$button_text_color = sanitize_text_field($_POST['button_text_color']);
	 	$description_size =  sanitize_text_field($_POST['description_size']);
		$button_size = sanitize_text_field($_POST['button_size']);
	 	$title_color =  sanitize_text_field($_POST['title_color']);
	 	$description_color =  sanitize_text_field($_POST['description_color']);
		$button_color = sanitize_text_field($_POST['button_color']);
	 	$background_color =  sanitize_text_field($_POST['background_color']);
	 	$border_radius = sanitize_text_field($_POST['border_radius']);
	 	$filter_button_text_color_active =  sanitize_text_field($_POST['filter_button_text_color_active']);
	 	$filter_btn_font_size =  sanitize_text_field($_POST['filter_btn_font_size']);
	 	$filter_button_text_color_inactive = sanitize_text_field($_POST['filter_button_text_color_inactive']);
	 	$filter_button_bkg_color_active =  sanitize_text_field($_POST['filter_button_bkg_color_active']);
	 	$filter_button_bkg_color_inactive =  sanitize_text_field($_POST['filter_button_bkg_color_inactive']);
	 	$unique_for_everyone = sanitize_text_field($_POST['unique_for_everyone']);
	 	 
 
        $wpdb->update($table_name, array('title_size'=>$title_size, 'button_size'=>$button_size, 'button_text_color'=>$button_text_color, 'button_color'=>$button_color, 'description_size'=>$description_size, 'title_color'=>$title_color, 'description_color'=>$description_color, 'background_color'=>$background_color, 'border_radius'=>$border_radius, 'filter_button_text_color_active'=>$filter_button_text_color_active, 'filter_button_text_color_inactive'=>$filter_button_text_color_inactive, 'filter_button_bkg_color_active'=>$filter_button_bkg_color_active, 'filter_button_bkg_color_inactive'=>$filter_button_bkg_color_inactive,'filter_btn_font_size'=>$filter_btn_font_size, 'unique_for_everyone'=>$unique_for_everyone), array('id'=>1));
 
		print_r("<p class='greentext' >Data Saved Successfully</p>");
		 
        echo '<script>window.location.replace("?page=edit-styles")</script>';
		
	}

  
 ?>
 <link rel="stylesheet" href="style.css">
 <br/>
 <form method="POST" action="" class="fom1">
  <h1>Edit Styles</h1>
  <table class="form-table" id="portfolio-styles" role="presentation">
  <tbody>
  <tr>
    <th scope="row"><label>Portfoilo Background Colour: </label> </th>
    <td><input class="color-style" type="color" name="background_color" required="required" value="<?php echo $default_row->background_color; ?>"/> </td>
  </tr>
  
  <tr>
    <th scope="row"><label>Portfoilo Title Size: </label> </th>
    <td><input type="text" name="title_size" required="required" value="<?php echo $default_row->title_size; ?>"/> </td>
  </tr>
 
  <tr>
    <th scope="row"><label>Portfoilo Title Color: </label> </th>
    <td><input class="color-style" type="color" name="title_color" required="required" value="<?php echo $default_row->title_color; ?>"/> </td>
  </tr>
 
  <tr>
    <th scope="row"><label>Portfoilo Description Size: </label> </th>
    <td><input type="text" name="description_size" required="required" value="<?php echo $default_row->description_size; ?>"/> </td>
  </tr>
  
  <tr>
    <th scope="row"><label>Portfoilo Description Colour: </label> </th>
    <td><input class="color-style" type="color" name="description_color" required="required" value="<?php echo $default_row->description_color; ?>"/> </td>
  </tr>
  <tr>
    <th scope="row"><label>Portfoilo Button Colour: </label> </th>
    <td><input class="color-style" type="color" name="button_color" required="required" value="<?php echo $default_row->button_color; ?>"/> </td>
  </tr>
  
  <tr>
    <th scope="row"><label>Portfoilo Border Radius: </label> </th>
    <td><input type="text" name="border_radius" required="required" value="<?php echo $default_row->border_radius; ?>"/> </td>
  </tr>
 
   <tr>
    <th scope="row"><label><h1>Filter Buttons: </h1></label> </th>
   </tr>
 
   <tr>
    <th scope="row"><label> Filter Buttons Text Size: </label> </th>
    <td><input type="text" name="filter_btn_font_size" required="required" value="<?php echo $default_row->filter_btn_font_size; ?>"/> </td>
   </tr>
 
   <tr>
    <th scope="row"><label>Active Filter Button Text Colour: </label> </th>
    <td><input class="color-style" type="color" name="filter_button_text_color_active" required="required" value="<?php echo $default_row->filter_button_text_color_active; ?>"/> </td>
   </tr>
   
   <tr>
    <th scope="row"><label>Active Filter Button Background Colour: </label> </th>
    <td><input class="color-style" type="color" name="filter_button_bkg_color_active" required="required" value="<?php echo $default_row->filter_button_bkg_color_active; ?>"/> </td>
   </tr>
 
   <tr>
    <th scope="row"><label>InActive Filter Button Text Colour: </label> </th>
    <td><input class="color-style" type="color" name="filter_button_text_color_inactive" required="required" value="<?php echo $default_row->filter_button_text_color_inactive; ?>"/> </td>
   </tr>
 
   <tr>
    <th scope="row"><label>Inactive Filter Button Background Colour: </label> </th>
    <td><input class="color-style" type="color" name="filter_button_bkg_color_inactive" required="required" value="<?php echo $default_row->filter_button_bkg_color_inactive; ?>"/> </td>
   </tr>
 
  <tr>
    <th scope="row"><label><h2>Do you want Unique Colour for everyone:</h2></label> </th>
    <td> 
	 <select name="unique_for_everyone">
	  <option value="yes" <?php if($default_row->unique_for_everyone == 'yes') { echo "selected";} ?> >YES</option>
	  <option value="no" <?php if($default_row->unique_for_everyone == 'no') { echo "selected";} ?>>NO</option>
	</td>
   </tr>
   <tr>
    <th scope="row"><label><h2>Read More Button: </h2></label> </th>
   </tr>
   <tr>
    <th scope="row"><label> Read More Buttons Text Size: </label> </th>
    <td><input type="text" name="button_size" required="required" value="<?php echo $default_row->button_size; ?>"/> </td>
   </tr>
   <tr>
    <th scope="row"><label> Read More Buttons Text Color: </label> </th>
    <td><input class="color-style" type="color" name="button_text_color" required="required" value="<?php echo $default_row->button_text_color; ?>"/> </td>
   </tr>
   <tr>
    <th scope="row"><label>Read More Button Background Colour: </label> </th>
    <td><input class="color-style" type="color" name="button_color" required="required" value="<?php echo $default_row->button_color; ?>"/> </td>
   </tr>
  <tr>
     <td> </td>
	 <td><input type="submit" name="formedit" value="Save" /></td>
  </tr>
  </tbody>
 </table>
</form>
 
 <?php
	
}
 
/* Delete Category */

function boffincoders_portfolio_delete_category() {
	 global $wpdb;
	 $table_name =  $wpdb->prefix."boffin_portfolio_categories";
	 $deleteid = sanitize_text_field($_POST['deleteid']);
	
	$wpdb->delete( $table_name, array( 'portfolio_cat_id' => $deleteid ) );
	print_r("<p class='greentext' >Data Saved Successfully!</p>");
    echo '<script>window.location.replace("?page=portfolio-categories")</script>';
}

 
/* Edit Category */

function boffincoders_portfolio_edit_category() {
  global $wpdb;
  $table_name =  $wpdb->prefix."boffin_portfolio_categories";
  $cat_id = $_GET['category-id'];
  $default_row = $wpdb->get_row( "SELECT * FROM $table_name WHERE portfolio_cat_id=$cat_id ORDER BY sort_order" );
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
 ?>
  
 <link rel="stylesheet" href="style.css">
 <br/>
 <form method="POST" action="?page=portfolio-categories" class="fom1">
  <h1>Edit Category</h1>
  <table class="form-table" id="ftable_apps" role="presentation">
  <tbody>
  <tr>
    <th scope="row"><label>Category Name: </label> </th>
    <td><input type="text" name="portfolio_cat_name" required="required" value="<?php echo $default_row->portfolio_cat_name; ?>"/> </td>
  </tr>
 
  <tr>
		<th scope="row"><label>Category Slug </label></th>
		<td><input type="text" name="portfolio_cat_slug" required="required" value="<?php echo $default_row->portfolio_cat_slug; ?>"/>  </td>
  </tr>
 
   <tr>
		<th scope="row"><label>sort order: </label></th>
		<td><input type="number" class="sort-order-number" name="sort_order" required="required" value="<?php echo $default_row->sort_order; ?>"/>
		 <input type="hidden" name="cid" value="<?php echo $cat_id; ?>"/>
	    </td>
  </tr>
  <tr>
     <td> </td>
	 <td><input type="submit" name="formedit" value="Save" /></td>
  </tr>
  </tbody>
 </table>
</form>
 
 <?php
}

 
/* categories List */

function boffincoders_portfolio_categories_list() {
 	
  global $wpdb;
  $table_name =  $wpdb->prefix."boffin_portfolio_categories";
  $default_row = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY sort_order" );
 
	if (isset($_POST['form1']))
	{ 
	 	$portfolio_cat_name =  sanitize_text_field($_POST['portfolio_cat_name']);
	 	$portfolio_cat_slug = sanitize_text_field($_POST['portfolio_cat_slug']);
		$sort_order= sanitize_text_field($_POST["sort_order"]);
 
	$wpdb->insert($table_name, array(
			'portfolio_cat_name' => $portfolio_cat_name,
			'portfolio_cat_slug' => $portfolio_cat_slug,
			'sort_order' => $sort_order,
    ));
 
		print_r("<p class='greentext' >Data Saved Successfully!</p>");
    
	}
  
  
   if (isset($_POST['formedit']))
	{ 
	    $currentport_id = sanitize_text_field($_POST['cid']);
	 	$portfolio_cat_name =  sanitize_text_field($_POST['portfolio_cat_name']);
	 	$portfolio_cat_slug = sanitize_text_field($_POST['portfolio_cat_slug']);
		$sort_order= sanitize_text_field($_POST["sort_order"]);
 
        $wpdb->update($table_name, array('portfolio_cat_id'=>$currentport_id, 'portfolio_cat_name'=>$portfolio_cat_name, 'portfolio_cat_slug'=>$portfolio_cat_slug, 'sort_order'=>$sort_order), array('portfolio_cat_id'=>$currentport_id));
 
		 print_r("<p class='greentext' >Data Saved Successfully</p>");
		
	}
 
  $table_name =  $wpdb->prefix."boffin_portfolio_categories";
  $default_row = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY sort_order" );
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');   
  ?>
  <link rel="stylesheet" href="style.css">
  <h1 class="page-title">Category List </h1><a href="./admin.php?page=portfolio-cat" class="page-title-action">Add New Category +</a>
 
 <table class="wp-list-table widefat fixed striped table-view-list forms"> 
     <thead>
	  <tr>
	    <th class="manage-columnbig">Category Name</th>
	    <th class="manage-columnbig">slug</th>
	    <th class="manage-columnsmall">Sort Order</th>
	    <th class="manage-columnbig">Action</th>
      </tr>
	  </thead>  
       <?php foreach($default_row as $values) { ?>
       <tr>
 
	 <td class="port">
	  <?php echo $values->portfolio_cat_name;?>
	 </td>
 
	 <td class="port">
	  <?php echo $values->portfolio_cat_slug;?>
	 </td>
 
	 <td class="port">
	  <?php echo $values->sort_order;?>
	 </td>
 
	  <td class="port-action">
	    <a class="fa fa-edit" title="Edit Portfolio" href="?page=category-edit&category-id=<?php echo $values->portfolio_cat_id; ?>"> Edit </a>  &nbsp; <form action='?page=category-delete&portfolio-id=<?php echo $values->portfolio_cat_id; ?>' method='post'> <input type='hidden' name="deleteid" value='<?php echo $values->portfolio_cat_id;?>'/> <input type='hidden' name="category_selected" value='<?php echo $values->portfolio_categories;?>'/><input type='submit' class="del-port" name="" value='Delete'></form> 
	 </td>
	 
    </tr>
   <?php } ?>
   </table>
  <?php
}
 

function boffincoders_portfolio_boffin_list()
{
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');   
  global $wpdb;
  $table_name =  $wpdb->prefix."boffin_portfolio";
  $default_row = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY sort_order" );
 
	if (isset($_POST['form1']))
	{ 
       
		$portfolio_categories = array_map('sanitize_text_field', $_POST["my_meta_box_select"]);
		
		
		$cat_list = '';
		$lastIndex = count($portfolio_categories) - 1;
		foreach ($portfolio_categories as $index => $value) {
			$cat_list .= $value;
			if ($index != $lastIndex) {
				$cat_list .= ',';
			}
		}
 
	 	$portfolio_name =  sanitize_text_field($_POST['portfolio_name']);
	 	$portfolio_imageval = sanitize_text_field($_POST['portfolio_image']);
		$portfolio_description= sanitize_text_field($_POST["portfolio_description"]);
		$portfolio_description = str_replace("\'", "'",$portfolio_description);
		$sort_order= sanitize_text_field($_POST["sort_order"]);
		$portfolio_url= sanitize_text_field($_POST["portfolio_url"]);

		$bg_color= sanitize_text_field($_POST["bg_color"]);
		$hover_color= '';
		$title_color= sanitize_text_field($_POST["title_color"]);
		$description_color= sanitize_text_field($_POST["description_color"]);
		$button_color= sanitize_text_field($_POST["button_color"]);
		$button_text_color= sanitize_text_field($_POST["button_text_color"]);
		if($portfolio_url == "" || $portfolio_url == " ")
		{
			$portfolio_url = "#";
		}
		$new_tab= sanitize_text_field($_POST["new_tab"]);
     
		$result = $wpdb->insert($table_name, array(
			'portfolio_name' => $portfolio_name,
			'portfolio_image' => $portfolio_imageval,
			'portfolio_description' => $portfolio_description,
			'portfolio_categories' => $cat_list,
			'sort_order' => $sort_order,
			'portfolio_url' => $portfolio_url,
			'bg_color'=>$bg_color,
			'hover_color'=> '',
			'new_tab' => $new_tab,
			'title_color' => $title_color,
			'description_color' => $description_color,
			'button_color' => $button_color,
			'button_text_color' => $button_text_color,
    ));
 
	if($result) {
  print_r("<p class='greentext'  >Data Saved Successfully</p>");
    }

	else {
		print_r("<p class='greentext'  >Data Not Saved </p>");
		  }
       echo '<script>window.location.replace("?page=list-portfolio")</script>';
 
	}
  
   if (isset($_POST['formedit']))
	{   
 
		$portfolio_categories = array_map('sanitize_text_field', $_POST["my_meta_box_select"]);
		
		$cat_list = '';
		$lastIndex = count($portfolio_categories) - 1;
		foreach ($portfolio_categories as $index => $value) {
			$cat_list .= $value;
			if ($index != $lastIndex) {
				$cat_list .= ',';
			}
		}
	    $currentport_id = sanitize_text_field($_POST['cid']);
	 	$portfolio_name =  sanitize_text_field($_POST['portfolio_name']);
	 	$portfolio_imageval = sanitize_text_field($_POST['portfolio_image']);
		$portfolio_description= sanitize_text_field($_POST["portfolio_description"]);
		
		$portfolio_description = str_replace("\'", "'",$portfolio_description);
		$sort_order= sanitize_text_field($_POST["sort_order"]);
		$portfolio_url= sanitize_text_field($_POST["portfolio_url"]);
        $bg_color= sanitize_text_field($_POST["bg_color"]);
		$title_color= sanitize_text_field($_POST["title_color"]);
		$description_color= sanitize_text_field($_POST["description_color"]);
		$button_color= sanitize_text_field($_POST["button_color"]);
		$button_text_color= sanitize_text_field($_POST["button_text_color"]);

		if($portfolio_url == "" || $portfolio_url == " ")
		{
			$portfolio_url = "#";
		}
		$new_tab= sanitize_text_field($_POST["new_tab"]);
 
        $wpdb->update($table_name, array('portfolio_id'=>$currentport_id, 'portfolio_name'=>$portfolio_name, 'portfolio_image'=>$portfolio_imageval, 'portfolio_description'=>$portfolio_description, 'portfolio_categories'=>$cat_list, 'button_color'=>$button_color, 'button_text_color'=>$button_text_color, 'sort_order'=>$sort_order, 'portfolio_url'=>$portfolio_url, 'bg_color'=>$bg_color, 'title_color'=>$title_color, 'description_color'=>$description_color, 'hover_color'=>'', 'new_tab'=>$new_tab), array('portfolio_id'=>$currentport_id));
		
		 
		 print_r("<p class='greentext'  >Data Saved Successfully</p>");
 
         echo '<script>window.location.replace("?page=list-portfolio")</script>';
	}
	
 if(isset($_POST['but_delete'])){
	 
	$table =  $wpdb->prefix."boffin_portfolio";
	if(isset($_POST['delete']))
	{
	  $arrLength = count($_POST['delete']);
	}
	 
      if(isset($_POST['delete']))
          {
            foreach($_POST['delete'] as $deleteid)
		      {
	           $wpdb->delete( $table, array( 'portfolio_id' => $deleteid ) );
              }
          }
		  if ($arrLength == 1)
		  {
			print_r("<p class='greentext' class='greentext'  > 1 row Deleted Successfully</p>");
		  }
		   else if ($arrLength > 1)
		  {
			print_r("<p class='greentext'>".$arrLength." rows Deleted Successfully</p>");
		  }
	}
 
 
  ?>
  <link rel="stylesheet" href="style.css">
  <h1 class="page-title">Portfolio List </h1> 
  <p style="background-color: #2271b1; padding: 20px 20px 0px 20px; width: 30%; color: #fff; font-size: 18px; border-radius: 20px; box-shadow: 4px 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%)";>Use Shortcodes : </br> Design1: <b><span style="background-color: #000;">[boffin-portfolio-design1]</span></b><br/> Design2: <b><span style="background-color: #000;">[boffin-portfolio-design2]</span></b><br/>  <br/></p><a href="./admin.php?page=add-portfolio" class="page-title-action">Add New Portfolio +</a>
 
 <form method='post' action=''> 
 <input type='submit' class="del-port" value='Delete Selected' name='but_delete' onclick="return boffinportfoilovalidate()"><br> 
 <table class="wp-list-table widefat fixed striped table-view-list forms" id="Mobiletable"> 
     <thead>
	  <tr>
        <th class="manage-checkbox"><input type="checkbox" onClick="bofffintoggle(this)" /></th>  
	    <th class="manage-columnbig">Name</th>
	    <th class="manage-columnbig">Image</th>
	    <th class="manage-columnbig"> Description</th>
	    <th class="manage-columnbig">URL</th>
	    <th class="manage-columnsmall">Category</th>
	    <th class="manage-columnsmall">Sort Order</th>
	    <th class="manage-columnsmallbig">Action</th>
      </tr>
	  </thead>  
       <?php foreach($default_row as $values) { ?>
       <tr>
	   <td class="port-checkbox"><input type='checkbox' class="delete" name='delete[]' value='<?php  echo $values->portfolio_id; ?>' id='delcheckboxes' ></td>  
	 
	 <td class="port-name">
	  <?php echo $values->portfolio_name;?>
	 </td>
 
	 <td>
	 <img class="port-table-image" src="<?php echo $values->portfolio_image;?>" width="100%"/>
	 </td>
  
	 <td class="port-desc">
	  <?php
	  $string = strip_tags($values->portfolio_description);
	  if (strlen($string) > 100) {
		  $stringCut = substr($string, 0, 100); 
		  $endPoint = strrpos($stringCut, ' ');
		  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
		  $string .= '...';
	  }
	  echo $string;
	   ?>
	 </td>
 
	 <td class="port-url">
	  <a href="<?php echo $values->portfolio_url;?>" class="" href="" target="_blank"><?php echo $values->portfolio_url;?></a>
	 </td>
  
	 <td class="port-yesno">
	  <?php echo $values->portfolio_categories; ?>
	 </td>
 
	 <td class="port-sort">
	  <?php echo $values->sort_order;?>
	 </td>
 
	 <td class="port-action">
	 <form> </form>
	 <br/><b><a class="fa fa-edit" title="Edit Portfolio" href="?page=portfolio-edit&portfolio-id=<?php echo $values->portfolio_id; ?>"> Edit </a> <br/> <br/><form action='?page=portfolio-delete&portfolio-id=<?php echo $values->portfolio_id; ?>' method='post' onSubmit="return confirm('Are you sure you wish to delete?');"> <input type='hidden' name="deleteid" value='<?php echo $values->portfolio_id;?>'/><input type='hidden' name="category_selected" value='<?php echo $values->portfolio_categories;?>'/><button type='submit' title="Delete Portfolio" class="fa fa-trash" name="" value='Delete' onclick="deleteMobile()"> Delete</button>
	 </form></b>
	 </td>
	 
    </tr>
   <?php } ?>
   </table>
   
   <script type="text/javascript">
    function boffinportfoilovalidate() {
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
		 if (checkedOne == false) 
		 {	
			alert("Please Select Items");
			return false;
		 }
		 else
		 {
			 if (confirm('Are you sure you wish to delete Selected Items?'))
			 {
				return true; 
			 }
			 else
			 {
				 return false;
			 }
		 }
    }
	
	function bofffintoggle(source) {
  checkboxes = document.getElementsByClassName('delete');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
	
</script>
    </form>  
 
  <?php
}
 
/* Edit Portfolio */

function boffincoders_portfolio_edit_form_page_handler() {
  global $wpdb;
  $table_name =  $wpdb->prefix."boffin_portfolio";
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $cid = explode("portfolio-id=",$actual_link);
  $currentport_id = $cid[1];
  $default_row = $wpdb->get_row( "SELECT * FROM $table_name WHERE portfolio_id='$currentport_id' ORDER BY sort_order");
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
  ?>
 <link rel="stylesheet" href="style.css">
 <script>
jQuery(function($){
	// on upload button click
	$('body').on( 'click', '.misha-upl', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			button.html('<img width="100%" src="' + attachment.url + '" value="<?php $default_row->portfolio_image; ?>">').next().show().next().val(attachment.url);
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.misha-rmv', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});
 
	
$('body').on('click', '.misha-rmv2', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});

});
 
</script> 
 
<?php
		// jQuery
		wp_enqueue_script('jquery');
		// This will enqueue the Media Uploader script
		wp_enqueue_media();
		global $wpdb;
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$table_name2 =  $wpdb->prefix."boffin_portfolio_categories";
        $cid = explode("portfolio-id=",$actual_link);
        $currentport_id = $cid[1];
		$get_categories = $wpdb->get_results( "SELECT * FROM $table_name2 ORDER BY sort_order" );
?>
<br/>

 <form method="POST" action="?page=list-portfolio" class="fom1">
 <h1>Edit Portfolio</h1>
  <table class="form-table" id="ftable_apps" role="presentation">
  <tbody>
   <tr scope="row">
   <th scope="row" colspan="3">
 <?php
 $portfolio_image = "";
 if( $image_id = wp_get_attachment_image_src( $portfolio_image ) ) {
 if($default_row->portfolio_image != "")
			{
			 echo '<a href="#" class="misha-upl"><img width="400px" src="' . $default_row->portfolio_image . '" value="' . $default_row->portfolio_image . '"/></a>
				  <a href="#" class="misha-rmv">Remove image</a>
				  <input type="hidden" name="portfolio_image" value="' . $default_row->portfolio_image . '">';
			}
			else
			{
				 echo '<a href="#" class="misha-upl"><img width="400px" src="' . $default_row->portfolio_image . '" /></a>
				  <a href="#" class="misha-rmv">Remove image</a>
				  <input type="hidden" name="portfolio_image" value="' . $default_row->portfolio_image . '">';
			}
		} else {
          if($default_row->portfolio_image != "")
		  {
			echo '<a href="#" class="misha-upl"> <img width="400px" src="' . $default_row->portfolio_image . '" value="' . $default_row->portfolio_image . '"/></a>
				  <a href="#" class="misha-rmv" style="">Remove image</a>
				  <input type="hidden" name="portfolio_image" value="' . $default_row->portfolio_image . '">';
		  }
          else
				{			  
			 	  echo '<a href="#" class="misha-upl">Upload image</a>
			       <a href="#" class="misha-rmv" style="display:none">Remove image</a>
			       <input type="hidden" name="portfolio_image" value="">';
				}
	 } 

 ?></th>
 </tr> 
  <tr> 
    <th scope="row"><label>Portfolio Name: </label> </th>
    <td><input type="text" value="<?php echo $default_row->portfolio_name; ?>" name="portfolio_name" required="required"/> </td>
  </tr>
  <tr>
	 <th scope="row"> <label>Description </label></th>
	 <td><textarea type="text" name="portfolio_description" value="<?php echo $default_row->portfolio_description; ?>"required="required" class="textarea_description"/><?php echo $default_row->portfolio_description; ?></textarea>   
	 </td>
   </tr>
    <tr>
		<th scope="row"><label> url: </label></th>
		<td><input type="text" name="portfolio_url" value="<?php echo $default_row->portfolio_url; ?>" /></td>
    </tr>
 
     <tr style="display:none;">
		<th scope="row"><label>Open in new Tab: </label></th>
		<td class="new_tab">
		<input type="radio" id="yes1" name="new_tab" value="1" <?php if($default_row->new_tab == "1") { ?> checked<?php } ?>>
		<label class="newtabs" for="yes1">Yes</label><br>
		<input type="radio" id="no1" name="new_tab" value="0" <?php if($default_row->new_tab == "0") { ?> checked <?php 
		 } ?>>
		<label class="newtabs" for="no1">No</label><br>
		</td>
    </tr>
    <tr>
    <th scope="row"><label> Select Categories : </label></th>
	 <td> 
		<select name="my_meta_box_select[]" id="my_meta_box_select" multiple>
		<?php foreach($get_categories as $values) { 	
		  $withslash = $values->portfolio_cat_name;
          $withslash = str_replace('/', ' ', $withslash);
		?>
			<option value="<?php echo $withslash;?>" <?php if(strpos($default_row->portfolio_categories, $withslash) !== false){ ?> selected="selected" <?php } ?>><?php echo $values->portfolio_cat_name;?></option>
		<?php } ?>
		</select>
 
	 </td>
   </tr>
		<th scope="row"><label>SORT ORDER: </label></th>
		<td><input type="number" class="sort-order-number" name="sort_order" value="<?php echo $default_row->sort_order; ?>" required="required">
	    </td>
  </tr>
   <tr>
            <th scope="row"><label for="capacity">Background Color: </label></th>
		    <td> <input name="bg_color" id="capacity" type="color" value="<?php echo $default_row->bg_color; ?>" class="regular-text"  required="required"></td>
	      </tr>
        <tr>
          
		  </tr>
		  
		  <tr>
            <th scope="row"><label for="capacity">Title Color: </label></th>
		    <td> <input name="title_color" id="capacity" type="color" value="<?php echo $default_row->title_color; ?>" class="regular-text"  required="required"></td>
	      </tr>
		  
		  <tr>
            <th scope="row"><label for="capacity">Description Color: </label></th>
		    <td> <input name="description_color" id="capacity" type="color" value="<?php echo $default_row->description_color; ?>" class="regular-text"  required="required"></td>
	      </tr>  
		  <tr>
            <th scope="row"><label for="capacity">Button Text Color: </label></th>
		    <td> <input name="button_text_color" id="capacity" type="color" value="<?php echo $default_row->button_text_color; ?>" class="regular-text"  required="required"></td>
	      </tr>
		  
		  <tr>
            <th scope="row"><label for="capacity">Button Background Color: </label></th>
		    <td> <input name="button_color" id="capacity" type="color" value="<?php echo $default_row->button_color; ?>" class="regular-text"  required="required"></td>
	      </tr>  
     <input name="cid" type="hidden" value="<?php echo $currentport_id; ?>"/>
	  <td> </td>
	 <td><input type="submit" name="formedit" value="Save" class="" /></td>
  </tr>
  </tbody>
 </table>
</form>
 
<?php
}


/* Add new Portfolio */ 
 
function boffincoders_portfolio_boffin_form_page_handler() {
 
  global $wpdb;
  $table_name2 =  $wpdb->prefix."boffin_portfolio_categories";
  $get_categories = $wpdb->get_results( "SELECT * FROM $table_name2 ORDER BY sort_order" );
  wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
  ?>
 <link rel="stylesheet" href="style.css">
  
<script>
jQuery(function($){
	// on upload button click
	$('body').on( 'click', '.misha-upl', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			button.html('<img width="100%" src="' + attachment.url + '" value="">').next().show().next().val(attachment.url);
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.misha-rmv', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});
 
	
$('body').on('click', '.misha-rmv2', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});

});
 
</script> 
<?php
// jQuery
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
?>

<link rel="stylesheet" href="style.css">
 <br/>
 <form method="POST" action="?page=list-portfolio" class="fom1">
  <h1>Add new Portfolio</h1>
  <table class="form-table" id="ftable_apps" role="presentation">
  <tbody>
   <tr scope="row">
   <th scope="row" colspan="2">
 <?php
 $portfolio_image = "";
			 	  echo '<a href="#" class="misha-upl">Upload image</a>
			       <a href="#" class="misha-rmv" style="display:none">Remove image</a>
			       <input type="hidden" name="portfolio_image" value="">';
	 

 ?></th>
 </tr> 
  <tr> 
    <th scope="row"><label>Portfolio Name: </label> </th>
    <td><input type="text" name="portfolio_name" required="required"/> </td>
  </tr>
  <tr>
		<th scope="row"> <label>Description </label></th>
		 <td> <textarea type="text" name="portfolio_description" required="required" class="textarea_description" rows="10" cols="23"/> </textarea>
		 </td>
  <tr>
		<th scope="row"><label> url: </label></th>
		<td><input type="text" name="portfolio_url"/></td>
  </tr>
   
  <tr style="display:none;">
		<th scope="row"><label>URL location: </label></th>
		<td class="new_tab">
		<input type="radio" id="live" name="live_github" value="1" checked="checked"/>
		<label class="newtabs" for="live">Live</label><br>
		<input type="radio" id="github" name="live_github" value="0"/>
		<label class="newtabs" for="github">Github</label><br>
		</td>
  </tr>
 
  <tr style="">
		<th scope="row"><label>Open in new Tab: </label></th>
		<td class="new_tab">
		<input type="radio" id="yes1" name="new_tab" value="1" checked="checked">
		<label class="newtabs" for="yes1">Yes</label><br>
		<input type="radio" id="no1" name="new_tab" value="0">
		<label class="newtabs" for="no1">No</label><br>
		</td>
  </tr>

   <tr>
   <th scope="row"><label> Select Categories : </label></th>
	 <td> 
		<select name="my_meta_box_select[]" id="my_meta_box_select" style="width:200px;" multiple>
		<?php foreach($get_categories as $values) {
		  $withslash = $values->portfolio_cat_name;
          $withslash = str_replace('/', ' ', $withslash);
			?>
			<option value="<?php echo $withslash; ?>"><?php echo $values->portfolio_cat_name;?></option>
		<?php } ?>
		</select>
	 </td>
   </tr>
 
  
   <tr>
		<th scope="row"><label>sort order: </label></th>
		<td><input type="number" class="sort-order-number" name="sort_order" value="<?php //echo $default_row->sort_order; ?>" required="required" />
	    </td>
  </tr>
  <tr>
            <th scope="row"><label for="capacity">Background Color: </label></th>
		    <td><input name="bg_color" id="capacity" type="color" value="#ffffff" class="regular-text"  required="required" />
	      </tr>
 
		  <tr>
		    <th scope="row"><label for="capacity">Title Color: </label></th>
		    <td><input name="title_color" id="capacity" type="color" value="#000" class="regular-text"  required="required" />
	      </tr> 
		  
		  <tr>
		    <th scope="row"><label for="capacity">Description Color: </label></th>
		    <td><input name="description_color" id="capacity" type="color" value="#000" class="regular-text"  required="required" />
	      </tr>
		  <tr>
		    <th scope="row"><label for="capacity">Button Text Color: </label></th>
		    <td><input name="button_text_color" id="capacity" type="color" value="#fff" class="regular-text"  required="required" />
	      </tr>
		  <tr>
		    <th scope="row"><label for="capacity">Button Background Color: </label></th>
		    <td><input name="button_color" id="capacity" type="color" value="#000" class="regular-text"  required="required" />
	      </tr>
  <input name="cid" type="hidden"/>
     <td> </td>
	 <td><input type="submit" name="form1" value="Save" /></td>
  </tr>
  </tbody>
 </table>
</form>
 
 <?php
}

 
/* Portfolio Frontend design 1 */
 
function boffincodersPortfolioImagespage() {
	ob_start();
	global $wpdb;
	wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
	$portfolio_table = $wpdb->prefix."boffin_portfolio";
	$portfolio_category =  $wpdb->prefix."boffin_portfolio_categories";
	$portfolio_style =  $wpdb->prefix."boffin_portfolio_styles";
	$portfolios = $wpdb->get_results( "SELECT * FROM $portfolio_table ORDER BY sort_order" );
	$categories = $wpdb->get_results( "SELECT * FROM $portfolio_category ORDER BY sort_order" );
	$styles = $wpdb->get_row( "SELECT * FROM $portfolio_style WHERE id = 1" );
	?>
  
 <style>


</style> 
 
<div class="first-main-boffin-portfolio">
 
<div id="myBtnContainer">
<style>
#myBtnContainer .btn
{
	color:<?php echo $styles->filter_button_text_color_inactive; ?>;
	font-size:<?php echo $styles->filter_btn_font_size; ?>;
	background:<?php echo $styles->filter_button_bkg_color_inactive; ?>;
	border:transparent;
	margin-left:5px;
	padding:7px 14px;
	border-radius:5px;
}

#myBtnContainer .btn.active
{
	color:<?php echo $styles->filter_button_text_color_active; ?> !Important;
	background:<?php echo $styles->filter_button_bkg_color_active; ?> !Important;
	border:transparent;
}
</style>  
  <button class="btn active" onclick="bcodersportfoilofilterSelection('all')">Show All</button>
  <?php
  foreach ($categories as $catValue)
  {
	  ?>
	  <button style="" class="btn" onclick="bcodersportfoilofilterSelection('<?php echo $catValue->portfolio_cat_name; ?>')"> <?php echo $catValue->portfolio_cat_name; ?></button>
  
  <?php } ?>
  
</div>

<!-- Portfolio Gallery Grid -->
<div class="row">
 
  <?php
  foreach ($portfolios as $portValue)
  {
    ?>
  <div class="column <?php echo $portValue->portfolio_categories; ?> ">
    <div class="content">
      <img class="boffin-port-image" src="<?php echo $portValue->portfolio_image; ?>" alt="<?php echo $portValue->portfolio_name; ?>" style="">
      <b class="boffin-portfolio-heading"> </b>
      <p class="boffin-portfolio-description"> </p>
    </div>
  </div>
  
 <?php } ?>
 
</div>
 
</div>

<script>
bcodersportfoilofilterSelection("all")
function bcodersportfoilofilterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    bcodersportfoliow3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) bcodersportfoliow3AddClass(x[i], "show");
  }
}

function bcodersportfoliow3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function bcodersportfoliow3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
<?php
  return ob_get_clean();
}
 
add_shortcode('boffin-portfolio-design1', 'boffincodersPortfolioImagespage'); 
 
/* Portfolio Frontend design 2 */ 
 
function boffincodersPortfolioImagespageone() {
   ob_start();
   global $wpdb;
   wp_enqueue_style('style_file' , plugin_dir_url(__FILE__).'style.css');  
   $portfolio_table = $wpdb->prefix."boffin_portfolio";
   $portfolio_category =  $wpdb->prefix."boffin_portfolio_categories";
   $portfolio_style =  $wpdb->prefix."boffin_portfolio_styles";
   $portfolios = $wpdb->get_results( "SELECT * FROM $portfolio_table ORDER BY sort_order" );
   $categories = $wpdb->get_results( "SELECT * FROM $portfolio_category ORDER BY sort_order" );
   $styles = $wpdb->get_row( "SELECT * FROM $portfolio_style WHERE id = 1" );
   ?>
 
<style>
 
 
 
</style> 
 
<div class="second-main-boffin-portfolio">
 
<div id="myBtnContainer">
<style>
#myBtnContainer .btn
{
	color:<?php echo $styles->filter_button_text_color_inactive; ?>;
	font-size:<?php echo $styles->filter_btn_font_size; ?>;
	background:<?php echo $styles->filter_button_bkg_color_inactive; ?>;
	border:transparent;
	margin-left:5px;
	padding:7px 14px;
	border-radius:5px;
}

#myBtnContainer .btn.active
{
	color:<?php echo $styles->filter_button_text_color_active; ?> !Important;
	background:<?php echo $styles->filter_button_bkg_color_active; ?> !Important;
	border:transparent;
}
</style> 
  
  <button class="btn active" onclick="bcodersportfoilofilterSelection('all')"> Show All</button>
  <?php
  foreach ($categories as $catValue)
  {
	  ?>
	  <button class="btn" onclick="bcodersportfoilofilterSelection('<?php echo $catValue->portfolio_cat_name; ?>')"> <?php echo $catValue->portfolio_cat_name; ?></button>
  
  <?php } ?>
  
</div>

<!-- Portfolio Gallery Grid -->
<div class="row">
 
  <?php
  foreach ($portfolios as $portValue)
  {
    ?>
   <div class="column <?php echo $portValue->portfolio_categories; ?> " style="background: <?php if($styles->unique_for_everyone == 'yes') { echo $portValue->bg_color; } else { echo $styles->background_color;} ?>;border-radius: <?php if($styles->unique_for_everyone == 'yes') { echo $styles->border_radius; } else { echo $styles->border_radius;} ?>">
    <div class="content">
     <div class="boffin-portfolio-image-left"> <img class="boffin-port-image" src="<?php echo $portValue->portfolio_image; ?>" alt="<?php echo $portValue->portfolio_name; ?>" style="">
	 </div>
	

    <?php if($styles->unique_for_everyone == 'yes') { ?>
	<div class="boffin-portfolio-title-description-etc"><h4 style="color:<?php echo $portValue->title_color; ?>;font-size:<?php echo $styles->title_size;?>;" ><?php echo $portValue->portfolio_name; ?></h4>
    <?php } else { ?>
	<div class="boffin-portfolio-title-description-etc"><h4 style="color:<?php echo $styles->title_color; ?>;font-size:<?php echo $styles->title_size;?>;" ><?php echo $portValue->portfolio_name; ?></h4>
    <?php } ?>
	   
	<?php if($styles->unique_for_everyone == 'yes') { ?> 
		 
		
	<p style="color:<?php echo $portValue->description_color; ?>;font-size:<?php echo $styles->description_size;?>;" class="boffin-portfolio-description"><?php echo $portValue->portfolio_description; ?></p>
	 <?php } else { ?>
	<p style="color:<?php echo $styles->description_color;?>;font-size:<?php echo $styles->description_size;?>;" class="boffin-portfolio-description"><?php echo $portValue->portfolio_description; ?></p>
	 <?php } ?>

	<?php if($styles->unique_for_everyone == 'yes') { ?>
	<a class="read-more-button" href="<?php echo $portValue->portfolio_url; ?>" style="background-color:<?php echo $portValue->button_color;?>;color:<?php echo $portValue->button_text_color;?>;font-size:<?php echo $styles->button_size; ?>">Read More</a>
	<?php } else { ?>
	<a class="read-more-button" href="<?php echo $portValue->portfolio_url; ?>" style="background-color:<?php echo $styles->button_color;?>;color:<?php echo $styles->button_text_color;?>;font-size:<?php echo $styles->button_size; ?>">Read More</a>	
	<?php } ?>
	</div>
	</div>
  </div>
  
 <?php } ?>
 
 
</div>
 
</div>

<script>
bcodersportfoilofilterSelection("all")
function bcodersportfoilofilterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    bcodersportfoliow3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) bcodersportfoliow3AddClass(x[i], "show");
  }
}

function bcodersportfoliow3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function bcodersportfoliow3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
<?php
  return ob_get_clean();
}
 
add_shortcode('boffin-portfolio-design2', 'boffincodersPortfolioImagespageone'); 


/* Delete Portfolio */

function boffincoders_portfolio_delete_single() {
	  global $wpdb;
	  $table_name =  $wpdb->prefix."boffin_portfolio";
	  $deleteid = sanitize_text_field($_POST['deleteid']);
	  $category_selected = sanitize_text_field($_POST['category_selected']);

	  $wpdb->delete( $table_name, array( 'portfolio_id' => $deleteid ) );
      $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	  print_r("<p class='greentext' >Item Deleted Successfully</p>");
  
      echo '<script>window.location.replace("?page=list-portfolio")</script>';	 
}
