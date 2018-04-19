<?php session_start();
$thistitle='Job #'.$_GET['jobNo'];
$success='';
if (!isset($_GET['userId'])) { $_GET['userId'] = $_SESSION['userId']; }
?>
<?php include('../pagetop.php');?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include('../loginform.php');?>
<?php } else {


function myTruncate($string, $limit, $break=".", $pad="... <br><b>More details on jobs.firetree.co.za</b>")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}



$result = mysqli_query($conn,"SELECT j.jobstatus, j.jobNo, j.invoiceNo, p.projectId, jobSummary, j.fullDescription, j.deadline, j.estimatedMinutes, j.created, p.projectLead as assignee, j.accountExec, js.statusName, pr.priorityName, c.clientId, c.clientName, c.clientAddress, c.contact1Name, c.taxReference, c.clientFax, c.contact1Mobile, c.contact1Tel, c.clientEmail,p.projectName, concat(u1.firstname,' ',u1.surname) as assignedto, u1.profilePicture as assignedPhoto, u2.profilePicture as aePhoto, concat(u2.firstname,' ',u2.surname) as ae from jobs j
left join users u2 on j.accountExec = u2.userId
left join projects p on j.project = p.projectId
left join clients c on p.client = c.clientId
left join priorities pr on pr.priorityId = j.priority
left join users u1 on p.projectLead = u1.userId
left join jobstatuses js on js.statusId = j.jobstatus
WHERE j.jobNo = '".$_GET['jobNo']."'
ORDER BY j.jobNo ASC");
$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
if ($count > 0) {
$jobNo = $row['jobNo'];
$projectId = $row['projectId'];
$jobSummary = $row['jobSummary'];
$fullDescription = $row['fullDescription'];
$fullDescription = preg_replace("/<img[^>]+\>/i", "(image) ", nl2br($fullDescription));
$fullDescription = preg_replace('#<br[^>]*>(\s*<br[^>]*>)+#', '<br>', $fullDescription);
$fullDescription = strip_tags($fullDescription, '<br>');
$fullDescription = myTruncate($fullDescription, '800');
$deadline = $row['deadline'];
$estimatedMinutes = $row['estimatedMinutes'];
$created = $row['created'];
$assignee = $row['assignee'];
$accountExec = $row['accountExec'];
$statusName = $row['statusName'];
$priorityName = $row['priorityName'];
$clientId = $row['clientId'];
$clientName = $row['clientName'];
$contact1Name = $row['contact1Name'];
$contact1Tel = $row['contact1Tel'];
$contact1Mobile = $row['contact1Mobile'];
$taxReference = $row['taxReference'];
$clientEmail = $row['clientEmail'];
$clientFax = $row['clientFax'];
$clientAddress = $row['clientAddress'];
$projectName = $row['projectName'];
$assignedPhoto = $row['assignedPhoto'];
$assignedto = $row['assignedto'];
$aePhoto = $row['aePhoto'];
$invoiceNo = $row['$invoiceNo'];
$ae = $row['ae'];
$jobstatus = $row['jobstatus'];
} else {
echo '<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">ERROR</h1>
            You have selected an invalid link.
        </div>
        <!-- /.col-lg-12 -->
    </div>';
    exit();
}
?>
    <?php
    $printthis ='';
    $printthis .= '<head><title>'.$thistitle.'</title></head>
    <style>body{ -webkit-print-color-adjust:exact;background:#ffffff !important; }</style>
    <style media="print" type="text/css">
        .page {
            background-color: white !important;
        }
        @media print
        {        
          body{
            -webkit-print-color-adjust:exact;
          }       
          @page port { size: portrait; }
          .portrait { page: port; overflow:none; display:block;
            top: 10px;
            left: 10px;
            position:relative;
          }

          @page land { size: landscape; }
          .landscape { page: land;
            -webkit-transform: rotate(-90deg);
            -moz-transform:rotate(-90deg);
            filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
            top: 186px;
            left:-180px;
            position:absolute;
            min-height:800px;
          }        
          .break { page-break-before: always; }
          .printblack { border: 1px solid 000000; background-color: #000000 !important; color:#ffffff !important; }
          .jobbagfiller { border: 1px solid 000000; background-color: #ffffff !important; color:#000000 !important; }
          .bluefill {
            background-color: #000000!important;
            border:none!important;
          }
          #parent-of-divs { float:none; }
        }
        
    </style>

    <div id="parent-of-divs">
    <div class="portrait break"><table class="job_bag_table">

    <tr border=1 cellspacing=0 cellpadding=0 style="border:1px solid #000;font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#000000;color:#ffffff;"><td colspan="4" class="printblack">The Fire Tree Design Company Job Info</td></tr>


    <tr><td class="borderless" colspan="4">&nbsp;</td></tr>


    <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;width:20%;">Date In</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;width:30%;"><span class="jobbagfiller">'.date("d F Y",strtotime($created)).'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;width:20%;background:#eee" class="printblack">Job No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;width:30%;text-align:center;font-size:140%"><span class="jobbagfiller">'.str_pad($jobNo,6,"0",STR_PAD_LEFT).'</span></td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Client</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$clientName.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Client Order No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Contact </td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$contact1Name.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Final Quote No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Postal Address</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.nl2br($clientAddress).'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee">Studio / Publication Deadline</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee"><span class="jobbagfiller">'.date("d F Y",strtotime($deadline)).'</span></td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Vat No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$taxReference.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee">Delivery Deadline</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Email</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$clientEmail.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Designer(s)</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">';
        $designers = '';
        $assigneesresult = mysqli_query($conn,"select u.userId, u.firstname, u.surname, u.profilePicture, u.email from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$jobNo."'");
        while ($assrow = mysqli_fetch_array($assigneesresult) ) {
            $assfirstname = $assrow['firstname'];
            $asssurname = $assrow['surname'];
            $assprofilePicture = $assrow['profilePicture'];
            $assemail = $assrow['email'];
            $designers.= $assfirstname.' '.$asssurname.' / ';
        }
    $printthis .= rtrim($designers,' / ');
    $printthis .= '</span></td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Cell / Tel</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$contact1Tel.'<br>'.$contact1Name.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">AE</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$ae.'</span></td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Fax No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$clientFax.'</span></td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>



<tr><td  class="borderless" colspan="4">&nbsp;</td></tr>




  <tr border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee">
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;" colspan="4">Campaign: <span class="jobbagfiller">'.$projectName.'</span></td>
  </tr>
  <tr border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;background:#eee">
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;" colspan="4">Job Description: <span class="jobbagfiller">'.nl2br($jobSummary).'</span></td>
  </tr>



    <tr><td class="borderless" colspan="4">&nbsp;</td></tr>



  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Quantity</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Websend / Quickcut</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Open Size</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">No. Of Pages</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Finish Size</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">No.Of Folds</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Bleed Size</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Stock</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Special Finish</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Colour</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Send Artwork To</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Contact At Printer</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Format To Save</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Tel No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Publication</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Stock Image Used</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>


    <tr><td class="borderless" colspan="4">&nbsp;</td></tr>



  <tr>
    <td colspan="4" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;height:200px;vertical-align:top;">Brief: <br/><span class="jobbagfiller">'.$fullDescription.'</span></td>
  </tr>


    <tr><td class="borderless" colspan="4" >&nbsp;</td></tr>





    <tr>
    <td colspan="4" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt; vertical-align:top;height:60px;">Production Info </td>
  </tr>
  <tr>
    <td colspan="1" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Delivery Address</td>
    <td colspan="3" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="1" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Contact Person And Number</td>
    <td colspan="3" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>


    <tr><td class="borderless" colspan="4">&nbsp;</td></tr>




    <tr>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Invoice Number</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">'.$invoiceNo.'</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Fire Tree Order No</td>
    <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
  </tr>
</table></div>';





    
    $printthis2 .= '<div class="landscape"><table class="job_bag_table2">
    <tr>
        <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:2px solid #000;mso-border-alt:solid windowtext .5pt;" colspan="18">DESIGNER: <span class="jobbagfiller">';
        $designers = '';
        $assigneesresult = mysqli_query($conn,"select u.userId, u.firstname, u.surname, u.profilePicture, u.email from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$jobNo."'");
        while ($assrow = mysqli_fetch_array($assigneesresult) ) {
            $assfirstname = $assrow['firstname'];
            $asssurname = $assrow['surname'];
            $assprofilePicture = $assrow['profilePicture'];
            $assemail = $assrow['email'];
            $designers.= $assfirstname.' '.$asssurname.' / ';
        }
        $designers = rtrim($designers,' / ');
        $printthis2 .= $designers.'</span></td>
        <td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:2px solid #000;mso-border-alt:solid windowtext .5pt;" colspan="24"><h2>PROGRESS REPORT SHEET</h2></td>
    </tr>
    <tr><td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;" class="borderless" colspan="42">&nbsp;</td></tr>
    <tr class="smallerheaders allcaps" style="font-weight:bold;font-size:80%;text-align:center;">
        <td rowspan="2"  border=1 cellspacing=0 cellpadding=0 style="text-align:center;font-family:Arial;border-collapse:collapse;mso-border-alt:solid windowtext .5pt;width:5%;
        transform-origin: 110% 65% 0px;
    transform: rotate(270deg);
    moz-transform-origin: 110% 65% 0px;
    moz-transform: rotate(270deg);
    mso-transform-origin: 110% 65% 0px;
    mso-transform: rotate(270deg);
    font-family: Arial;
    border-collapse: collapse;
    border: 1px solid #000;
    white-space: nowrap;
    max-width: 40px;
    font-size: 14px;">Progress Report</td>
        <td colspan="5"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-right:2px solid #fff;border-left:2px solid #000;border-top:2px solid #000;mso-border-alt:solid windowtext .5pt;">Prep Work</td>
        <td colspan="4"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #fff;mso-border-alt:solid windowtext .5pt;">Copy</td>
        <td colspan="5"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #fff;mso-border-alt:solid windowtext .5pt;">Photography</td>
        <td colspan="9"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #fff;mso-border-alt:solid windowtext .5pt;">Design & DTP</td>
        <td colspan="3"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #fff;mso-border-alt:solid windowtext .5pt;">Reversion</td>
        <td colspan="11" class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #fff;mso-border-alt:solid windowtext .5pt;">Finished Art</td>
        <td colspan="1"  class="printblack" border=1 cellspacing=0 cellpadding=0 style="background:#000;color:#fff;text-align:center;font-family:Arial;border-collapse:collapse;border-top:2px solid #000;border-right:2px solid #000;mso-border-alt:solid windowtext .5pt;max-width:30px;white-space:no-wrap;">Web</td>
        <td colspan="1"  rowspan="2"  border=1 cellspacing=0 cellpadding=0 style="text-align:center;font-family:Arial;border-collapse:collapse;border:2px solid #000;mso-border-alt:solid windowtext .5pt;width:100px;font-size:6px;vertical-align:bottom;">Please detail<br>your<br>printouts for<br>each day here,<br>incl size,<br>colour &<br>grammage</td>
        <td colspan="1"  rowspan="2"  border=1 cellspacing=0 cellpadding=0 style="transform-origin: 90% 60% 0px;
    transform: rotate(270deg);
    moz-transform-origin: 90% 60% 0px;
    moz-transform: rotate(270deg);
    mso-transform-origin: 90% 60% 0px;
    mso-transform: rotate(270deg);
    font-family: Arial;
    border-collapse: collapse;
    border: 2px solid #000;
    white-space: nowrap;
    max-width: 40px;
    font-size: 16px;
}">Job Details</td>
        <td colspan="1"  rowspan="2" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">&nbsp;</td>
    </tr>
    <tr class="rotatedtext smallerheaders allcaps" style="font-weight:bold;font-size:62%;" id="rotatedheaders">
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-left: 2px solid #000;">Brief</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Brainstorm / Concept</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Materials Research</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">File Retrieval</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Internet Search</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Retyping Text</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Editing Copy Received</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Copywriting</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Translation</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Photoshoot</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Photos Received</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Stock Photo Search</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Stock Photo Download</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Scan</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Resize Original Artwork</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Design</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">DTP / Layout</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Deep-Etching</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Illustration</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Colour Correction</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Retouch / Photoshop</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Photoshop Layout (Web)</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Photoshop Layout (Print)</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Client\'s Changes</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Proofreading Changes</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Internal Error</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Best Proof</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Email Proof</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Proofreading</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Package Files</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Repro / Finished Art</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Write to Disc</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">FTP Upload</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Heat-Bound Book</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Email Final Artwork</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Inhouse Prints</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-right: 2px solid #000;">Inhouse Mock Up</td>
        <td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt; transform-origin: 140% 68% 0px;">See Details</td>
    </tr>




    <tr style="background:#000;color:#fff;font-weight:bold;font-size:70%;" class="allcaps">
        <td class="printblack" colspan="39" style="padding-left:4px;">Date</td>
        <td class="printblack" colspan="1"  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;">Printouts</td>
        <td class="printblack" colspan="1"  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;border-right: 2px solid #000;mso-border-alt:solid windowtext .5pt;text-align:center;">Time</td>
        <td class="printblack" colspan="1"  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;border-right: 2px solid #000;mso-border-alt:solid windowtext .5pt;text-align:center;">Comments</td>
    </tr>';


$timesheetsResults = mysqli_query($conn,"select t.timelogged, t.timetaskComment, t.timeAdded, tc.taskCategoryId, tc.taskCategoryName, tasks.taskName, u.firstname 
from timesheets t 
left join users u on u.userId = t.timesheetUserId
left join tasks tasks on tasks.taskId = t.timetask
left join taskCategories tc on tasks.taskCategory = tc.taskCategoryId
where t.timesheetJobNo = '".$jobNo."' order by t.timeAdded ASC");
$countTimeSheetResults = mysqli_num_rows ($timesheetsResults);
$totalTimeResults = mysqli_query($conn,"select sum(t.timelogged) as totalTime from timesheets t where t.timesheetJobNo = '".$jobNo."'");
while ($totalTime = mysqli_fetch_array($totalTimeResults) ) {
  $totalTime1 = $totalTime['totalTime'];
}
        while ($trow = mysqli_fetch_array($timesheetsResults) ) {
            $ttimelogged = $trow['timelogged'];
            $ttimetaskComment = $trow['timetaskComment'];
            $ttimeAdded = $trow['timeAdded'];
            $ttaskCategoryName = $trow['taskCategoryName'];
            $ttaskName = $trow['taskName'];
            $tfirstname = $trow['firstname'];


            $printthis2 .= '<tr>';
              $printthis2 .= '<td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;border-left: 2px solid #000;"><span class="jobbagfiller">'.date("d/m",strtotime($ttimeAdded)).'</span></td>';
                $columns = mysqli_query($conn,"select taskCategory, taskCategoryName, taskName from tasks left join taskCategories tc on tc.taskCategoryId = tasks.taskCategory where taskCategory <> 7 order by taskId");
                while ($crow = mysqli_fetch_array($columns) ) {
                    $printthis2 .= '<td ';
                      if ($crow['taskCategoryName'] == $ttaskCategoryName) {
                        if ($crow['taskName'] == $ttaskName) {
                          $printthis2 .= ' class="bluefill" ';
                        }
                      }
                    $printthis2 .= 'border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"></td>';
                }
                if ($ttaskCategoryName == "Web Division") {
                    $printthis2 .= '<td class="bluefill" border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"></td>';
                } else {
                  $printthis2 .= '<td  border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"></td>';
                }
              $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"></td>';
              $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$ttimelogged.'m</span></td>';
              $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="min-width:270px;font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$tfirstname;
              if ($ttimetaskComment <> '') { 
                $printthis2 .= ': ';
              }
              if ($ttaskCategoryName == "Web Division") {
                $printthis2 .=  $ttaskName.'<br>';
              }
              $printthis2 .=  $ttimetaskComment.'</span></td>';
            $printthis2 .= '</tr>';
        }




$times = (11 - $countTimeSheetResults);
for ($i=1;$i < $times; $i++) {
    $printthis2 .= '<tr>';
    for ($j=1;$j<43;$j++) {
        $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">&nbsp;</span></td>';
    }
    $printthis2 .= '</tr>';
}
/********* INITIAL TIME ESTIMATE / DEADLINE *********/
    $printthis2 .= '<tr>';
    for ($j=1;$j<41;$j++) {
      $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller"></span></td>';
    }
    $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">'.$estimatedMinutes.'m</span></td>';
    $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller">Initial Time Estimate<br> Deadline: '.date("d/m",strtotime($deadline)).'</span></td>';
    $printthis2 .= '</tr>';  

/********* ACTUAL TIME SPENT *********/
    $printthis2 .= '<tr>';
    for ($j=1;$j<41;$j++) {
      $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><span class="jobbagfiller"></span></td>';
    }
    $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><strong><span class="jobbagfiller">'.$totalTime1.'m</span></strong></td>';
    $printthis2 .= '<td border=1 cellspacing=0 cellpadding=0 style="font-family:Arial;border-collapse:collapse;border:1px solid #000;mso-border-alt:solid windowtext .5pt;"><strong><span class="jobbagfiller">ACTUAL TIME SPENT</span></strong></td>';
    $printthis2 .= '</tr>';  




    $printthis2 .= '<tr><td colspan="42" style="text-align:center;"><img style="width:1100px" src="image_jb.jpg"></td></tr>';
    $printthis2 .= '</table></div></div>';

?>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".navbar").hide();
            $("footer").hide();
        });
    </script>

    <?php



echo $printthis;
echo $printthis2;

$content = $printthis.$printthis2;
file_put_contents("printed/Job No ".$jobNo.".doc",$content);




require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection(array('marginLeft'=>600, 'marginRight'=>600, 'marginTop'=>600, 'marginBottom'=>600));
$section->addText($printthis);
$section->addPageBreak();

// New landscape section
$section = $PHPWord->createSection(array('orientation'=>'landscape'));
$section->addText($printthis2);



// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Section1.docx');
?>



<script type="text/javascript">//window.location.href='<?php echo "http://jobs.firetree.co.za/jobs/job.php?jobNo=".$_GET['jobNo']."&print=saved";?>'</script>
<?php
}
?>

<?php include('../pagebottom.php');?>


