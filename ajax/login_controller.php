<?php
session_start();

include_once '../controllers/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // validate user credentials
    $user = User::getUserByEmail($email);
    
    if (!$user) {
        $response = array(
            'success' => false,
            'message' => 'Invalid email or password'
        );
        echo json_encode($response);
        exit;
    }
    
    if (!($user['password'] == $_POST['password'])) {
        $response = array(
            'success' => false,
            'message' => 'Invalid email or password'
        );
        echo json_encode($response);
        exit;
    }
    
    // set session variables and redirect user to dashboard/home page
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['name'];
    
    $response = array(
        'success' => true
    );
    echo json_encode($response);
    exit;
} else {
    header('Location: /login');
    exit;
}
