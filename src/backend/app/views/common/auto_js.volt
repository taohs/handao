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
        $.getJSON('/models/getModelsByBrandsID/' + $(this).val(), function (data) {
            $('#inputAutoModels').html('');
            $('#inputAutoModelExact').html('');
            $.each(data.models, function (v, n) {
                var option = '<option value="' + v + '">' + n + '</option>';
                $('#inputAutoModels').append(option);
            });
            $.each(data.modelExact, function (v, n) {
                var option = '<option value="' + v + '">' + n + '</option>';
                $('#inputAutoModelExact').append(option);
            });
            doBuild();
        });
    });

    $('#inputAutoModels').change(function () {
        $.getJSON('/cars/getModelExactByModelsID/' + $(this).val(), function (data) {
            $('#inputAutoModelExact').html('');
            $.each(data, function (v, n) {
                var option = '<option value="' + v + '">' + n + '</option>';
                $('#inputAutoModelExact').append(option);
            });
            doBuild();
        });
    });

    $('#inputAutoModelExact').change(function () {
        $.getJSON('/products/getModelsExactRecommend/' + $(this).val(), function (data) {
            buildProductsCategory(data);
        });
    });

    function doBuild(){
        $.getJSON('/products/getModelsExactRecommend/' + $('#inputAutoModelExact').val(), function (data) {
            buildProductsCategory(data);
        });
    }

    function buildProductsCategory(json) {
        $('.productsCategory').remove();
        $.each(json, function (k, v) {
            var template_head = '<div class="form-group productsCategory">' +
                '<label class="col-sm-2 control-label" for="inputProducts">' + v.name + '</label>' +
                '<div class="col-sm-10">' +
                '<select class="form-control" name="inputProducts[]">' +
                '<option>请选择</option>';
            for (i = 0; i < v.data.length; i++) {
                template_head += '<option value="' + v.data[i].id + '"';
                if (v.data[i].featured == 1) {
                    template_head += 'selected="selected"';
                }
                template_head += '"> ' + v.data[i].name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="aligin:right;">￥' + v.data[i].member_price + '</strong></option>';
            }
            var template_foot = '</select>' +
                '</div>' +
                '</div>';
            var template = template_head + template_foot;
            $('#form-remark').before(template);
        });
    }

</script>
