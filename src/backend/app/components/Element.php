<?php

/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/24/15
 * Time: 21:30
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/24/15  Time: 21:30
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */

class Element
{
    /**
     * @param $paginate Phalcon\Paginator\AdapterInterface
     * @return string
     */
    function getPaginateLink($paginate)
    {
        return
            '<div class="">
                <div class="form-inline">
                    <a href="list">第一页</a>
                    <a href="list?page='. $paginate->before .'">上一页</a>
                    <a href="list?page='. $paginate->next.'">下一页</a>
                    <a href="list?page='. $paginate->last.'">最后一页</a>
                您正在第  ' . $paginate->current .  "/" . $paginate->total_pages . '页' .
                '</div>
        </div>';
    }
}