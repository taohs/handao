<style type="text/css">
 .col-md-8   .col-sm-10 , .col-md-8 .control-label{margin-top: 30px;}

</style>
<h2 class="sub-header">技师</h2> <a href="/technician/list" class="btn btn-primary">返回</a>
{{ form('technician/resetPassword', 'id': 'updateuser', 'onbeforesubmit': 'return false') }}
<div class="container col-md-8 ">
    {{flash.output()}}
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">用户名：</label>

            <div class="col-sm-10">

                <input class="form-control" value="{{model.username}}" disabled>
            </div>
        </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="inputName">姓名：</label>

        <div class="col-sm-10">

            <input class="form-control" value="{{model.name}}" disabled>
        </div>
    </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoMumber">电话：</label>
            <div class="col-sm-10">

                <input class="form-control" value="{{model.mobile}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputAutoMumber">邮箱：</label>
            <div class="col-sm-10">

                <input type="email" class="form-control" value="{{model.email}}" disabled>
            </div>
        </div>

        <div  class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">

                {{ submit_button('重置密码', 'class': 'btn btn-primary submit') }}
                <input type="hidden" name="id" class="form-control" value="{{model.id}}" >


            </div>

        </div>
    </form>
</div>

