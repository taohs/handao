<?php
/**
 * Created by PhpStorm.
 * User: taohs
 * Date: 8/27/15
 * Time: 16:39
 * @author taohaisong <taohaisong@gmail.com>
 * @date: 8/27/15  Time: 16:39
 * @link http://www.php4s.com/
 * @copyright
 * @license http://www.php4s.com/license/
 * @package PHP
 */
?>
<script type="text/javascript">
    $('#inputBrands').change(function () {
        $.getJSON('/models/getModelsByBrandsID/'+$(this).val(),function(data){
            $('#inputAutoModels').html('');
            $.each(data,function (v,n) {
                var option = '<option value="' + v +'">'+ n + '</option>';
                $('#inputAutoModels').append(option);
            });
        });
    });

    $('#inputAutoModels').change(function () {
        $.getJSON('/cars/getModelExactByModelsID/'+$(this).val(),function(data){
            $('#inputAutoModelExact').html('');
            $.each(data,function (v,n) {
                var option = '<option value="' + v +'">'+ n + '</option>';
                $('#inputAutoModelExact').append(option);
            });
        });
    });
</script>
