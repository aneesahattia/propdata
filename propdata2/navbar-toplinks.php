<?php if (isset($_SESSION['userId'])) { ?>

<ul class="nav navbar-top-links navbar-right">
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-comments fa-fw"></i>  <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-messages">
        <li>
            <a class="text-center" href="#">
                <strong>All Unread Comments</strong>
            </a>
        </li>
        <li class="divider"></li>
<?php
        function truncate_words($text, $limit, $ellipsis = '...') {
        $words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_OFFSET_CAPTURE);
        if (count($words) > $limit) {
        end($words); //ignore last element since it contains the rest of the string
        $last_word = prev($words);

        $text =  substr($text, 0, $last_word[1] + strlen($last_word[0])) . $ellipsis;
        }
        return $text;
        }
?>
    <?php

    if (isset($_GET['jobNo']) && isset($_SESSION['userId'])) {
        mysqli_query($conn,"UPDATE commentsread set crstatus='1' where cruserId ='".$_SESSION['userId']."' and crJobNo='".$_GET['jobNo']."'"
        );
    }

        $commentsresult = mysqli_query($conn,"SELECT cr.crId, c.commentId, c.commenter, c.comment, c.commentJobNo, c.commentDate, CONCAT(u.firstname, ' ',u.surname) AS commenterName FROM comments c LEFT JOIN users u ON u.userId = c.commenter LEFT JOIN commentsread cr ON cr.crId = c.commentId WHERE cr.crstatus='0' AND cr.cruserId = '".$_SESSION['userId']."'");
    if (mysqli_num_rows($commentsresult) > 0) {
        while ($crow = mysqli_fetch_array($commentsresult) ) {
            echo '<li>
                    <a href="'.HTTP.'jobs/job.php?jobNo='.$crow['commentJobNo'].'">
                        <div>
                            <strong>'.$crow['commenterName'].'</strong>
                                            <span class="pull-right text-muted">
                                                <em>'.date("d F y, H:i",strtotime($crow['commentDate'])).'</em>
                                            </span>
                        </div>
                        <div>'.strip_tags(truncate_words($crow['comment'], "7", $ellipsis = '...'),'<br>').'</div>
                    </a>
                </li>
                <li class="divider"></li>';
        }
    } else {
        echo '<li style="padding-left: 10px;">
                    There are no unread comments.
                </li>
                <li class="divider"></li>';
    }
    ?>

    </ul>
    <!-- /.dropdown-messages -->
</li>
<!-- /.dropdown -->

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="<?php echo HTTP.'users/user.php'; ?>"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['firstname'].' '.$_SESSION['surname'];?></a>
        </li>
        <!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
        </li>-->
        <li class="divider"></li>
        <li><a href="<?php echo HTTP.'logout.php';?>"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
        </li>
    </ul>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->
<?php } ?>