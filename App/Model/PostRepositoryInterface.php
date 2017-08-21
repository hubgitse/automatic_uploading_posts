<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 19.08.2017
 * Time: 20:49
 */

namespace App\Model;


interface PostRepositoryInterface
{

    public function getRandomPostAndDelete();

    public function insertIntoDataBase(PostModel $post);

}