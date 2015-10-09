<style type="text/css">
    .col-md-8   .col-sm-10 , .col-md-8 .control-label{margin-top: 30px;}

</style>
<h2 class="sub-header">车辆</h2>
{{ form('member/updateauto', 'id': 'updateuser', 'onbeforesubmit': 'return false') }}
<div class="container col-md-8 ">
    {{flash.output()}}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputName">许可证：</label>

        <div class="col-sm-10">
            {{ form.render('license', ['class': 'form-control','value':user.license]) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">车牌号：</label>
        <div class="col-sm-10">
            {{ form.render('number', ['class': 'form-control','value':user.number]) }}
        </div>
    </div>
    {{partial('common/auto_tpl',['exact':true])}}
    {{partial('common/auto_js')}}

    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">购买年份：</label>
        <div class="col-sm-10">
            {{ form.render('year', ['class': 'form-control','value':user.year]) }}
        </div>
    </div>
    <div  class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            {{ form.render('id', ['value':user.id]) }}
            {{ form.render('user_id', ['value':user_id]) }}
            {{ submit_button('提交', 'class': 'btn btn-primary submit') }}

        </div>

    </div>
    </form>
</div>

