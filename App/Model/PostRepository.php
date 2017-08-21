<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 19.08.2017
 * Time: 20:50
 */

namespace App\Model;

use App\lib\Registry;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var
     */
    private $connection;

    /**
     * @var
     */
    private $path;

    /**
     * PostRepository constructor.
     * @param $connection
     * @param $path
     */
    public function __construct($connection, $path)
    {
        $this->connection = $connection;
        $this->path = $path;
    }

    /**
     * @return PostModel|null
     */
    public function getRandomPostAndDelete()
    {
        //getting all files from directory excluding '.' and '..' folders
        $allFiles = scandir($this->path);
        $allFiles = $this->normilizeArray($allFiles);

        //get random number
        $rand = rand ( 0 , count($allFiles)-1 );

        //get article name
        $articleName = $allFiles[$rand];

        //get name of Post
        $postName = $this->postNameNormalize($articleName);


        //get post slug
        $postSlug = $this->slugNormalize($articleName);

        //get post content
        $postContent = file_get_contents($this->path.'/'.$articleName);
        $postContent = $this->contentNormalize($postContent);

        if ($postName && $postSlug && $postContent){
            //deleting article from directory
            unlink ($this->path.'/'.$articleName);

            //return new post
            return new PostModel($postName, $postSlug, $postContent);
        }

        return null;

    }

    /**
     * @param PostModel $post
     * @return mixed
     */
    public function insertIntoDataBase(PostModel $post)
    {
        $table = Registry::getServiceOrParam('table');

        $stmt = $this->connection->prepare(
            "INSERT INTO ". $table. " 
            (
                ID,
                post_author,
                post_date,
                post_date_gmt,
                post_content,
                post_title,
                post_excerpt,
                post_status,
                comment_status,
                ping_status,
                post_password,
                post_name,
                to_ping,
                pinged,
                post_modified,
                post_modified_gmt,
                post_content_filtered,
                post_parent,
                guid,
                menu_order,
                post_type,
                post_mime_type,
                comment_count
             ) 
 			VALUES (
 			    NULL,
 			    1,
 			    ?,
 			    ?,
 			    ?,
 			    ?,
 			    '',
 			    'publish',
 			    'closed',
 			    'closed',
 			    '',
 			    ?,
 			    '',
 			    '',
 			    ?,
 			    ?,
 			    '',
 			    0,
 			    '',
 			    0,
 			    'post',
 			    '',
 			    0
 			)"
        );

        $stmt->bindParam(1, date('Y-m-d G:i:s'));
        $stmt->bindParam(2, date('Y-m-d G:i:s'));
        $stmt->bindParam(3, $post->getPostContent(), \PDO::PARAM_STR);
        $stmt->bindParam(4, $post->getPostName(), \PDO::PARAM_STR);
        $stmt->bindParam(5, $post->getPostSlug(), \PDO::PARAM_STR);
        $stmt->bindParam(6, date('Y-m-d G:i:s'));
        $stmt->bindParam(7, date('Y-m-d G:i:s'));

        return $stmt->execute();
    }

    /**
     * @param $allPosts
     * @return array
     */
    private function normilizeArray ($allPosts)
    {
        return array_values(array_diff($allPosts, ['..', '.']));
    }

    /**
     * @param $articleName
     * @return string
     */
    private function postNameNormalize($articleName)
    {
        $name = str_replace ( '-' , ' ' ,$articleName);
        $name  = ucwords(str_replace ( '.txt' , '' , $name ));

        return $name;
    }

    /**
     * @param $articleName
     * @return string
     */
    private function slugNormalize($articleName)
    {
        $slug =  str_replace ( '.txt' , '' , $articleName);
        $slug =  preg_replace ( '/[,-.\/\\\ !?;\'"#_]+/is' , '-' , $slug);
        $slug =  preg_replace ( '/[^a-z^A-Z^0-9^-]+/is' , '-' , $slug);
        $slug =  preg_replace ( '/[-]+/is' , '-' , $slug);
        $slug =  preg_replace ( '/-$/is' , '' , $slug);

        return $slug;
    }

    /**
     * @param $postContent
     * @return string
     */
    private function contentNormalize($postContent)
    {
        return str_replace("'", "\'", $postContent);
    }

}