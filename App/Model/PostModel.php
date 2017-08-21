<?php


namespace App\Model;


class PostModel
{
    /**
     * @var
     */
    private $postName;

    /**
     * @var
     */
    private $postSlug;

    /**
     * @var
     */
    private $postContent;

    /**
     * ArticleModel constructor.
     * @param $postName
     * @param $postSlug
     * @param $postContent
     */
    public function __construct($postName, $postSlug, $postContent)
    {
        $this->postName = $postName;
        $this->postSlug = $postSlug;
        $this->postContent = $postContent;
    }


    /**
     * @return mixed
     */
    public function getPostName()
    {
        return $this->postName;
    }

    /**
     * @return mixed
     */
    public function getPostSlug()
    {
        return $this->postSlug;
    }

    /**
     * @return mixed
     */
    public function getPostContent()
    {
        return $this->postContent;
    }
}