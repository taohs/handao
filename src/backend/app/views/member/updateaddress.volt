<style type="text/css">
    .col-md-8   .col-sm-10 , .col-md-8 .control-label{margin-top: 30px;}

</style>
<h2 class="sub-header">联系地址</h2>
{{ form('member/updateaddress', 'id': 'updateuser', 'onbeforesubmit': 'return false') }}
<div class="container col-md-8 ">
    {{flash.output()}}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputName">省份：</label>

        <div class="col-sm-10">
            {{ form.render('province', ['class': 'form-control','value':user.province]) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">城市：</label>
        <div class="col-sm-10">
            {{ form.render('city', ['class': 'form-control','value':user.city]) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">地区：</label>
        <div class="col-sm-10">
            {{ form.render('area', ['class': 'form-control','value':user.area]) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">地址：</label>
        <div class="col-sm-10">
            {{ form.render('address', ['class': 'form-control','value':user.address]) }}
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

