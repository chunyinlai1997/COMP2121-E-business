<?php
include_once 'config.php';
include_once 'token.php';

function print_row_product($sql){
  $m_id = isloggedin();
  $sqlp = mysql_query("$sql");  //get  products

  $output = "<div class='row list-unstyled'>";
  $count = mysql_num_rows($sqlp);

  while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
   $product_id = $rowp[0];
   $seller_id = $rowp[6];
   $price = $rowp[1];
   $product_img = $rowp[2];
   $description = $rowp[3];
   $status = $rowp[4];
   $post_date = $rowp[5];
   $sqlp2 = mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$product_id' ");
   $row_accept = mysql_fetch_array($sqlp2,MYSQL_NUM);
   $model_name = $row_accept[0];
   $product_type = $row_accept[1];
   $brand = "";
   $re_price = 0;
   $size = "";

   if($product_type=="bag"){
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM bag WHERE model_name = '$model_name' ");
     $detail = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $detail[0];
     $re_price = $detail[1];
     $size = $detail[2];
   }
   else{
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM accessories WHERE model_name = '$model_name' ");
     $details = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $details[0];
     $re_price = $details[1];
     $size = $details[2];
   }
   $sqlp4 = mysql_query("SELECT firstname,lastname FROM member WHERE m_id = '$seller_id' ");
   $seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);
   $full_name = $seller_detail[0]." ".$seller_detail[1];
   $check1 = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp2 = mysql_fetch_array($check1,MYSQL_NUM);
   $check2 = mysql_query("SELECT COUNT(*) FROM wishlist WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp3 = mysql_fetch_array($check2,MYSQL_NUM);
   $tg = "";
   $active = "";
   $tg2 = "";
   $active2 = "";
   if($rowp2[0]==0){
     $tg = "false";
     $active = "";
   }
   else{
     $tg = "true";
     $active = "active";
   }
   if($rowp3[0]==0){
     $tg2 = "false";
     $active2 = "";
   }
   else{
     $tg2 = "true";
     $active2 = "active";
   }
   $sql5 = mysql_query("SELECT status,quality,action FROM check_record WHERE product_id = '$product_id'");
   $row5 = mysql_fetch_array($sql5,MYSQL_NUM);

   $auth_label = "";

   if($row5[0]=="checked" and $row5[2]=="valid" ){
     $auth_label = "<i class='fa fa-check-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:green; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="need_change"){
     $auth_label = "<i class='fa fa-exclamation-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:yellow; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="invalid"){
     $auth_label = "<i class='fa fa-times' aria-hidden='true' style='margin-left:2px; padding:5px; color:red; font-size:150%;'></i>";
   }

   $print_btn = "";

   if($status=="in_stock"){
     $status = "In Stock";
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning  rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
       <a id='$product_id' class='adding btn btn-outline-info  rounded-circle mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
     }
   }
   else{
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
     }
   }
   include_once 'content.php';
   $stars = get_stars($seller_id);

   $csize = "";
   if($count==1){
     $csize = "media col-12";
   }
   else if($count==2){
     $csize = "media col-6";
   }
   else{
     $csize = "media col-12 col-sm-12 col-md-6 col-lg-4";
   }

   $output .= "
   <div class='$csize' style='margin-bottom:15px;'>
   <div class='row'>
     <div class='col-4'>
       <div class='row'>
         <div class='col-12'>
         <a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><img class='d-flex mr-3' src='$product_img' width='100' height='100'></a>
         </div>
         <div class='col-12'>
         $print_btn
         </div>
       </div>
     </div>
     <div class='col-8'>

           <h5><a href='shop_model?model_name=$model_name'  target='_blank'>$model_name</a></h5>
           <h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$brand'  target='_blank'>$brand</a></h6>
           <p>Seller: <a href='user_profile?m_id=$seller_id'>$full_name</a> $stars</p>
           <h6 class='mb-0 t'>$$price HKD  </h6>

           <h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
           $auth_label
           <a href='' style='margin-left:5px;' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h6 class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</h6></a>

     </div>
   </div>
  </div>
  ";
  }

  $output .="	</div><hr>";

  return array($output,$count);

}

