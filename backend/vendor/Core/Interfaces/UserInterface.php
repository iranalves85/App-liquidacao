<?php

namespace Core\Interfaces;
use Core\Connect as Connect;

interface UserInterface{

    /* GETS */
    /**
     * Get badge by id
     *
     * @return array[]
     */
    public function getUser( $order);

    public function getUsers( $order);

    /* ADD */    
    public function addUser(Connect $connect, $id, $data);

    /* UPDATE */
    public function updateUser(Connect $connect, $id, $data);

    /*DELETE*/
    public function deleteUser($id);

}