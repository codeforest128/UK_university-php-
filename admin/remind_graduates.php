<?php
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
?>
<!DOCTYPE html>
<head></head>
<body>
<?php
    /*
    $counter = 0;
    if (Login::isAdminLoggedIn()) {
        $sql = "SELECT p.firstname AS `name`, p.course_end AS cend, alte.email AS altemail, u.email "
             . "FROM users u "
             . "left outer JOIN posts p "
             . "ON u.id = p.user_id "
             . "left outer JOIN altemail alte "
             . "ON p.user_id = alte.student_id";
        $result = DB::query($sql, array());
        foreach ($result as $res) {
            if (sizeof($res["altemail"]) == 0 && $res["cend"] == 2019) { 
                $email_body = "
<style>
body {
    font-family: Montserrat,sans-serif;
}
</style>
<div>
	<div style=\"height: 3em; background: #00003C; text-align: center;\">
		<img data-imagetype=\"external\" src=\"https://www.oxbridgecareershub.co.uk/logo.png\" style=\"display: inline-block; height: inherit;\">
	</div>
	<div style=\"margin: 20px;\">
		<p>Hi " . $res["name"] . ",</p>
		<p>This is a reminder to provide an alternative email address and remain affiliated with Oxbridge Careers Hub.</p>
		<p>With over a dozen FTSE 100 companies using OCH from next Monday, we wouldn't want you to miss out on job opportunities that will begin to reach you in the next month.</p>
		<p>Whether you've already found a graduate placement or if you're still searching, our service allows you to be discovered by top employers.</p>
		<p>To stay with us, we need you to provide us with an alternative email address, as your university one will be expiring. Please follow the link <a href=\"https://www.oxbridgecareershub.co.uk/account.php\">here</a> (it will be quick, we promise!).</p>
		<p><strong>The OCH team</strong></p>
	</div>
	<hr/>
	<div style=\"text-align: center\">
		<p style=\"font-size: 0.8em\">&copy; 2019 Oxbridge Careers Hub</p>
	</div>
</div>";
                $from = "OCH Team <noreply@oxbridgecareershub.co.uk>";
                $to = $res["email"];
                $subject = "Stay In Touch";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From:" . $from . "\r\n";
                mail($to, $subject, $email_body, $headers);
                $counter = $counter + 1;
                echo $counter . " - Successfully emailed: " . $to . "<br/>";
            }
        }
    }
    */
?>
</body>