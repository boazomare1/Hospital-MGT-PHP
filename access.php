<?php

session_start();

session_destroy();

session_start();

session_regenerate_id();

$sessionid = session_id();

include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$todaydate = date('Y-m-d');

$licenseduser = '175000';

//Variable Declaration

$errmsg = '';

$totalclosingcash = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = isset($_POST["frmflag1"]);

if ($frmflag1 == 'frmflag1')

{

	 $username = $_POST["username"];

	$password = $_POST["password"];

	$docno = $_POST["docno"];

	

	$password1 = base64_encode($password);

	

	

	//$query1 = "select * from master_usercreation where username = '$username' and password = '$password'";

	$query1 = "select * from master_employee where username = '$username' and password = '$password1' and status = 'ACTIVE'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$rowcount1 = mysqli_num_rows($exec1);

	if ($rowcount1 == 0)

	{

		header ("location:access.php?st=1");

	}

	else

	{

	

		

		$res1 = mysqli_fetch_array($exec1);

		$validitydate = $res1['validitydate'];

		$validitydatestr = strtotime($validitydate);

		$todaydatestr = strtotime($todaydate);

		$cashlimit = $res1['cashlimit'];

		if($validitydatestr >= $todaydatestr)

		{

			

		$paynowbillprefix1="logid-";

		$paynowbillprefix1=strlen($paynowbillprefix1);

		$query2 = "select * from details_login  order by auto_number desc limit 0, 1";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$billnumber = $res2["auto_number"];

		$billdigit=strlen($billnumber);

		if ($billnumber == '')

		{

		$billnumbercode ='1';

		$openingbalance = '0.00';

		}

		else

		{

		$billnumber = $res2["auto_number"];

		$billnumbercode = intval($billnumber);

		$billnumbercode = $billnumbercode + 1;	

		$maxanum = $billnumbercode;		

		$billnumbercode = $maxanum;

		}

		

		$_SESSION["username"] = $username;

		$_SESSION["docno"] = $billnumbercode;

		$_SESSION["logintime"] = $updatedatetime;	 

		$_SESSION["timestamp"] = time();

		

		$_SESSION['timeout'] = time();

		$_SESSION["timelimit"] = $cashlimit;

		setcookie('username',$username, time() + (86400 * 1));

		setcookie('logintime',$updatedatetime, time() + (86400 * 1));

		setcookie('logout','login', time() + (86400 * 1));

		

		//echo $companycode;

		

		$query2 = "insert into details_login (docno,username, logintime, openingcash, 

		lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 

		value ('$billnumbercode','$username', '$updatedatetime', '$totalclosingcash', 

		'$updatedatetime', '$ipaddress', '$username', '$sessionid')";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query4 = "delete from login_restriction where username = '$username'";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query3 = "insert into login_restriction (username, logintime, 

		lastupdate, lastupdateipaddress, lastupdateusername, sessionid,locationname,locationcode) 

		value ('$username', '$updatedatetime', 

		'$updatedatetime', '$ipaddress', '$username', '$sessionid', '$locationname', '$locationcode')";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query1 = "select count(auto_number) as countanum from login_restriction";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$logincount = $res1["countanum"];

		

		$query2 = "select * from master_edition where status = 'ACTIVE'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$res2usercount = $res2["users"];

		

		if ($logincount > $res2usercount)

		{

			//echo 'inside if';

			header ("location:login1restricted1.php");

			exit;

		}

		

		$query53 = "select * from master_employee where username = '$username' and status = 'Active'";

		$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res53 = mysqli_fetch_array($exec53);

		$shiftaccess = $res53["shift"];

		if($shiftaccess =="YES")

		{

			$query52 = "select * from shift_tracking where username = '$username' order by auto_number desc";

			$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res52 = mysqli_fetch_array($exec52);	

			$shiftouttime = $res52["shiftouttime"];		

			if($shiftouttime != '0000-00-00 00:00:00')

			{

				$query51 = "insert into shift_tracking(username,shiftstarttime,lastupdate,lastupdateipaddress,lastupdateusername,locationname,locationcode)values('$username','$updatedatetime','$updatedatetime','$ipaddress','$username', '$locationname', '$locationcode')";

				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

			}

		}

		

		//header("location:mainmenu1.php?st=1");

		

		header ("location:setactivecompany1.php");

		}

		else

		{

		header ("location:access.php?st=2");

		}

	}



}





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = isset($_REQUEST["st"]);

if ($st == 1)

{

	$errmsg = "Login Failed. Please Try Again With Proper User Id and Password.";

}

if ($st == 2)

{

	$errmsg = "Login Failed. Validity date is Expired.";

}

$queryactiveusers = "select * from details_login where logouttime = '0000-00-00 00:00:00' order by auto_number desc";

$execactiveusers = mysqli_query($GLOBALS["___mysqli_ston"], $queryactiveusers) or die ("Error in queryactiveusers".mysqli_error($GLOBALS["___mysqli_ston"]));

