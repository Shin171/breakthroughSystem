<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<body>
<?php include('navbar_teacher.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <?php include('subject_overview_link.php'); ?>
        <div class="span9" id="content">
            <div class="row-fluid">
                <!-- Breadcrumb -->
                <?php
                $class_query = mysqli_query($conn, "
                        SELECT * FROM teacher_class
                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE teacher_class_id = '$get_id'
                    ") or die(mysqli_error($conn));

                if (mysqli_num_rows($class_query) > 0) {
                    $class_row = mysqli_fetch_array($class_query);
                    $class_name = $class_row['class_name'];
                    $subject_code = $class_row['subject_code'];
                } else {
                    $class_name = "Unknown Class";
                    $subject_code = "Unknown Subject";
                }
                ?>
                <ul class="breadcrumb">
                    <li><a href="#"><?php echo $class_name; ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><?php echo $subject_code; ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><b>Lesson Overview</b></a></li>
                </ul>
                <!-- End Breadcrumb -->

                <!-- Block -->
                <div id="block_bg" class="block">
                    <div class="navbar navbar-inner block-header">
                        <div id="" class="muted pull-right">
                            <?php
                            $query = mysqli_query($conn, "
                                    SELECT * FROM teacher_class
                                    LEFT JOIN class_subject_overview ON class_subject_overview.teacher_class_id = teacher_class.teacher_class_id
                                    WHERE class_subject_overview.teacher_class_id = '$get_id'
                                ") or die(mysqli_error($conn));

                            if (mysqli_num_rows($query) > 0) {
                                $row = mysqli_fetch_array($query);
                                $id = $row['class_subject_overview_id'];
                                $content = $row['content'];
                                ?>
                                <a href="edit_subject_overview.php<?php echo '?id=' . $get_id; ?>&<?php echo 'subject_id=' . $id; ?>" class="btn btn-info">
                                    <i class="icon-pencil"></i> Edit Subject Overview
                                </a>
                            <?php } else {
                                $content = "No overview available.";
                                ?>
                                <a href="add_subject_overview.php<?php echo '?id=' . $get_id; ?>" class="btn btn-success">
                                    <i class="icon-plus-sign"></i> Add Subject Overview
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="block-content collapse in">
                        <div class="span12">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
                <!-- /Block -->
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>
</body>
</html>
