<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
  header('Location:login.php?need_login=True');
}
if(!isactivated()){
  header('Location:activate.php');
}

if(!isseller()){
  header('Location:become_seller');
}

$m_id = isloggedin();

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
    <meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
    <meta name="author" content="Willon Lai">
    <title>Guideline for selling product | LuxToTrade COMP2121 Project</title>
    <link rel="icon" href="images/brand_logo_small_icon.png" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css" />
    <link rel="stylesheet" href="css/waypoints.css" />
    <script src="js/scroll.js"></script>
    <script src="js/waypoints.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <style>
    .wrap {
      margin-top:80px;
      padding-left : 50px;
      padding-right : 50px;
      width:100%;
    }
    .modal-backdrop
    {
      opacity:1 !important;
    }
    </style>
    <script>
    $(document).ready(function(){$('#tell').modal('show');});
    </script>
  </head>
  <body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="home#"><img src="images/brand_logo_black.png" width="100" height="50"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar1" aria-controls="Navbar1"
        aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="Navbar1">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="shop">Back</a>
          </li>
        </ul>
         <!-- Search form -->
        <ul class="navbar-nav ml-auto nav-flex-icons row">
          <li class="nav-item avatar dropdown">
            <a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1" style="width:50%;">
              <a class="dropdown-item" href="profile.php">Profile</a>
              <a class="dropdown-item" href="#">Help</a>
              <hr>
              <a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="wrap">
      <div class="col-md-10 offset-md-1">

    </div>
    <h1 style="text-align:center;">GUIDELINES</h1>
      <div class="row">
        <ul class="nav nav-tabs col-md-11">
          <li class="nav-item">
            <a href="" data-target="#brands" data-toggle="tab" class="nav-link active">Brands and Models</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#condition" data-toggle="tab" class="nav-link ">Condition</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#picture" data-toggle="tab" class="nav-link">Pictures</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#authenticity" data-toggle="tab" class="nav-link">Authenticity</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#refusals" data-toggle="tab" class="nav-link">Refusals</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#safe" data-toggle="tab" class="nav-link">Product Safeguard</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#pricing" data-toggle="tab" class="nav-link">Pricing</a>
          </li>
          <li class="nav-item">
            <a style="color:red; font-weight:600; font-size:110%;" href="sell" class="nav-link">Start Selling</a>
          </li>
        </ul>
      </div>

      <div class="tab-content p-b-3">

        <div class="tab-pane active" id="brands">

          <h4 class="m-y-2" style="margin-top:30px;">WHAT WE ACCEPT</h4>
          <div class="row">
            <div class="col-md-12">
              <h6 style="margin-top:10px; font-size:200%; text-align:center;">Bag Brands</h6>
            </div>
            <?php
              $brand1 = mysql_query("SELECT bag_color.product_image,bag.brand FROM bag_color,bag WHERE bag_color.bag_id=bag.bag_id GROUP BY bag.brand ");
              while($brand_row = mysql_fetch_array($brand1,MYSQL_NUM)) {
                echo "<div class='col-6 col-sm-4 col-md-3 col-lg-2'><img src='$brand_row[0]' width='180' height='180'/><h6>$brand_row[1]</h6></div>";
              }
            ?>
            </div>

            <h6 style="margin-top:10px; font-size:200%; text-align:center; ">Accessories Brands</h6>
            <div class="row">
            <?php $brand1 = mysql_query("SELECT product_image,brand FROM accessories GROUP BY brand");
                 while($brand_row = mysql_fetch_array($brand1,MYSQL_NUM)) {
                    echo "<div class='col-6 col-sm-4 col-md-3 col-lg-2'><img src='$brand_row[0]' width='180' height='180'/><h6>$brand_row[1]</h6></div>";
                  }
            ?>
            </div>

          </div>


        <div class="tab-pane" id="condition">
        <h4 class="m-y-2" style="margin-top:30px;">CONDITION</h4>
          <div class="row">
              <h6 style="margin-top:10px;">CORNER WEAR</h6>
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <div class="p-7">
                        <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-1-min.jpg" >
                        <p> Minor to no wear on corners</p>
                      </div>
                  </div>
                  <div class="col-md-4 ">
                      <div class="p-7">
                        <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-2-min.jpg" alt="">
                        <p>Visible significant wear including tearing and discoloration</p>
                      </div>
                    </div>
                  </div>

              <h6 style="margin-top:10px;">HANDLE DARKENING / WEAR</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-3-min.jpg" >
            <p>Very little to no wear or handle darkening</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-4-min.jpg" alt="">
          <p>Visible handle darkening, discoloration, worn leather</p>
                  </div>
                </div>
              </div>

        <h6 style="margin-top:10px;">EXTERIOR MARKS / SCRATCHES</h6>
              <div class="row align-items-center">

                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-5-min.jpg" >
            <p>Little to no scratching or very faint scratches or marks</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-6-min.jpg" alt="">
          <p>Significant scratches and marks on bag</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">DISCOLORATION / FADING</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-7-min.jpg" >
            <p>Little to no discoloration/fading of leather</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-8-min.jpg" alt="">
          <p>Obvious fading/discoloration of leather</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">WATER STAINS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-9-min.jpg" >
            <p> Little to no water staining on leather</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-10-min.jpg" alt="">
          <p>OVery noticeable and obvious water stains on leather</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">INTERIOR SCRATCHES</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-11-min.jpg" >
            <p> Noticeable scratches, faint hairline scratches</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-12-min.jpg" alt="">
          <p>Multiple visible scratches throughout interior</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">INTERIOR STAINS / PEN MARKS</h6>
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-13-min.jpg" >
                      <p> Very little to no pen marks or other marks of any kind</p>
                    </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-14-min.jpg" alt="">
          <p>Highly noticeable pen marks or any other marks</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">MISSING EMBELLISHMENTS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-15-min.jpg" >
            <p> No missing embellishments or only 1 or 2 missing embellishments</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-16-min.jpg" alt="">
          <p>Noticeably missing embellishments, clusters of 'bald spots'</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">MISSING STITCHES</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-17-min.jpg" >
            <p> No broken stitches or only 1 or 2 loose stitches</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-18-min.jpg" alt="">
          <p>Several broken and missing stitches</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">WAX EDGE PEELING / SPLITTING / MELTING</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-19-min.jpg" >
            <p> Little to no cracking on wax edges</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-20-min.jpg" alt="">
          <p> Moderate to heavy peeling, splitting or melting of wax edges</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">OVERALL STRUCTURE</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-21-min.jpg" >
            <p> Little to no creasing or slouching in shape</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-22-min.jpg" alt="">
          <p> Heavy creasing or loss of overall shape</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">HANDLE SHAPE</h6>
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-23-min.jpg" >
            <p>Slight creasing of handle shape</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/condition-24-min.jpg" alt="">
          <p>Heavy creasing or loss of handle shape</p>
                  </div>
                </div>
              </div>

          </div>
        </div>

        <div class="tab-pane" id="picture">
          <h4 class="m-y-2" style="margin-top:30px;">PICTURE</h4>
          <div class="row">
      <h6 style="margin-top:10px;">FULL FRONT PHOTOS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-1-min.jpg" >
            <p>Take a clear photo, showing the entire front of your bag</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-2-min.jpg">
          <p>Don't take partial or blurry photos of the front of your bag</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">CLEAR BACK PHOTOS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-3-min.jpg" >
            <p>Take a clear photo, showing the entire back of your bag</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-4-min.jpg">
          <p>Don't take partial or blurry photos of the back of your bag</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">HIGHLIGHT WEAR</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-5-min.jpg" >
            <p>Take a clear photo, showing wear in context of location on bag</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-6-min.jpg">
          <p>Don't take vague wide photo, that does not clearly identify wear</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">INTERIOR PHOTOS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-7-min.jpg" >
            <p>Take clear well-lit photo of interior while bag is opened wide</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-8-min.jpg">
          <p>Don't take dark, unclear photos of interior while bag is collapsed, partially closed, or filled with personal items</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">ACCESSORIES</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-9-min.jpg" >
            <p>Show that you have included accessories (i.e straps, pouches, dustbags etc)</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-10-min.jpg">
          <p>Don't omit accessories from photos, as it will be assumed they are not available</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">LIGHTING</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-11-min.jpg" >
            <p>Take photos in a well-lit area, free of cluttered surroundings. Natural sunlight is best</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-12-min.jpg">
          <p>Don't take photos that are overexposed or poorly lit</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">MULTIPLE BAGS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-13-min.jpg" >
            <p>Submit bags separately</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-14-min.jpg">
          <p>Don't include multiple bags in a single photo</p>
                  </div>
                </div>
              </div>
        <h6 style="margin-top:10px;">STOCK PHOTOS / SCREENSHOTS</h6>
              <div class="row align-items-center">
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-15-min.jpg" >
            <p>Submit personal photos of your bag</p>
          </div>

                </div>
                <div class="col-md-4 ">
                  <div class="p-7">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/photos-16-min.jpg">
          <p>Don't take screenshots, blog posts, or stock photos</p>
                  </div>
                </div>
              </div>



          </div>
        </div>

        <div class="tab-pane" id="authenticity">
          <h4 class="m-y-2" style="margin-top:30px;">AUTHENTICITY</h4>
          <div class="row">
      <h6 style="margin-top:10px;">CHANEL SERIAL CODES</h6>
              <div class="row align-items-center">
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-1-min.jpg" >
          </div>
                </div>
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-2-min.jpg">
                  </div>
                </div>
         <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-3-min.jpg">
                  </div>
                </div>
        <div class="col-md-8">
        <div class="p-7">
                    <p> Depending on model and year, Chanel serial codes can be located in various areas of a bag.  You can find these serial number stickers in the bottom interior corner, either affixed directly to the lining or on a leather tab in either the main interior compartment or interior pocket.</p>
                  </div>
        </div>
              </div>
      <h6 style="margin-top:10px;">HERMES BLINDSTAMP</h6>
              <div class="row align-items-center">
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-4-min.jpg" >
          </div>
                </div>
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-5-min.jpg">
                  </div>
                </div>
         <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-6-min.jpg">
                  </div>
                </div>
        <div class="col-md-8">
        <div class="p-7">
                    <p>Depending on the model of a Hermes bag you will find the blindstamp embossed directly on leather straps, interiors of bags and leather tabs inside the handbag.</p>
                  </div>
        </div>
              </div>
       <h6 style="margin-top:10px;">LOUIS VUITTON DATE CODE</h6>
              <div class="row align-items-center">
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-7-min.jpg" >
          </div>
                </div>
                <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-8-min.jpg">
                  </div>
                </div>
         <div class="col-md-3 ">
                  <div class="p-4">
                    <img class="img-fluid " src="//media.rebag.com/static/dressingbee/images/guidelines_images/auth-9-min.jpg">
                  </div>
                </div>
        <div class="col-md-8">
        <div class="p-7">
        <p>Depending on model and production year, LV date codes can be found embossed on leather tabs in the interior of the bag or printed directly on the interior linings.</p>
                  </div>
        </div>
              </div>
          </div>
        </div>

        <div class="tab-pane" id="refusals">
          <h4 class="m-y-2" style="margin-top:30px;">REFUSALS</h4>
          <div class="row">
            <div class='col-12'>
  						<p>Please note, we will not accept:</p>
  						<p>Inauthentic Items:</p>
  						<ul>
  						<li>Chanel, Louis Vuitton or Hermes brand with Missing or Illegible Interior Serial Codes</li>
  						<li>Press Samples (When Marked)</li>
  						<li>Employee/Sample Sale Items (When Marked)</li>
  						<li>Outlet Items</li>
  						<li>Hardsided Luggage over 60cm (Soft Foldable Luggage Over 60cm is Accepted)</li>
  						<li>Items Refurbished by Company Other Than Original Manufacturer</li>
  						<li>Broken or Missing Hardware</li>
  						<li>Personal Monogramming or Artistic Personalization</li>
  						</ul>
  					</div>
          </div>
        </div>

        <div class="tab-pane" id="safe">
          <h4 class="m-y-2" style="margin-top:30px;">Protect Safeguard</h4>
          <div class="row">
            <div class="col-12">
              <pre>
              We provide Product Safeguard service to all sellers that provide
              the Product Serial Code and apply 3D Scanning. If the product is being
               damaged after it was shipped, a reasonable compensation will be given to the seller.

              *Sellers are recommended to provide the Product Serial
               Code and apply 3D Scanning. If not, any damages occur after the
                product ship will not be accepted in our Product Safeguard service. Thi
                s is for avoiding seller sending damaged product instead of the original on
                e that they mention, and ask to claim compensation.
              </pre>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="pricing">
          <h4 class="m-y-2" style="margin-top:30px;">LuxPrime Service</h4>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Service Plan</th>
                <th>Fee (Standard Membership)</th>
                <th>Fee (Premium Membership)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Authentication Service + 3D Scanning Bundle</th>
                <td>$200</td>
                <td>$100</td>
              </tr>
              <tr>
                <th>3D Scanning</th>
                <td>$50</td>
                <td>$25</td>
              </tr>
            </tbody>
          </table>

          <h4 class="m-y-2" style="margin-top:30px;">Administration Charge</h4>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Type</th>
                <th>Fee (Standard Membership)</th>
                <th>Fee (Premium Membership)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Stoarge Fee</th>
                <td>5% of selling price</td>
                <td>2.5% of selling price</td>
              </tr>
            </tbody>
          </table>

        </div>

        <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="ModalContent1" aria-hidden="true">
      		<div class="modal-dialog" role="document">
      			<div class="modal-content">
      			  <div class="modal-header">
      				<h5 class="modal-title" id="ModalContent1">Logout?</h5>
      				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
      				  <span aria-hidden="true"></span>
      				</button>
      			  </div>
      			  <div class="modal-body">
      				Logout all device or this device?
      				<form role="form" action="logout.php" method="POST">
      					<button type="submit" name="L1" value="all" class="btn btn-danger">Logout All</button></a>
      					<button type="submit" name="L2" value="this" class="btn btn-primary">Logout This Device</button></a>
      				</form>
      			  </div>
      			  <div class="modal-footer">
      				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      			  </div>
      			</div>
      		  </div>
      	</div>

        <div id="tell" class="modal fade"  tabindex="-1"  role="dialog">
      		<div class="modal-dialog modal-lg" role="document">
      			<div class="modal-content">
      				<div class="modal-header">
      				<h5 class="modal-title">Procedure</h5>
      				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
      					<span aria-hidden="true"></span>
      				</button>
      				</div>
      				<div class="modal-body">
                <div class="row" style="margin-top:10px; margin-bottom:10px;">
      						<div class="col-12 col-md-4">
        						    <div style="text-align:center;">
        								<img class="section4-img" src="images/SELLORBUY.png" height="120" width="120" align="center"/>
                        </div>
        								<div class="section4-h2 font-weight-bold" style="text-align:center;">POST</div>
        								<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">Post your item on LuxToTrade. We'll send you a prepaid shipping label to your place so you can send it to us for free. The whole process can be done in 2-3 working days.</p>

        						</div>

        						<div class="col-12 col-md-4">
                      <div style="text-align:center;">
        							<img class="section4-img" src="images/AUTHENTICITY2.png" height="120" width="120" align="center">
                      </div>
        							<div class="section4-h2 font-weight-bold" style="text-align:center;">AUTHENTICATE</div>
        							<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">Ship your item within 2 business day after the buyer
        							purchase. We authenticate it and store it in our warehouse.</p>

        						</div>

        						<div class="col-12 col-md-4">
                      <div style="text-align:center;">
        							<img class="section4-img" src="images/MONEY.png" height="120" width="120" align="center">
                      </div>
        							<div class="section4-h2 font-weight-bold" style="text-align:center;">PROSPER</div>
        							<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">When the buyer make an order on your product, we'll
                        immediately send your item to the buyer and you'll immediately receive the earning paid by the buyer.</p>

        						</div>
        				</div>
      				</div>
      				<div class="modal-footer">
      				<button type="button" class="btn btn-secondary" data-dismiss="modal">Continue</button>
      				</div>
      			</div>
      			</div>
      	</div>

  </body>
</html>
