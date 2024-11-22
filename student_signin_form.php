			<form id="signin_student" class="form-signin" method="post">
			<h3 class="form-signin-heading"><i class="icon-lock"></i> Sign up as Disciple</h3>
			<input type="text" class="input-block-level" id="username" name="username" placeholder="ID Number" required>
			<input type="text" class="input-block-level" id="firstname" name="firstname" placeholder="Firstname" required>
			<input type="text" class="input-block-level" id="lastname" name="lastname" placeholder="Lastname" required>
			<label>Class</label>
			<select name="class_id" class="input-block-level span5">
				<option></option>
				<?php
				$query = mysqli_query($conn,"select * from class order by class_name ")or die(mysqli_error());
				while($row = mysqli_fetch_array($query)){
				?>
				<option value="<?php  echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
				<?php
				}
				?>
			</select>
			<input type="password" class="input-block-level" id="password" name="password" placeholder="Password" required>
			<input type="password" class="input-block-level" id="cpassword" name="cpassword" placeholder="Re-type Password" required>
			<button id="signin" name="login" class="btn btn-info" type="submit"><i class="icon-check icon-large"></i> Sign in</button>
			</form>
			
		
			
			<script>
    jQuery(document).ready(function () {
        jQuery("#signin_student").submit(function (e) {
            e.preventDefault();

            var password = jQuery('#password').val();
            var cpassword = jQuery('#cpassword').val();

            // Check if passwords match - pinalitan koto
            if (password === cpassword) {
                var formData = jQuery(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "student_signup.php",
                    data: formData,
                    success: function (response) {
                        if (response === 'true') {
                            alert("Sign Up Successful! Welcome to Breakthrough.");
                            setTimeout(function () {
                                window.location = 'dashboard_student.php';
                            }, 2000); // 2-second delay before redirect
                        } else if (response === 'false') {
                            alert("Sign Up Failed! Student not found in the database. Please check your ID number, firstname, lastname, and section.");
                        }
                    },
                    error: function () {
                        alert("An error occurred during the sign-up process. Please try again later.");
                    }
                });
            } else {
                alert("Sign Up Failed! Passwords do not match. Please try again.");
            }
        });
    });
</script>


			
		
			<a onclick="window.location='index.php'" id="btn_login" name="login" class="btn" type="submit"><i class="icon-signin icon-large"></i> Click here to Login</a>
			
			
			
				
		
					