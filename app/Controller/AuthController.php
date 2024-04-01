<?php

class AuthController
{
    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->userModel = new UserModel($connection);
    }

    /**
     * @return void
     */
    public function loginUser()
    {
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->loginUser($username, $password);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: /movies_list');
                exit();
            } else {
                $error_message = "Wrong username or password!";
                include('View/auth/login_form.php');
            }
        } else {
            include('View/auth/login_form.php');
        }
    }

    /**
     * @return void
     */
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $result = $this->userModel->registerUser($username, $password);
                if ($result) {
                    header('Location: /login');
                    exit();
                } else {
                    echo "Registration Error!";
                }
            } catch (PDOException $exception) {
                echo "Registration Error: " . $exception->getMessage();
            }
        } else {
            include('View/auth/registration_form.php');
        }
    }

}


