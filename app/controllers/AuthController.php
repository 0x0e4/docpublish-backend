<?php

namespace app\controllers;

class AuthController extends AbstractController {
    public function login(): string {
        if(!isset($this->request->password) || empty($this->request->password) || $this->request->password != \app\engine\Config::$adminPass) return '0';
        
        return '1';
    }
}