function print_row_product_2($sql){
  $m_id = isloggedin();
  $sqlp = mysql_query("$sql");  //get  products

  $output = "<div class='row list-unstyled'>";
  $count = mysql_num_rows($sqlp);
  while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
   $product_id = $rowp[0];
   $seller_id = $rowp[6];
   $price = $rowp[1];
   $product_img = $rowp[2];
   $description = $rowp[3];
   $status = $rowp[4];
   $post_date = $rowp[5];
   $sqlp2 = mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$product_id' ");
   $row_accept = mysql_fetch_array($sqlp2,MYSQL_NUM);
   $model_name = $row_accept[0];
   $product_type = $row_accept[1];
   $brand = "";
   $re_price = 0;
   $size = "";
   if($product_type=="bag"){
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM bag WHERE model_name = '$model_name' ");
     $detail = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $detail[0];
     $re_price = $detail[1];
     $size = $detail[2];
   }
   else{
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM accessories WHERE model_name = '$model_name' ");
     $details = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $details[0];
     $re_price = $details[1];
     $size = $details[2];
   }
   $sqlp4 = mysql_query("SELECT firstname,lastname FROM member WHERE m_id = '$seller_id' ");
   $seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);
   $full_name = $seller_detail[0]." ".$seller_detail[1];
   $check1 = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp2 = mysql_fetch_array($check1,MYSQL_NUM);
   $check2 = mysql_query("SELECT COUNT(*) FROM wishlist WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp3 = mysql_fetch_array($check2,MYSQL_NUM);
   $tg = "";
   $active = "";
   $tg2 = "";
   $active2 = "";
   if($rowp2[0]==0){
     $tg = "false";
     $active = "";
   }
   else{
     $tg = "true";
     $active = "active";
   }
   if($rowp3[0]==0){
     $tg2 = "false";
     $active2 = "";
   }
   else{
     $tg2 = "true";
     $active2 = "active";
   }
   $sql5 = mysql_query("SELECT status,quality,action FROM check_record WHERE product_id = '$product_id'");
   $row5 = mysql_fetch_array($sql5,MYSQL_NUM);
   $auth_label = "";
   if($row5[0]=="checked" and $row5[2]=="valid" ){
     $auth_label = "<i class='fa fa-check-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:green; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="need_change"){
     $auth_label = "<i class='fa fa-exclamation-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:yellow; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="invalid"){
     $auth_label = "<i class='fa fa-times' aria-hidden='true' style='margin-left:2px; padding:5px; color:red; font-size:150%;'></i>";
   }
   $print_btn = "";
   if($status=="in_stock"){
     $status = "In Stock";
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning  rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
       <a id='$product_id' class='adding btn btn-outline-info  rounded-circle mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
     }
   }
   else{
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
     }
   }



   include_once 'content.php';
   $stars = get_stars($seller_id);
   $output .= "
   <div class='col-12' style='margin-bottom:15px;'>
   <div class='row'>
     <div class='col-4'>
       <div class='row'>
         <div class='col-12'>
         <a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><img class='d-flex mr-3' src='$product_img' width='100' height='100'></a>
         </div>
         <div class='col-12'>
         $print_btn
         </div>
       </div>
     </div>
     <div class='col-8'>
           <h5><a href='shop_model?model_name=$model_name'  target='_blank'>$model_name</a></h5>
           <h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$brand'  target='_blank'>$brand</a></h6>
           <p>Seller: <a href='user_profile?m_id=$seller_id'>$full_name</a> $stars</p>
           <h6 class='mb-0 t'>$$price HKD  </h6>

           <h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
           $auth_label
           <a href='' style='margin-left:2px;' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><p class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</hp></a>
     </div>
   </div>
  </div>
  ";
  }
  $output .="	</div><hr>";
  return array($output,$count);
}