$numsactiveusers = mysqli_num_rows($execactiveusers);

$remainusers = $licenseduser - $numsactiveusers;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStar Hospital Management - Secure Access</title>
    <link rel="icon" type="image/x-icon" href="logofiles/ico.jpg">
    <link rel="stylesheet" href="css/medstar-access.css?v=1.1">















</head>

<body>
    <div class="medstar-background">
        <div class="medical-elements">
            <div class="medical-icon">🏥</div>
            <div class="medical-icon">⚕️</div>
            <div class="medical-icon">💊</div>
            <div class="medical-icon">🩺</div>
            <div class="medical-icon">🚑</div>
            <div class="medical-icon">🔬</div>
            <div class="medical-icon">🧬</div>
            <div class="medical-icon">📋</div>
            <div class="medical-icon">💉</div>
            <div class="medical-icon">🩻</div>
            <div class="medical-icon">🧪</div>
            <div class="medical-icon">📊</div>
        </div>
    </div>

    <div class="login-wrapper">
        <!-- Left Panel - Branding & Doctor Image -->
        <div class="left-panel">
            <div class="doctor-image">
                <div class="doctor-placeholder">👨‍⚕️</div>
            </div>
            <div class="branding-section">
                <div class="brand-logo">⭐</div>
                <h1 class="brand-title">MedStar</h1>
                <p class="brand-subtitle">Hospital Management System</p>
                <div class="brand-description">
                    <p>Cloud Based Streamline Hospital Management system with centralized user friendly platform</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="right-panel">
            <div class="form-header">
                <div class="form-logo">⭐</div>
                <h2 class="form-title">Login</h2>
                <p class="form-subtitle">Enter your credentials to login to your account</p>
            </div>

            <div class="form-container">
                <?php if ($errmsg != ''): ?>
                <div class="error-container">
                    <div class="error-icon">⚠️</div>
                    <div class="error-text"><?php echo $errmsg; ?></div>
                </div>
                <?php endif; ?>

                <form id="form1" name="form1" method="post" action="access.php" onSubmit="return process1login1()">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="username" placeholder="Enter your username" required />
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required />
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                                <span class="toggle-icon">👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <input type="hidden" name="licenseduser" value="<?php echo $licenseduser; ?>" />
                    <input type="hidden" name="remainusers" value="<?php echo $remainusers; ?>" />
                    <input type="hidden" name="docno" id="docno" />
                    <input type="hidden" name="frmflag1" value="frmflag1" />

                    <button type="submit" class="access-btn" id="accessBtn">
                        <span class="btn-text">Sign In</span>
                    </button>
                </form>

                <div class="signup-section">
                    <p>Don't have an account? <a href="#" class="signup-link">Sign Up</a></p>
                </div>

                <div class="footer-stats">
                    <div class="stat-item">
                        <div class="stat-icon">🔑</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $remainusers; ?></div>
                            <div class="stat-label">Available Licenses</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">👥</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $numsactiveusers; ?></div>
                            <div class="stat-label">Active Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function process1login1() {
            const username = document.form1.username.value.trim();
            const password = document.form1.password.value.trim();
            const remainusers = document.form1.remainusers.value;

            if (username === "") {
                showNotification("Please enter your username", "error");
                document.form1.username.focus();
                return false;
            } else if (password === "") {
                showNotification("Please enter your password", "error");
                document.form1.password.focus();
                return false;
            }
            
            if (remainusers === "0") {
                showNotification("LICENSE USERS ARE COMPLETE", "error");
                return false;
            }

            // Show loading state
            const btn = document.getElementById('accessBtn');
            const btnText = btn.querySelector('.btn-text');
            btn.classList.add('loading');
            btnText.textContent = 'Authenticating...';
            btn.disabled = true;

            return true;
        }

        function setFocus() {
            document.getElementById("username").focus();
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? '#ff6b6b' : '#87CEEB'};
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                z-index: 1000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                max-width: 300px;
                font-size: 14px;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 4 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 4000);
        }

        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.access-container');
            const inputs = document.querySelectorAll('.input-group input');
            
            // Initial animation
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px) scale(0.95)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0) scale(1)';
            }, 100);

            // Input focus effects
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Form submission enhancement
            const form = document.getElementById('form1');
            form.addEventListener('submit', function(e) {
                if (!process1login1()) {
                    e.preventDefault();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                    const nextInput = e.target.parentElement.nextElementSibling?.querySelector('input');
                    if (nextInput) {
                        nextInput.focus();
                        e.preventDefault();
                    }
                }
            });
        });

        // Password visibility toggle
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');
        const toggleIcon = passwordToggle.querySelector('.toggle-icon');
        
        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
                passwordToggle.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
                passwordToggle.setAttribute('aria-label', 'Show password');
            }
        });

        // Set focus when page loads
        window.onload = setFocus;
    </script>
</body>
</html>



