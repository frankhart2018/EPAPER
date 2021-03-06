<?php
    session_start();
    if(!isset($_SESSION['USER_ID']) || $_SESSION['ROLE'] != 'S')
     {
        echo "ERROR IN SESSION";
        exit;
     }
    include_once("../../../includes/config.php");
    include_once("../../../includes/general.php");

    $USER_ID = $_SESSION['USER_ID'];
    $pid = $_GET['q'];

    $tid = $_SESSION['tid'];

    $sql = "SELECT admin FROM topics WHERE id = $tid";
    $admin = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $admin = $admin['admin'];

    $sql = "SELECT * FROM paper WHERE id=$pid";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $filenames = explode(".", $row['filename']);
    $paper_name = strtoupper($filenames[0]);

    $filename = $row['filename'];
    $_SESSION['pid'] = $row['id'];

    $file_location = "../../../static/content/$admin/$filename";

?>
<html>
    <head>
      <title><?php echo $paper_name; ?></title>

      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../../../css/materialize.min.css"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="../../../css/buttons.css"  media="screen,projection"/>
      <link href="../../../css/material-icons.css" rel="stylesheet">

      <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML' async></script>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

       <style>
       .container
       {
           position: relative;
           top: 5%;
        }
         .htitle
         {
          margin-top: 5px;
        }
        .login
        {
            padding: 20px;
            font-size: 1.5em;
            margin-bottom: 0px;
        }
        .fontsize
        {
           font-size: 1rem !important;
        }
        .fontsizetxt
        {
          margin-top: 0px !important;
           font-size: 0.8rem !important;
            color: #303f9f ;
        }

        .padbot
        {
          margin-bottom: 0px !important;
          margin-top: 0px !important;
        }
        .txtbot
        {
           padding-top: 20px !important;
        }
        .title
        {
            font-size: 1em;
            color: #43a047;
            margin-bottom: 0px;
        }
        .btnsize
        {
          min-width: 40%  !important;
          margin-top: 20px;
        }
        .center-fix
        {
          margin-top: 10px;
         }
         .row-fix
         {
          margin-top: 0px;
        }
        #question1
        {
            font-size: 1.4em;
            width: 100%;
            height : 10%;
            border-color: #9e9e9e;
            border-top: none;
            border-right: none;
            border-left: none;
         }
        .ebtn
        {
          margin-top: 40px;
          height: 40px;
         }
         #preview
         {
          text-align: justify;
          }
        .tabs .tab a
        {
          background-color:#3949ab ;
          color: white;
        }
        .btn:hover
        {
          opacity: 0.5;
        }
        </style>
    </head>

    <body>

      <nav>
         <div class="<?php echo $color; ?> nav-wrapper">
           <a href="#!" class="brand-logo hide-on-small-only center"><?php echo $nav_title; ?></a>
           <a href="#!" class="brand-logo hide-on-med-and-up center"><?php echo $nav_short; ?></a>
           <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

           <ul id="nav-mobile" class="right hide-on-med-and-down">
             <li><a href="../archives/">Back</a></li>
             <li><a class="dropdown-trigger" data-target="dropdown1">More Options</a></li>
             <li class="active"><a href="../../../index.php">Logout</a></li>
           </ul>

         </div>
       </nav>

         <!-- Dropdown Structure -->
         <ul id="dropdown1" class="dropdown-content">
             <li><a href="#">Home</a></li>
             <li><a href="identify">Identify Interest</a></li>
             <li><a href="../write">Write Paper</a></li>
             <li><a href="profile/">Profile</a></li>
         </ul>


    <div class="container">
      <div class="row">
        <div class="col s12 m12">
          <div class="card z-depth-2">
             <div id="l1" class="login center-align <?php echo $color; ?> white-text"><?php echo $paper_name; ?></div>
            <div class="card-content">

              <div class="row">

                <?php

                    echo "<div class='row' style='text-align: justify; margin-left: 2%; margin-right: 2%;'>
                    <p>".file_get_contents($file_location)."</p></div>";

                    echo '
                    <div class="row" style="margin-left: 20px; margin-right: 20px;">
                      <hr><br>
                      <p style="font-size: 120%;">
                      <i class="material-icons" style="font-size: 120%;">comment</i>
                      <strong><u>Comments</u>:</p></strong>
                      <div class="input-field col s8 m6">
                          <input name="pname" id="comment" placeholder="Post comment" type="text" class="validate" data-length="200">
                      </div>

                      <div class="col s8 m6 center" style="margin-top: -15px;">
                          <br>
                          <a class=" btnsize waves-effect waves-light btn '.$color.'" id="add">POST COMMENT</a>
                      </div>

                    </div>
                    ';

                    $pid = $_SESSION['pid'];

                    $sql = "SELECT * FROM comments WHERE pid = $pid ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) == 0) {
                      echo "<div class='row' style='margin-left: 20px;'><p>No comments posted yet!</p></div>";
                    } else {
                      echo '<div class="row" style="margin-left: 20px; margin-right: 20px;">';

                      while($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <p><strong><u><i class="material-icons" style="font-size: 150%;">person</i>&nbsp;'.$row['uid'].'</u></strong></p>
                        <p style="margin-left: 20px;">'.$row['comment'].'</p>
                        ';
                      }

                      echo '</div>';
                    }

                ?>

              </div>

          </div>
        </div>
      </div>
    </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="../../../js/jquery-3.1.0.min.js"></script>
      <script type="text/javascript" src="../../../js/jquery.blockUI.js"></script>
      <script type="text/javascript" src="../../../js/materialize.min.js"></script>
      <script type="text/javascript" src="index.js"></script>
    </body>
  </html>