function print_row_product_3($sql){
  $m_id = isloggedin();
  $sqlp = mysql_query("$sql");  //get  products

  $output = "<div class='row list-unstyled'>";
  $count = mysql_num_rows($sqlp);
  while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
   $product_id = $rowp[0];
   $seller_id = $rowp[6];
   $price = $rowp[1];
   $product_img = $rowp[2];
   $description = $rowp[3];
   $status = $rowp[4];
   $post_date = $rowp[5];
   $sqlp2 = mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$product_id' ");
   $row_accept = mysql_fetch_array($sqlp2,MYSQL_NUM);
   $model_name = $row_accept[0];
   $product_type = $row_accept[1];
   $brand = "";
   $re_price = 0;
   $size = "";
   if($product_type=="bag"){
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM bag WHERE model_name = '$model_name' ");
     $detail = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $detail[0];
     $re_price = $detail[1];
     $size = $detail[2];
   }
   else{
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM accessories WHERE model_name = '$model_name' ");
     $details = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $details[0];
     $re_price = $details[1];
     $size = $details[2];
   }
   $sqlp4 = mysql_query("SELECT firstname,lastname FROM member WHERE m_id = '$seller_id' ");
   $seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);
   $full_name = $seller_detail[0]." ".$seller_detail[1];
   $check1 = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp2 = mysql_fetch_array($check1,MYSQL_NUM);
   $check2 = mysql_query("SELECT COUNT(*) FROM wishlist WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp3 = mysql_fetch_array($check2,MYSQL_NUM);
   $tg = "";
   $active = "";
   $tg2 = "";
   $active2 = "";
   if($rowp2[0]==0){
     $tg = "false";
     $active = "";
   }
   else{
     $tg = "true";
     $active = "active";
   }
   if($rowp3[0]==0){
     $tg2 = "false";
     $active2 = "";
   }
   else{
     $tg2 = "true";
     $active2 = "active";
   }
   $sql5 = mysql_query("SELECT status,quality,action FROM check_record WHERE product_id = '$product_id'");
   $row5 = mysql_fetch_array($sql5,MYSQL_NUM);
   $auth_label = "";
   $auth_status = "";
   if($row5[0]=="checked" and $row5[2]=="valid" ){
     $auth_label = "<i class='fa fa-check-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:green; font-size:150%;'></i>";
     $auth_status ="Checked";
   }
   else if($row5[0]=="checked" and $row5[2]=="need_change"){
     $auth_label = "<i class='fa fa-exclamation-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:yellow; font-size:150%;'></i>";
     $auth_status ="Suggested to Modify";
   }
   else if($row5[0]=="checked" and $row5[2]=="invalid"){
     $auth_label = "<i class='fa fa-times' aria-hidden='true' style='margin-left:2px; padding:5px; color:red; font-size:150%;'></i>";
     $auth_status ="Invalid";
   }
   else if($row5[0]=="checking"){
     $auth_status ="Checking";
   }
   else if($row5[0]=="waiting"){
     $auth_status ="Waiting for arrival";
   }
   else if($row5[0]=="NA"){
     $auth_status ="Not Applicable";
   }

   $UD_button="";
   if($status!="sold"){
     $UD_button = "<a href='modify_product?product_id=$product_id' style='margin-left:3px;' id='$product_id' ><p class='badge badge-info rounded-0' style='font-size:1em;'>Modify</p></a>
     <a href='delete_product?product_id=$product_id' style='margin-left:5px;' id='$product_id' class='delete_details'><p class='badge badge-secondary rounded-0' style='font-size:1em;'>DELETE</p></a>";
   }

   $print_btn = "";
   if($status=="in_stock"){
     $status = "In Stock";
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning  rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
       <a id='$product_id' class='adding btn btn-outline-info  rounded-circle mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
     }
   }
   else{
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
     }
   }
   include_once 'content.php';
   $stars = get_stars($seller_id);
   $output .= "
   <div class='col-12' style='margin-bottom:15px;'>
   <div class='row'>
     <div class='col-4'>
       <div class='row'>
         <div class='col-12'>
         <a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><img class='d-flex mr-3' src='$product_img' width='100' height='100'></a>
         </div>
         <div class='col-12'>
         $print_btn
         </div>
       </div>
     </div>
     <div class='col-8'>
           <h5><a href='shop_model?model_name=$model_name'  target='_blank'>$model_name</a></h5>
           <h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$brand'  target='_blank'>$brand</a></h6>
           <h6 class='mb-0 t'>Selling Price: $$price HKD  </h6>
           <h6>Authentication:$auth_status</h6>
           <h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
           $auth_label
           <a href='' style='margin-left:2px;' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h6 class='badge badge-danger rounded-0' style='font-size:1em;'>VIEW</h6></a>
           $UD_button
     </div>
   </div>
  </div>
  ";
  }
  $output .="	</div><hr>";
  return array($output,$count);
}


