<?php

class HdCmsArticleInChannel extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $article_id;

    /**
     *
     * @var integer
     */
    public $channel_id;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_cms_article_in_channel';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdCmsArticleInChannel[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HdCmsArticleInChannel
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
