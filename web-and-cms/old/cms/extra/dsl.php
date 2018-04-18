<?php
session_start();
?>
<?php
if (!(isset($_SESSION['rights'])))
{
		echo "<script type = 'text/javascript'>alert(\"You are not allowed to access this page\"); window.location=\"index.php\";</script>";
		session_destroy();			
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>REAS - REHO SECURITY</title>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	 
 <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../dist/css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    

</head>

<body>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Reho Security</a>
            </div>
            <!-- /.navbar-header -->

            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li >
                            <a href="admin.php" ><i class="fa fa-user-plus fa-fw"></i> Add User</a>
                        </li>
                        <li>
                            <a href="searchuser.php"><i class="fa fa-search fa-fw"></i> Search User<!--<span class="fa arrow"></span>--></a>
                            <!--<ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.php">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.php">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="daily-security-list.php" class="active"><i class="fa fa-th-list fa-fw"></i> Daily Checklist</a>
                        </li>
                        <li>
                            <a href="t2.php"><i class="fa fa-list-ul fa-fw"></i> Closing Checklists</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Weekly Supervisor Security Checklist<!--<span class="fa arrow"></span>--></a>
                           <!-- <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.php">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.php">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.php">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.php">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.php"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.php">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-list-alt fa-fw"></i>Monthly Admin Security Audit<!--<span class="fa arrow"></span>--></a>
                            <!--<ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                               <!-- </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    <!-- <li class="active">-->
                           <li> <a href="#"><i class="fa fa-flag fa-fw"></i> Incident Report <!--<span class="fa arrow"></span>--></a>
                          <!--  <ul class="nav nav-second-level">
                                <li>
                                    <a class="active" href="blank.php">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.php">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li> <a href="#"><i class="fa fa-comments fa-fw"></i> Daily Report </a> </li>
                        <li> <a href="#"><i class="fa fa-user-secret fa-fw"></i> Theft Register </a> </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Daily Checklist</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                        <div class="panel-heading">
                            Complete Daily Security Checklist
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                
                        
                             <form name="dsl" role="dsl" id="dsl">
                             <table class="table table-bordered table-hover">
                             <thead>
                             <th> Categories </th>
                             <th> Questions </th>
                             <th> Answers </th>
                             <th> Comment </th>
                             <th> Image </th>
                             </thead>
                             
                             <tbody>
                             <tr  class="danger"><td>Staff Entrance</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Staff Entrance Door?</td>
                             <td><div class="form-group">						
                             <select id="dslsed" name="dsled" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dsledcomm" id="dsledcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsledfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Staff Entrance Gates?</td>
                             <td><div class="form-group">           
                             <select id="dslseg" name="dsleg" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslegcomm" id="dslegcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslegfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Gate Locks?</td>
                             <td><div class="form-group">           
                             <select id="dslsegl" name="dslegl" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslegcomm" id="dslegcomml" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsleglfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>

                              <tr  class="danger"><td>Security Staff Entrance</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Occurence Book?</td>
                             <td><div class="form-group">           
                             <select id="dslob" name="dslob" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslobcomm" id="dsledcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslobfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Merchandiser Control Forms?</td>
                             <td><div class="form-group">           
                             <select id="dslsmcf" name="dslmcf" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslmcfcomm" id="dslegcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslmcffileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Radio Register?</td>
                             <td><div class="form-group">           
                             <select id="dslsrr" name="dslrr" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslrrcomm" id="dslrrcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslrrfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr>
                             <td></td>
                             <td>Visitors Cards?</td>
                             <td><div class="form-group">           
                             <select id="dslvc" name="dslvc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslvccomm" id="dslvccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslvcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                               <tr  class="danger"><td>Search Bay</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Cubicles have Curtains?</td>
                             <td><div class="form-group">           
                             <select id="dslcc" name="dslcc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcccomm" id="dslcccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslccfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Seperate Male and<br/> Female Cubicles?</td>
                             <td><div class="form-group">           
                             <select id="dslsmfc" name="dslsmfc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslsmfccomm" id="dslsmfccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslsmfcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Baskets for Personals present?</td>
                             <td><div class="form-group">           
                             <select id="dslbpp" name="dslbpp" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslbppcomm" id="dslbppcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslbppfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr>
                             <td></td>
                             <td>Correct Search Procedures?</td>
                             <td><div class="form-group">           
                             <select id="dslcsp" name="dslcsp" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcspcomm" id="dslcspcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcspfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr>
                             <td></td>
                             <td>Security Stickers?</td>
                             <td><div class="form-group">           
                             <select id="dslss" name="dslss" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslsscomm" id="dslsscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslssfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                               <tr>
                             <td></td>
                             <td>Security Tape?</td>
                             <td><div class="form-group">           
                             <select id="dslst" name="dslst" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslstcomm" id="dslstcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslstfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>

                              <tr  class="danger"><td>Staff Parcel Counter</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>All Parcels Checked<br /> with till slips?</td>
                             <td><div class="form-group">           
                             <select id="dslspcc" name="dslspcc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslspcccomm" id="dslspcccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslspccfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>All Parcels Sealed?</td>
                             <td><div class="form-group">           
                             <select id="dslspcs" name="dslspcs" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslspcscomm" id="dslspcscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslsmfcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Parcel Cubicles Marked?</td>
                             <td><div class="form-group">           
                             <select id="dslspccm" name="dslspccm" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslspccmcomm" id="dslspccmcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslspccmfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr>
                             <td></td>
                             <td>Control Form for <br/> Staff Parcels?</td>
                             <td><div class="form-group">           
                             <select id="dslspccfsp" name="dslspccfsp" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslspccfspcomm" id="dslspccfspcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslspccfspfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>

                              <tr  class="danger"><td>Stock Room Checks</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Non Foods Checked</td>
                             <td><div class="form-group">           
                             <select id="dslnfc" name="dslnfc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslnfccomm" id="dslnfccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslnfcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Groceries Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslgc" name="dslgc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslgccomm" id="dslgccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslgcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Toiletries Checked?</td>
                             <td><div class="form-group">           
                             <select id="dsltc" name="dsltc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dsltccomm" id="dsltccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsltcfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr>
                             <td></td>
                             <td>Chocolates <br/> and sweets?</td>
                             <td><div class="form-group">           
                             <select id="dslcs" name="dslcs" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcscomm" id="dslcscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcsspfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr>
                             <td></td>
                             <td>Wine Locker?</td>
                             <td><div class="form-group">           
                             <select id="dslwl" name="dslwl" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslwlcomm" id="dslwlcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslwlfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr>
                             <td></td>
                             <td>Cold Drinks?</td>
                             <td><div class="form-group">           
                             <select id="dslcd" name="dslcd" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcdcomm" id="dslcdcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcdfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>

                               <tr  class="danger"><td>Receiving</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Receiving Cages<br /> Double Lock System?</td>
                             <td><div class="form-group">           
                             <select id="dslrcs" name="dslrcs" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslrcscomm" id="dslrcscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslrcsfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Roller Shutter <br/> Doors Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslrsdc" name="dslrsdc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="rsdccomm" id="rsdccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="rsdcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Area Clean <br /> and Tidy?</td>
                             <td><div class="form-group">           
                             <select id="dslact" name="dslact" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslactcomm" id="dslactcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslactfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>


                             <tr  class="danger"><td>Departments</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Butchery Checked?</td>
                             <td><div class="form-group">           
                             <select id="dsldbc" name="dsldbc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dsldbccomm" id="dsldbccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsldbcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Bakery Checked?</td>
                             <td><div class="form-group">           
                             <select id="dsldbac" name="dsldbac" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dsldbaccomm" id="dsldbaccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsldbacfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Deli Checked?</td>
                             <td><div class="form-group">           
                             <select id="dsldc" name="dsldc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dsldccomm" id="dsldccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dsldcfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr>
                             <td></td>
                             <td>Cut Fruit Dpt. Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslcfdc" name="dslcfdc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcfdccomm" id="dslcfdccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcfdcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr>
                             <td></td>
                             <td>Kitchens Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslkc" name="dslkc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslkccomm" id="dslkccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslkcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              

                                 <tr  class="danger"><td>Fridges and<br /> Cold Rooms</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Perishables Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslpc" name="dslpc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslpccomm" id="dslpccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslpcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Fruit & Veg Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslfvc" name="dslfvc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslfvccomm" id="dslfvccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslfvcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Freezers Checked?</td>
                             <td><div class="form-group">           
                             <select id="dslfc" name="dslfc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslfccomm" id="dslfccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslfcfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             
                             
                             
                             <tr  class="danger"><td>Compactor Area</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>All Boxes Collapsed?</td>
                             <td><div class="form-group">           
                             <select id="dslabc" name="dslabc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslabccomm" id="dslabccomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslabcfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>All Cardboard / <br /> Plastic / <br /> Paper Seperated?</td>
                             <td><div class="form-group">           
                             <select id="dslacpps" name="dslfvc" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslacppscomm" id="dslacppscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslacppsfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Area Clean and Tidy?</td>
                             <td><div class="form-group">           
                             <select id="dslcaact" name="dslcaact" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcaact" id="dslcaact" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcaactfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr> 
                              
                              
                              <tr  class="danger"><td>Main Entrance</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Manned at all times?</td>
                             <td><div class="form-group">           
                             <select id="dslmaat" name="dslmaat" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslmaatcomm" id="dslmaatcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslmaatfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>All Incoming Parcels <br/> Sealed</td>
                             <td><div class="form-group">           
                             <select id="dslaips" name="dslaips" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslaipscomm" id="dslaipscomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslaipsfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Customer Parcel counter <br /> in use?</td>
                             <td><div class="form-group">           
                             <select id="dslcpciu" name="dslcpciu" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslcpciu" id="dslcpciu" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslcpciufileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr >
                              <td></td>
                             <td>Security Stickers?</td>
                             <td><div class="form-group">           
                             <select id="dslmess" name="dslmess" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslmess" id="dslmess" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslmessfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>
                             <tr >
                              <td></td>
                             <td>Security Tape?</td>
                             <td><div class="form-group">           
                             <select id="dslmest" name="dslmest" required>
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslmest" id="dslmest" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslmestfileupload" type="file" name="files[]" multiple>
                             </td>
                             </tr>

                              <tr  class="danger"><td>House & Home Entrance <br /> (where applicable)</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td>Guard Present?</td>
                             <td><div class="form-group">           
                             <select id="dslgp" name="dslgp" >
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslgpcomm" id="dslgpcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslgpfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             <td>Security Tape?</td>
                             <td><div class="form-group">           
                             <select id="dslhhst" name="dslhhst" >
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslhhstcomm" id="dslhhstcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslhhstfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>

                              <tr  class="danger"><td>WEEKLY PANIC BUTTON TEST DONE</td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             
                              </tr>
                              <tr >
                              <td></td>
                             <td></td>
                             <td><div class="form-group">           
                             <select id="dslwpbtd" name="dslwpbtd" required >
                             <option> Yes </option>
                             <option> No </option>
                             </select>
                             </div>
                             </td>
                             <td><div class="form-group">
                             <input type="text" name="dslwpbtdcomm" id="dslwpbtdcomm" placeholder="comment">
                             </div>
                             </td>
                             <td>
                             <input id="dslgpfileupload" type="file" name="files[]" multiple>
                             </td>
                              </tr>
                              <tr >
                              <td></td>
                             
                             
                             </tbody>
                             
                             </table>
                             </form>
                               
                                <!-- /.col-lg-6 (nested) -->
                                
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                         
                         </div>   <!-- /.row (nested) -->
                        
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
