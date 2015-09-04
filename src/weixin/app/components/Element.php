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


    function getTime($datetime){
        return substr($datetime,11,5);
    }

    public function getTireNameByPosition($position){
        switch($position){
            case 1:
                return '左前';
                break;
            case 2:
                return '左后';
                break;
            case 3:
                return '右前';
                break;
            case 4:
                return '右后';
                break;
            case 5:
                return '备胎';
                break;
            case 6:
                return '备胎';
                break;
            default:
                return '左前';
                break;
        }
    }
}