  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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

    
<?php

if (isset($_GET['page']))
{
	$page = $_GET['page'];
}
else
{
	$page =0;
}
$limit = $page*1-1;
/*echo "<script src='SpryAssets/SpryAccordion.js' type='text/javascript'></script>";

	echo '<ul id="improved">';*/
	echo "<table width='100%' class='table' ><form id = 'frmSaveClosingChecklist' method='GET' action='saveclosingsecuritychecklist.php'>";
echo "<tr height='50px'><th align='left' width ='20%'>CATEGORIES</th><th align='left''>QUESTIONS</th><th align='left' width='20%'>ANSWERS</th></tr>";
		$catsql = "SELECT catname FROM questioncat WHERE active = '1'  and listid = '2' ORDER BY id  LIMIT $limit, 1";
$catrs = mysql_query ($catsql,$con);	
$quesno = 0;

					
					while ($catrow = mysql_fetch_row($catrs))
					{//Category
						echo "<tr>"	;
							echo "<td>$catrow[0]</td></td>";
							$cat = $catrow[0];
							echo "</tr>";
						$sql = "SELECT catname, mainquestion,questioncat.id, questionsmain.id  FROM questioncat, questionsmain WHERE questioncat.id = questionsmain.catid and catname = '$catrow[0]' and questionsmain.active = '1'";
						$rs = mysql_query ($sql,$con);						
						while($row = mysql_fetch_row($rs))
						{//Question
							$quesno+=1;	
							echo "<tr>"	;
							echo "<td width = 10>&nbsp;</td><td>	$quesno. $row[1]?</td></td>";
							$question = $row[1];
							$countsubquest2 = "SELECT COUNT(mainid) FROM questionsub where mainid = '$row[3]'";
							
							$rs2 = mysql_query ($countsubquest2,$con);	
							$countsubquest3 = mysql_fetch_row($rs2);
							$countsubquest = $countsubquest3[0];
							if ($countsubquest == 0)
							{
								
								echo "<td><table width='100%'><tr><td width='50%'>YES/NO</td><td width='50%'><select name='txtclosingcheck' id ='txtclosingcheck'><option value='txtunanswered'></option><option value='txtyes'>YES</option><option value='txtno'>NO</option></select></td></tr></table>";
								echo "COMMENT<input name='txtcomment' type='text' maxlength='5000'></td>";
								echo "</tr>";
								
							}
							else if ($countsubquest == 1)
							{
								$subquest = "SELECT questionsub.id, questionsub.mainid,questionsub.subquest FROM questionsub, questionsmain WHERE questionsub.mainid = questionsmain.id and questionsub.mainid = '$row[3]' and questionsub.active = '1'";
								$rs3 = mysql_query ($subquest,$con);
								echo "<td><table width='100%'><tr><td width='50%'>YES/NO</td><td width='50%'> <select name='txtclosingcheck' id ='txtclosingcheck'><option value='txtunanswered'></option><option value='txtyes'>YES</option><option value='txtno'>NO</option></select><td><tr></table>";
								while($rows = mysql_fetch_row($rs3))
								{									
									echo "<table width='100%'><tr><td width='50%'>$rows[2]";
									echo "<td width='50%'><select name='txtclosingcheck' id ='txtclosingcheck'><option value='txtunanswered'></option><option value='txtyes'>YES</option><option value='txtno'>NO</option></select></td></td></tr></table>";									
									echo "COMMENT <input name='txtcomment' type='text' maxlength='5000'></td>";
									echo "</tr>";
								
								}
							}
						
								else if ($countsubquest == 2)
								{
									$subquest = "SELECT questionsub.id, questionsub.mainid,questionsub.subquest FROM questionsub, questionsmain WHERE questionsub.mainid = questionsmain.id and questionsub.mainid = '$row[3]' and questionsub.active = '1'";
									$rs4 = mysql_query ($subquest,$con);
									while($rows = mysql_fetch_row($rs4))
									{
										echo "<td><table width='100%'><tr><td width='50%'>$rows[2]</td><td width = '50%'><select name='txtclosingcheck' id ='txtclosingcheck'><option value='txtunanswered'></option><option value='txtyes'>YES</option><option value='txtno'>NO</option></select></td></tr></table></td></tr>";
										echo "<td>&nbsp;</td><td></td>";	
									}								
										echo "<td>COMMENT <input name='txtcomment' type='text' maxlength='5000'></td>";	
								}
							}
					
							
							/*echo "<td><select name='txtclosingcheck' id ='txtclosingcheck'><option value='txtunanswered'></option><option value='txtyes'>YES</option><option value='txtno'>NO</option></select></td>";
							echo "<td><input name='txtcomment' type='text' maxlength='5000'></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td></td>";
							echo "</tr>";*/
						
						}
						
				
					
		
		
	$rs = mysql_query ($sql, $con);
	$row = mysql_fetch_row($rs);
	
	$lastpage = ceil($row[0]/1);
	$nextpage = $page+1;
	$prevpage = $page-1;
	$firstpage = 1;
	echo "</tr>";
							
	if ($page == $firstpage)
	{
		echo "<tr>";
		echo "<td><a onClick='#' class='button-link'>First</a>";	
		echo "<a onClick='#' class='button-link'>Previous</a>";
		/*echo "<a onClick='getCompany($nextpage);' class='button-link'>Next</a>";	*/
		echo "<a onClick='myFunction();' class='button-link'>Next</a>";	
		echo "<a onClick='getCompany($lastpage);' class='button-link'>Last</a></td>";
		echo "</tr>";		
	}
	else
	{
		if ($page==$lastpage)
		{
			echo "<tr>";
		echo "<td><a onClick='getCompany($firstpage);' class='button-link'>First</a>";	
		echo "<a onClick='getCompany($prevpage);' class='button-link'>Previous</a>";	
		/*echo "<a onClick='#' class='button-link'>Next</a>";	*/
		echo "<a onClick='myFunction();' class='button-link'>Next</a>";	
		echo "<a onClick='#' class='button-link'>Last</a></td>";	
		echo "</tr>";
		}
		else
		{
			echo "<tr>";
			echo "<td><a onClick='getCompany($firstpage);' class='button-link'>First</a>";	
			echo "<a onClick='getCompany($prevpage);' class='button-link'>Previous</a>";
			/*echo "<a onClick='getCompany($nextpage);' class='button-link'>Next</a>";	*/
			echo "<a onClick='myFunction();' class='button-link'>Next</a>";	
			echo "<a onClick='getCompany($lastpage);' class='button-link'>Last</a></td>";	
			echo "</tr>";
	
		}
	}
		echo "</form>";
	echo "<table>";	
?>

<script type="text/javascript">
function myFunction() {
    var x;
    if (confirm("You can only fill in information once, please check if your information is correct, Click 'CANCEL' to recheck or 'OK' to continue") == true) {
        x = function_save();
    } else {
        x = "You pressed Cancel!";
    }
    document.getElementById("demo").innerHTML = x;
}

function function_save()
{
	<?php
	echo "window.open ('savedailysecuritychecklist.php?txtcat=$cat&txtmainques=$question')";
	?>
}
</script>