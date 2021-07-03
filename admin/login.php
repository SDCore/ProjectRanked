<?php
    require_once("../include/nav.php");

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $DBConn = mysqli_connect($host, $user, $pass, $db);
        
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, username, password FROM userAdmin WHERE username = ?";
            
            if($stmt = mysqli_prepare($DBConn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = $username;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["user"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                                
                                // Redirect user to welcome page
                                header("location: index");
                            } else{
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        
        // Close connection
        mysqli_close($DBConn);
    }      
?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="loginContainer">
            <span class="title">Admin Login</span>
            <span class="loginError"><?php if(!empty($login_err)) { echo $login_err; } ?></span>
            <div class="inner">
                <div class="group">
                    <span class="groupTitle">Username</span>
                    <span class="error"><?php echo $username_err; ?></span>
                    <input type="text" name="username" class="input" value="<?php echo $username; ?>" />
                </div>
                <div class="group">
                    <span class="groupTitle">Password</span>
                    <span class="error"><?php echo $password_err; ?></span>
                    <input type="password" name="password" class="input" />
                </div>
                <input type="submit" class="submit" value="Sign In" />
            </div>
        </div>
    </form>

<?php require_once("../include/footer.php"); ?>
