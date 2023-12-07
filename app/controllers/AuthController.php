<?php

use Simplex\Blade;
use Simplex\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AuthController {
    public static function login(Request $request) : Response {
        $session = $request->getSession();
        if ($session->get("loggedIn") === true) {
            echo "Already logged in";
            return new RedirectResponse("/");
        }
        
        $loginForm = new Form("login-form", $request->getSession());
        $loginForm->clearSession();

        $loginForm->addConstraint(
            "username", 
            fn($usernameValue, $allValues) => UserModel::correctCredentials($usernameValue, $allValues["password"]), 
            "The username or password is incorrect"
        );
        
        if ($request->getMethod() === "POST") {
            if ($loginForm->validate($request->request) === true) {
                $session->replace(["loggedIn" => true, "username" => $request->request->get("username")]);
                return new Response("Successful login");
            }
        }

        return Blade::render("login", ["loginForm" => $loginForm]);
    }

    public static function signUp(Request $request) : Response {        
        if ($request->getSession()->get("loggedIn") === true) {
            echo "Already logged in";
            return new RedirectResponse("/");
        }

        $signUpForm = new Form("signup-form", $request->getSession());
        $signUpForm->clearSession();

        $signUpForm->addConstraint("username", fn($val) => UserModel::userExists($val) === false, "Username already taken");
        $signUpForm->addConstraint("confirm_password", fn($pass2, $allValues) => $pass2 === $allValues["password"], "Passwords do not match");
        $signUpForm->addConstraint("telephone", fn($val) => is_numeric($val), "Must contain only numbers");
        $signUpForm->addConstraint("mobile_number", fn($val) => is_numeric($val), "Must contain only numbers");
        
        if ($request->getMethod() === "POST") {
            if ($signUpForm->validate($request->request) === true) {
                UserModel::createUser($request->request->all());
                return new Response("Successful sign up");
            }
        }

        return Blade::render("signup", ["signUpForm" => $signUpForm]);
    }

    public static function logOut(Request $request) : Response {
        $session = $request->getSession();
        $session->remove("loggedIn");
        $session->remove("username");

        return new RedirectResponse("/");
    }
}