<style type="text/css">
 .col-md-8   .col-sm-10 , .col-md-8 .control-label{margin-top: 30px;}

</style>
<h2 class="sub-header">会员</h2> <a href="/member/list" class="btn btn-primary">返回</a>
{{ form('member/updateuser', 'id': 'updateuser', 'onbeforesubmit': 'return false') }}
<div class="container col-md-8 ">
    {{flash.output()}}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">用户名：</label>

            <div class="col-sm-10">
                {{ form.render('username', ['class': 'form-control','value':user.username]) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoMumber">电话：</label>
            <div class="col-sm-10">
                {{ form.render('mobile', ['class': 'form-control','value':user.mobile]) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoMumber">邮箱：</label>
            <div class="col-sm-10">
                {{ form.render('email', ['class': 'form-control','value':user.email]) }}
            </div>
        </div>

        <div  class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {{ form.render('id', ['value':user.id]) }}
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
