<?php

namespace app\controllers;

use League\Plates\Engine;
use app\Db;
use \Delight\Auth\Auth;
use \Tamtamchik\SimpleFlash\Flash;
use SimpleMail;

use PDO;

class Home
{
    private $templates;

    public function __construct( Engine $engine, Db $db, Auth $auth, Flash $flash)
    {
        $this->templates = $engine;
        $this->db = $db;
        $this->auth = $auth;
        if( !session_id() ) @session_start();
        $this->flash = $flash;
        $this->isAdmin();
    }

    public function index()
    {
        $posts = $this->db->getAll('post');
        $pages = count($this->db->getPostsTotal('post'));
        echo $this->templates->render('index', ['posts' => $posts, 'pages'=>$pages]);
    }
    public function post($id = 1){
        $post = $this->db->getOne('post', $id);
        echo $this->templates->render('post', ['post' => $post]);
    }

    public function edit($id){
        $post = $this->db->getOne('post', $id);
        if(count($_POST)>0){
            $this->db->update('post', $_POST, $id);
            header('Location: /');
        }
        echo $this->templates->render('edit', ['post' => $post]);
    }
    public function about($vars)
    {
        echo $this->templates->render('about', ['name' => 'Jonathan About']);
    }



    public function signup($vars)
    {

        if (count($_POST)>0) {
            try {
                $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                    $link = 'http://'.$_SERVER['HTTP_HOST'].'/verify?selector=' . urlencode($selector) . '&token=' . urlencode($token);
                    //echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                    SimpleMail::make()
                        ->setTo($_POST['email'], $_POST['username'])
                        ->setFrom('admin@myblog.com', 'Admin')
                        ->setSubject('registration')
                        ->setMessage($link)
                        ->send();
                    echo $this->templates->render('success', ['link'=> $link]);
                    die();
                });

                echo 'We have signed up a new user with the ID ' . $userId;
            } catch (\Delight\Auth\InvalidEmailException $e) {
                //die('Invalid email address');
                $this->flash->error('Invalid email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                //die('Invalid password');
                $this->flash->error('Invalid password');
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                //die('User already exists');
                $this->flash->error('User already exists');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                //die('Too many requests');
                $this->flash->error('Too many requests');
            }
        }
        $_POST = [];
        echo $this->templates->render('signup', ['flash' => $this->flash]);

    }

    public function verifyEmail()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login()
    {
        if(count($_POST)>0){
            try {
                $this->auth->login($_POST['email'], $_POST['password']);

                //echo 'User is logged in';
                header('Location: /');
            } catch (\Delight\Auth\InvalidEmailException $e) {
                //die('Wrong email address');
                $this->flash->error('Wrong email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                //die('Wrong password');
                $this->flash->error('Wrong password');
            } catch (\Delight\Auth\EmailNotVerifiedException $e) {
                //die('Email not verified');
                $this->flash->error('Email not verified');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                //die('Too many requests');
                $this->flash->error('Too many requests');
            }
        }
        $_POST = [];
        $_SESSION['username'] = $this->getUsername();
        echo $this->templates->render('login', ['flash' => $this->flash]);

    }

    public function logout()
    {
        $this->auth->logOut();
        header('Location: /');
        //$this->index();

   }

   public function isLogged(){
        return $this->auth->isLoggedIn();
   }

   public function getUserId(){
       if($this->isLogged()){
           return $this->auth->getUserId();
       }
   }
   public function getUsername(){
       if($this->isLogged()) {
           return $this->auth->getUsername();
       }
   }

   public function assignRoleById($userId, $role=\Delight\Auth\Role::SUBSCRIBER){
       try {
           $this->auth->admin()->addRoleForUserById($userId, $role);
       }
       catch (\Delight\Auth\UnknownIdException $e) {
           die('Unknown user ID');
       }
   }

   public function isAdmin(){
       $_SESSION['isAdmin'] = $this->auth->hasRole(\Delight\Auth\Role::ADMIN);
      return $_SESSION['isAdmin'];
   }

}