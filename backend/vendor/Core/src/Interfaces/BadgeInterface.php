<?php

namespace Core\Interfaces;


interface BadgeInterface{

    /* GETS */
    /**
     * Get badge by id
     *
     * @return array[]
     */
    public function getBadge($id);

    public function getListBadge( $order);

    /* ADD */    
    public function addModel($data);

    /* UPDATE */
    public function updateModel($id, $data);

    /*DELETE*/
    public function deleteModel($id);

}