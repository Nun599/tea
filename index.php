<?php
// Determine which form to show initially
$showForm = isset($_GET['form']) && $_GET['form'] === 'register' ? 'register' : 'login';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['first_name'])) {
        // Register form submitted
        require 'db.php';
        
        $first = trim($_POST['first_name']);
        $last  = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $pass  = $_POST['password'];

        // Name validation
        if (!preg_match("/^[A-Z][a-zA-Z]*$/", $first)) {
            echo "<script>alert('First name must start with capital letter and contain only letters.');</script>";
        } else if (!preg_match("/^[A-Z][a-zA-Z]*$/", $last)) {
            echo "<script>alert('Last name must start with capital letter and contain only letters.');</script>";
        } else if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
            echo "<script>alert('Email must be a valid Gmail address (ending with @gmail.com).');</script>";
        } else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/", $pass)) {
            echo "<script>alert('Password must have at least 1 uppercase, 1 lowercase, 1 number, 1 special character and minimum 8 characters.');</script>";
        } else {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("SQL Error: " . $conn->error);
            }
            $stmt->bind_param("ssss", $first, $last, $email, $hashedPass);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Registration Successful!');
                    window.location.href = 'index.php?form=login';
                </script>";
                exit;
            } else {
                if ($conn->errno == 1062) {
                    echo "<script>alert('Email already exists. Please use a different email.');</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        }
    } else {
        // Login form submitted
        require 'db.php';
        session_start();
        
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo "<script>alert('Please fill in all fields.');</script>";
        } else {
            $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = ?");
            if (!$stmt) {
                die("SQL Error: " . $conn->error);
            }
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['logged_in'] = true;
                    
                    echo "<script>
                        alert('Login Successful! Welcome " . addslashes($user['first_name']) . "');
                        window.location.href = 'main.php';
                    </script>";
                    exit;
                } else {
                    echo "<script>alert('Invalid password. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('No account found with this email.');</script>";
            }
            
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Coffee System - Login & Register</title>
    <link rel="stylesheet" href="newreg.css">
</head>
<body>
    <div class="container">
        <!-- Login Form -->
        <form id="loginForm" method="post" 
              class="form-container <?php echo $showForm === 'login' ? 'form-visible' : 'form-hidden'; ?>" 
              onsubmit="return validateLoginForm()">
            <div class="logo">
                <div class="logo-text">☕ 1128</div>
            </div>
            <h2>Tea & Cafe</h2>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
            
            <div class="form-footer">
                <p>Don't have an account? <a class="link" id="showRegister">Register here</a></p>
            </div>
        </form>

        <!-- Register Form -->
        <form id="registerForm" method="post" 
              class="form-container <?php echo $showForm === 'register' ? 'form-visible' : 'form-hidden'; ?>" 
              onsubmit="return validateRegisterForm()">
            <div class="logo">
                <div class="logo-text">☕ 1128</div>
            </div>
            <h2>Create Account</h2>
            
            <div class="input-group">
                <input type="text" name="first_name" placeholder="First Name " required 
                       pattern="[A-Z][a-zA-Z]*" 
                       title="First name must start with capital letter and contain only letters">
            </div>
            
            <div class="input-group">
                <input type="text" name="last_name" placeholder="Last Name " required
                       pattern="[A-Z][a-zA-Z]*"
                       title="Last name must start with capital letter and contain only letters">
            </div>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address  " required
                       pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
                       title="Email must end with @gmail.com">
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password " required
                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$"
                       title="Password must have uppercase, lowercase, number, special character, and be at least 8 characters">
            </div>
            
            <button type="submit" class="btn btn-secondary">Register</button>
            
            <div class="form-footer">
                <p>Already have an account? <a class="link" id="showLogin">Login here</a></p>
            </div>
        </form>
    </div>
    
    <script src="register.js"></script>
</body>
</html>
