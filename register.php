<?php
session_start();

require('config/config.php');
require('config/db.php');
 

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Käyttäjänimi on pakollinen";
    } else{
        
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
           
            $param_username = trim($_POST["username"]);
            
            
            if(mysqli_stmt_execute($stmt)){
               
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Käyttäjä nimi on käytössä";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Sähköposti on pakollinen";
    }else{
        $email = trim($_POST["email"]);
    }

    

    if(empty(trim($_POST["password"]))){
        $password_err = "Salasana on pakollinen";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Salasanassa pitää olla 6 kirjainta";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Salasana uudelleen";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Salasanat eivät täsmää";
        }
    }
    
    
   
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            
            
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            
           
            if(mysqli_stmt_execute($stmt)){
               
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

             Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
   
    mysqli_close($conn);
}
?>
 
<?php include 'inc/header.php'; ?>

<body>
    <div class="container">
        <h2>Rekisteröityminen</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Käyttäjänimi</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="error"><?php echo $username_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Sähköposti</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana uudelleen</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Rekisteröidy">
            </div>
            <a href="login.php">Kirjaudu sisään</a></p>
        </form>
    </div>    

<?php include 'inc/footer.php'; ?>