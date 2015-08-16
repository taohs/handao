<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/14/15
 * Time: 00:08
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/14/15  Time: 00:08
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            {{partial('layouts/nav_left')}}
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">{{content()}}</div>
    </div>
</div>
