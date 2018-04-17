<?php

namespace Core\Interfaces;


interface UserInterface{

    /* GETS */
    /**
     * Get badge by id
     *
     * @return array[]
     */
    public function login($id);

    public function getUser( $order);

    public function getUsers( $order);

    /* ADD */    
    public function addUser($data);

    /* UPDATE */
    public function updateUser($id, $data);

    /*DELETE*/
    public function deleteUser($id);

}