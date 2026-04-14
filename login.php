<?php
session_start();
include 'db.php';
$error = "";

// If user is already logged in, skip the login page and go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify the hashed password against the database
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: index.php"); 
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%); 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #373b8e;
            transform: scale(1.02);
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container px-4">
    <div class="card login-card shadow-lg p-4">
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-block p-3 mb-2 shadow">
                <i class="fas fa-lock fa-2x"></i>
            </div>
            <h3 class="fw-bold text-dark">Portal Login</h3>
            <p class="text-muted small">Enter your staff credentials</p>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger py-2 small text-center shadow-sm">
                <i class="fas fa-exclamation-circle me-1"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control border-start-0 shadow-none" placeholder="Username" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="fas fa-key text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 shadow-none" placeholder="Password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 mb-3 shadow">
                Sign In <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
            
            <div class="text-center mt-2">
                <p class="small text-muted mb-0">New here? <a href="register_user.php" class="text-decoration-none fw-bold">Create an account</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>