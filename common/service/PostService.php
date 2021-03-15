<?php


namespace common\service;


use common\models\Post;

class PostService
{
    public function getAllPost()
    {
        $postM = new Post();
        return $postM->findOne(['id' => 32]);
    }
}