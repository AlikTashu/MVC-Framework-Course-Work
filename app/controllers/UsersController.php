<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 03.06.2018
 * Time: 19:41
 */

namespace app\controllers;


use app\models\User;
use vendor\core\exception\BadUrlException;
use vendor\core\utility\Logger;
use vendor\core\utility\Mail;
use vendor\core\utility\ReCaptcha;
use vendor\core\utility\ReCaptchaResponse;

#require ROOT."/vendor/core/utility/recaptchalib.php";

class UsersController extends AppController
{


    public function registrationAction()
    {
        $data = $_POST;
        $captchaConfig = require ROOT . '/config/captcha_config.php';
        $message = "";
        if (isset($data["reg_login"]) || isset($data["reg_password"]) || isset($data["reg_email"])) {
            Logger::message("in register action with form");
            $errors = $this->validateRegistrationForm($data);
            if (is_array($errors) && count($errors) == 0) {
                $hashedPassword = password_hash($data["reg_password"], PASSWORD_DEFAULT);

                $user = new User([
                    "login" => $data["reg_login"],
                    "email" => $data["reg_email"],
                    "password" => $hashedPassword,
                    "role_id" => "1",
                    "hashcode" => md5($hashedPassword),
                    "mail_verified" => "0"
                ], true);
                $user->save();
                Mail::verifyEmail($user);
                $message = "Check you email!";
            }
            else{
                $message = array_pop($errors);
            }
        }
        $this->set(["message" => $message, "data" => $data, "cfg" => $captchaConfig]);
    }

    public function loginAction()
    {
        $data = $_POST;
        $errors = [];
        $message = "";
        if (isset($data["log_btn"])) {
            $dataset = SQL("SELECT * FROM users WHERE login = ?", [$data["log_login"]]);
            if (count($dataset) == 0) {
                array_push($errors, "User with such login doesn't exist");
            } else if (!password_verify($data["log_password"], $dataset[0]["password"])) {
                array_push($errors, "Password isn't correct");
            }

            if (count($errors) == 0) {
                $_SESSION['user'] = $dataset[0];
                header('Location:' . '/main');
                }
            else{
                $message = array_pop($errors);
            }
            $this->set(["message"=>$message]);

        }

    }

    public function logoutAction()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        session_destroy();
        header("Location: /main");
    }

    public function restoreAction()
    {
        $data = $_POST;
        $message = "";

        if (isset($data["res_btn"])) {
            if (!isset($data["res_email"])) {
                $message = "Enter your email!";
            } else {
                $user = User::where("email", "=", $data["res_email"])->first();
                if ($user == null) {
                    return;
                }
                Mail::rememberPassword($data["res_email"], $user->hashcode);
                $message = "Check your email!";
            }
        }
        $this->set(["message" => $message, "email" => $data["res_email"]]);
    }

    public function passwordAction()
    {
        $data = $_POST;
        $errors = [];
        $message = "";
        if (isset($data["res_btn"])) {
            $this->updatePassword($data, $errors);
        } else if (isset($this->_MVCParams[0])) {
            $userHash = $this->_MVCParams[0];
            $user = User::where("hashcode", "=", $userHash)->first();
            if ($user == null) {
                return;
            }
            $this->set(["id" => $user->id]);
        }
        else{
            throw new BadUrlException();
        }
    }

    public function verifyAction()
    {
        $message = "Something went wrong";
        if (isset($this->_MVCParams[0])) {
            $userHash = $this->_MVCParams[0];
            $user = User::where("hashcode", "=", $userHash)->first();

            $user->mail_verified = 1;
            $user->save();
            $message = "Your mail is verified, {$user->login}";
        }
        $this->set(["message" => $message]);
    }


    /**
     * @param $data
     * @param $errors
     */
    protected function updatePassword($data, $errors): void
    {
        if (trim($data["res_password"]) == "") {
            array_push($errors, "Login can't be empty");
        }
        if (trim($data["res_password_rep"]) == "") {
            array_push($errors, "Email can't be empty");
        }
        if ($data["res_password"] != $data["res_password_rep"]) {
            array_push($errors, "Passwords fo not match");
        }

        if (is_array($errors) && count($errors) == 0) {
            $hashedPassword = password_hash($data["reg_password"], PASSWORD_DEFAULT);
            $updUser = User::where("id", "=", $data["res_id"])->first();
            $updUser->password = $hashedPassword;
            $updUser->update();
            $message = "Passwod restored";
        } else {
            $message = array_pop($errors);
        }
        $this->set(["message" => $message]);
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function validateRegistrationForm($data)
    {
        $errors = [];
        if (trim($data["reg_login"]) == "") {
            array_push($errors, "Login can't be empty");
        }


        if (trim($data["reg_email"]) == "") {
            array_push($errors, "Email can't be empty");
        }


        if (strlen($data["reg_password"]) < 6) {
            array_push($errors, "Password should contain at least 6 characters");
        }

        if ($data["reg_password"] != $data["reg_password_rep"]) {
            array_push($errors, "Passwords fo not match");
        }

        if (User::checkIfUserExistsByLogin($data["reg_login"])) {
            array_push($errors, "User with the same login already exists");
        }

        if (User::checkIfUserExistsByEmail($data["reg_email"])) {
            array_push($errors, "User with the same email already exists");
        }
        return $errors;
    }


}