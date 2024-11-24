<?php
include('header_dashboard.php');
include('session.php');
?>
<body>
<?php include('navbar_teacher.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <?php include('teacher_notification_sidebar.php'); ?>
        <div class="span9" id="content">
            <div class="row-fluid">
                <!-- breadcrumb -->
                <ul class="breadcrumb">
                    <?php
                    $school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC") or die(mysqli_error($conn));
                    $school_year_query_row = mysqli_fetch_array($school_year_query);

                    // Ensure the row exists before accessing array keys
                    $school_year = $school_year_query_row ? $school_year_query_row['school_year'] : "N/A";
                    ?>
                    <li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
                    <li><a href="#">Batches: <?php echo htmlspecialchars($school_year); ?></a><span class="divider">/</span></li>
                    <li><a href="#"><b>Notification</b></a></li>
                </ul>
                <!-- end breadcrumb -->

                <!-- block -->
                <div id="block_bg" class="block">
                    <div class="navbar navbar-inner block-header">
                        <div id="" class="muted pull-left"></div>
                    </div>
                    <div class="block-content collapse in">
                        <div class="span12">
                            <div class="pull-right">
                                Check All <input type="checkbox" name="selectAll" id="checkAll" />
                                <script>
                                    $("#checkAll").click(function() {
                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                    });
                                </script>
                            </div>

                            <form id="domainTable" action="read_teacher.php" method="post">
                                <?php if (!empty($not_read) && $not_read !== '0') { ?>
                                    <button id="delete" class="btn btn-info" name="read"><i class="icon-check"></i> Read</button>
                                <?php } ?>

                                <?php
                                $query = mysqli_query($conn, "
                                        SELECT * FROM teacher_notification
                                        LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_notification.teacher_class_id
                                        LEFT JOIN student ON student.student_id = teacher_notification.student_id
                                        LEFT JOIN assignment ON assignment.assignment_id = teacher_notification.assignment_id
                                        LEFT JOIN class ON teacher_class.class_id = class.class_id
                                        LEFT JOIN subject ON teacher_class.subject_id = subject.subject_id
                                        WHERE teacher_class.teacher_id = '$session_id'
                                        ORDER BY teacher_notification.date_of_notification DESC
                                    ") or die(mysqli_error($conn));

                                while ($row = mysqli_fetch_array($query)) {
                                    $id = $row['teacher_notification_id'] ?? null;
                                    $assignment_id = $row['assignment_id'] ?? null;
                                    $get_id = $row['teacher_class_id'] ?? null;

                                    $query_yes_read = mysqli_query($conn, "
                                            SELECT * FROM notification_read_teacher 
                                            WHERE notification_id = '$id' AND teacher_id = '$session_id'
                                        ") or die(mysqli_error($conn));

                                    $read_row = mysqli_fetch_array($query_yes_read);
                                    $yes = $read_row['student_read'] ?? null;
                                    ?>

                                    <div class="post" id="del<?php echo htmlspecialchars($id); ?>">
                                        <?php if ($yes !== 'yes') { ?>
                                            <input id="" name="selector[]" type="checkbox" value="<?php echo htmlspecialchars($id); ?>">
                                        <?php } ?>
                                        <strong><?php echo htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></strong>
                                        <?php echo htmlspecialchars($row['notification']); ?> In <b><?php echo htmlspecialchars($row['fname']); ?></b>
                                        <a href="<?php echo htmlspecialchars($row['link']) . '?id=' . htmlspecialchars($get_id) . '&post_id=' . htmlspecialchars($assignment_id); ?>">
                                            <?php echo htmlspecialchars($row['class_name'] . " " . $row['subject_code']); ?>
                                        </a>
                                        <hr>
                                        <div class="pull-right">
                                            <i class="icon-calendar"></i>&nbsp;<?php echo htmlspecialchars($row['date_of_notification']); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /block -->
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>
</body>
</html>
