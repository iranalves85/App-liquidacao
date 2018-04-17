<?php

namespace Core\Interfaces;

interface LoginInterface{

    public function userLogin($data);

    public function userLogout($data);

}