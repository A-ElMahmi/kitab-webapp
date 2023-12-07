<?php

class UserModel {
    public static function correctCredentials(string $username, string $password) : bool {
        $result = DB::query("SELECT password FROM users WHERE username = ?", [trim($username)]);
        return $result !== false ? password_verify($password, $result["password"]) : false;
    }

    public static function userExists(string $username) : bool {
        return DB::query("SELECT * FROM users WHERE username = ?", [trim($username)]) !== false;
    }

    public static function createUser(array $formValues) {
        DB::query(
            "INSERT INTO users (username, password, firstname, lastname, address_line_1, address_line_2, address_city, telephone, mobile_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [trim($formValues["username"]), password_hash($formValues["password"], PASSWORD_DEFAULT), trim($formValues["firstname"]), 
            trim($formValues["lastname"]), $formValues["address_line_1"], $formValues["address_line_2"], $formValues["address_city"], 
            $formValues["telephone"], $formValues["mobile_number"]]
        );
    }
}