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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('article_id', 'HdCmsArticle', 'id', array('alias' => 'HdCmsArticle'));
        $this->belongsTo('channel_id', 'HdCmsArticleChannel', 'id', array('alias' => 'HdCmsArticleChannel'));
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

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hd_cms_article_in_channel';
    }

}
