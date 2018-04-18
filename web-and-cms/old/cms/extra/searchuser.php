<?php
session_start();
?>
<?php
if (!(isset($_SESSION['rights'])) && (isset($_SESSION['rights']))==0)
{
		echo "<script type = 'text/javascript'>alert(\"You are not allowed to access this page\"); window.location=\"index.php\";</script>";
		session_destroy();			
}
include "connection.php5";
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

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
      <script>
function onchangeajax(pid)
 {
 xmlHttp=GetXmlHttpObject()
 if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
 
 var url="changestate.php"
 url=url+"?pid="+pid
 //alert (url);
 url=url+"&sid="+Math.random()
 document.getElementById("statediv").innerHTML='Please wait...'
 if(xmlHttp.onreadystatechange=stateChanged)
 {
 xmlHttp.open("GET",url,true)
 xmlHttp.send(null)
 return true;
 }
 else
 {
 xmlHttp.open("GET",url,true)
 xmlHttp.send(null)
 return false;
 }
 }
 
 function stateChanged()
 {
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
 document.getElementById("statediv").innerHTML=xmlHttp.responseText
 return true;
 }
 }
 
 function GetXmlHttpObject()
 {
 var objXMLHttp=null
 if (window.XMLHttpRequest)
 {
 objXMLHttp=new XMLHttpRequest()
 }
 else if (window.ActiveXObject)
 {
 objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
 }
 return objXMLHttp;
 }
</script>

<script type='text/javascript'>
function checkform(pagelink,elements,formName) {//this one creates the page link passing all elements
	flag=true;
	for (i=0;i<elements;i++) {
		box = document.forms[formName].elements[i] 
		if (i==0)
		{
			pagelink=pagelink+"?"+box.name+'='+box.value;
		}
		else
		{
			pagelink=pagelink+'&'+box.name+'='+box.value;
		}
				if (!box.value) {
					alert('You haven\'t filled in ' + box.name + '!');
					box.focus();
					flag=false;
				}
	}
	if (flag) 
	{
			 document.getElementById("txtContents").innerHTML='Please wait for information to be added to the database';
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("txtContents").innerHTML=xmlhttp.responseText;
			}
		  }
		  
		xmlhttp.open("GET",pagelink,true);
		xmlhttp.send();
		document.getElementById("txtusername").value="";
		document.getElementById("txtpassword").value="";
		document.getElementById("txtname").value="";
		document.getElementById("txtsurname").value="";

	//	window.location = "index.php"
	}//Flag
}

</script>


<script>
// bring back user info
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>

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
                            <a href="admin.php" class="active"><i class="fa fa-user-plus fa-fw"></i> Add User</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-search fa-fw"></i> Search User<!--<span class="fa arrow"></span>--></a>
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
                            <a href="tables.html"><i class="fa fa-th-list fa-fw"></i> Daily Checklist</a>
                        </li>
                        <li>
                            <a href="forms.php"><i class="fa fa-list-ul fa-fw"></i> Closing Checklists</a>
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
                    <h1 class="page-header">Create New User</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add New User
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                 <form id = "frmAddUser" method='GET' action="createuser.php">
                                        <div class="form-group">
                                            <label>Email Address ( Username )</label>
                                            <input class="form-control" name="txtusername" type="text">
                                          <!--  <p class="help-block">Ensure email is vail</p>-->
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" name="txtpassword" type="text">
                                          <!--  <p class="help-block">Ensure email is vail</p>-->
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select multiple class="form-control" name="txtpassword" type="text">
                                                <?php	
	$user = "select id, rights, rightslevel from rights where active = '1' order by rights asc";
	$rs = mysql_query ($user,$con);
	while($usertype = mysql_fetch_row($rs))
	{
		echo "<option value='$usertype[0]'>$usertype[1]</option>";
	}
	?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="txtname" type="text">
                                          <!--  <p class="help-block">Ensure email is vail</p>-->
                                        </div>
                                        <div class="form-group">
                                            <label>Surname</label>
                                            <input class="form-control" name="txtsurname" type="text">
                                          <!--  <p class="help-block">Ensure email is vail</p>-->
                                        </div>
                                          <div class="form-group">
                                            <label>Type</label>
                                             <?php
    $sql = "select id,type from businesstype where active = '1' order by type asc";
	$rs = mysql_query ($sql,$con);
	?>
                                           
                                            <select name='country' onchange='return onchangeajax(this.value);' class="form-control">
     <?php
	while($bustype = mysql_fetch_row($rs))
	{
		echo "<option value='$bustype[0]'>$bustype[1]</option>";
	}?>
    
                                               
                                            </select>
                                        </div>
                                        <div class="form-group" >
                                        <div id="statediv"><?php include "changestate.php" ?></div>
                                            <label>Store</label>
                                           
                                              
                                           
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Active User?</label>
                                            <select  class="form-control" name="active">
                                                 
                                                <option>Yes</option>
                                                <option>No</option>
      
                                            </select>
                                        </div>
                                        <!--<div class="form-group">
                                            <label>Text Input with Placeholder</label>
                                            <input class="form-control" placeholder="Enter text">
                                        </div>
                                        <div class="form-group">
                                            <label>Static Control</label>
                                            <p class="form-control-static">email@example.com</p>
                                        </div>
                                        <div class="form-group">
                                            <label>File input</label>
                                            <input type="file">
                                        </div>
                                        <div class="form-group">
                                            <label>Text area</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Checkboxes</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="">Checkbox 1
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="">Checkbox 2
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="">Checkbox 3
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Inline Checkboxes</label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox">1
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox">2
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox">3
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Radio Buttons</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Radio 1
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio 2
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">Radio 3
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Inline Radio Buttons</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Selects</label>
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Multiple Selects</label>
                                            <select multiple class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>-->
                                        <button type="submit" class="btn btn-default" onclick='onSubmit=checkform("createuser.php","6","form1");' >Submit</button>
                                        <!--<button type="reset" class="btn btn-default">Reset Button</button>-->
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6"></div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
