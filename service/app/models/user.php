<?php
class User {
    public $login;
    public $password;
    public $phone;
    public $email;

    public function __construct(array $attributes){
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
        $this->save();
    }

    private function save() {
        file_put_contents('./users/'.md5($this->login.getenv('SECRET')).'.txt', serialize($this));
    }

}