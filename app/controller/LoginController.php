<?php
session_start();

include_once("model/Login.php");
include_once("model/ProfilePic.php");
include_once("model/Online.php");
class LoginController{
public $model;
public $model2;
public $model3;
public function __construct(){
$this->model = new Login();
$this->model2 = new ProfilePic();
$this->model3 = new Online();

}
public function invoke(){
if(!isset($_POST["email"])){
$users = $this->model->getAllUsers();
//var_dump($_POST['username']);
//var_dump($users);
include '../mvc/sbAdmin/login.php';
}
else{
    $user = $this->model->getUser($_POST["email"]);
        if ($user["password"]==$_POST["password"])
        {
            $getOnlineUser = $this->model3->getOnlineUser($user['userid']);
            $_SESSION['displayname']=$user['displayname'];
            $_SESSION["currentuser"]= $user['username'];
            $_SESSION["profilepic"]=$this->model2->getPic($user["username"], 'profile');
            $_SESSION["userid"]=$user['userid'];
            $_SESSION["email"]=$user['email'];
            $_SESSION['password']=$user['password'];
            $x = $user["username"];
            $_SESSION['profileURL'] = '../mvc/sbAdmin/users/'.$x.'.php';
    include '../mvc/sbAdmin/indexBoard.php';
    //echo 'authorization worked';
        }
        else
        {
            include '../mvc/sbAdmin/register.php';
        }
    }}
} ?>