<style type="text/css">
    .col-md-8   .col-sm-10 , .col-md-8 .control-label{margin-top: 30px;}

</style>
<h2 class="sub-header">联系人</h2>
{{ form('member/updatelinkman', 'id': 'updateuser', 'onbeforesubmit': 'return false') }}
<div class="container col-md-8 ">
    {{flash.output()}}
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputName">姓名：</label>

        <div class="col-sm-10">
            {{ form.render('name', ['class': 'form-control','value':user.name]) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputAutoMumber">电话：</label>
        <div class="col-sm-10">
            {{ form.render('mobile', ['class': 'form-control','value':user.mobile]) }}
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
<script>
    $('.submit').click(function(){
        if(!$('#mobile').val()){
            alert('电话必须填写');
            return false;
        }
    })
</script>
