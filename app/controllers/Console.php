<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/5/2019
 * Time: 5:54 PM
 */

namespace app\controllers;
use Faker\Factory;
use app\Db;


class Console
{
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->db = new Db();
    }

    public function createPosts(){
        for($i=0; $i < 200; $i ++){
            $post = [
                'title' => $this->faker->words(3, true),
                'content' => $this->faker->text
            ];
            $this->db->insert('post', $post);
        }
    }

}