if(isset($_POST['sql'])){

  $sql = $_POST['sql'];

  $m_id = isloggedin();
  $sqlp = mysql_query("$sql");  //get  products

  $output = "<div class='row list-unstyled'>";
  $count = mysql_num_rows($sqlp);

  while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
   $product_id = $rowp[0];
   $seller_id = $rowp[6];
   $price = $rowp[1];
   $product_img = $rowp[2];
   $description = $rowp[3];
   $status = $rowp[4];
   $post_date = $rowp[5];
   $sqlp2 = mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$product_id' ");
   $row_accept = mysql_fetch_array($sqlp2,MYSQL_NUM);
   $model_name = $row_accept[0];
   $product_type = $row_accept[1];
   $brand = "";
   $re_price = 0;
   $size = "";

   if($product_type=="bag"){
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM bag WHERE model_name = '$model_name' ");
     $detail = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $detail[0];
     $re_price = $detail[1];
     $size = $detail[2];
   }
   else{
     $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM accessories WHERE model_name = '$model_name' ");
     $details = mysql_fetch_array($sqlp3,MYSQL_NUM);
     $brand = $details[0];
     $re_price = $details[1];
     $size = $details[2];
   }
   $sqlp4 = mysql_query("SELECT firstname,lastname FROM member WHERE m_id = '$seller_id' ");
   $seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);
   $full_name = $seller_detail[0]." ".$seller_detail[1];
   $check1 = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp2 = mysql_fetch_array($check1,MYSQL_NUM);
   $check2 = mysql_query("SELECT COUNT(*) FROM wishlist WHERE m_id ='$m_id' AND product_id='$product_id'");
   $rowp3 = mysql_fetch_array($check2,MYSQL_NUM);
   $tg = "";
   $active = "";
   $tg2 = "";
   $active2 = "";
   if($rowp2[0]==0){
     $tg = "false";
     $active = "";
   }
   else{
     $tg = "true";
     $active = "active";
   }
   if($rowp3[0]==0){
     $tg2 = "false";
     $active2 = "";
   }
   else{
     $tg2 = "true";
     $active2 = "active";
   }
   $sql5 = mysql_query("SELECT status,quality,action FROM check_record WHERE product_id = '$product_id'");
   $row5 = mysql_fetch_array($sql5,MYSQL_NUM);

   $auth_label = "";

   if($row5[0]=="checked" and $row5[2]=="valid" ){
     $auth_label = "<i class='fa fa-check-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:green; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="need_change"){
     $auth_label = "<i class='fa fa-exclamation-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:yellow; font-size:150%;'></i>";
   }
   else if($row5[0]=="checked" and $row5[2]=="invalid"){
     $auth_label = "<i class='fa fa-times' aria-hidden='true' style='margin-left:2px; padding:5px; color:red; font-size:150%;'></i>";
   }

   $print_btn = "";

   if($status=="in_stock"){
     $status = "In Stock";
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning  rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
       <a id='$product_id' class='adding btn btn-outline-info  rounded-circle mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
     }
   }
   else{
     if($seller_id!=$m_id){
       $print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
     }
   }
   include_once 'content.php';
   $stars = get_stars($seller_id);

   $csize = "";
   if($count==1){
     $csize = "media col-12";
   }
   else if($count==2){
     $csize = "media col-6";
   }
   else{
     $csize = "media col-12 col-sm-12 col-md-6 col-lg-4";
   }

   $output .= "
       <div class='$csize' style='margin-bottom:15px;'>
       <div class='row'>
         <div class='col-4'>
           <div class='row'>
             <div class='col-12'>
             <a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><img class='d-flex mr-3' src='$product_img' width='100' height='100'></a>
             </div>
             <div class='col-12'>
             $print_btn
             </div>
           </div>
         </div>
         <div class='col-8'>

               <h5><a href='shop_model?model_name=$model_name'  target='_blank'>$model_name</a></h5>
               <h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$brand'  target='_blank'>$brand</a></h6>
               <p>Seller: <a href='user_profile?m_id=$seller_id'>$full_name</a> $stars</p>
               <h6 class='mb-0 t'>$$price HKD  </h6>
               <h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
               $auth_label
               <a href='' style='margin-left:5px;' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h6 class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</h6></a>

         </div>
       </div>
      </div>
      ";
  }

  $output .="	</div><hr>";

  $array = array($output,$count);
  echo json_encode($array);
}

?>
