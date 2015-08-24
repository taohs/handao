
<h2 class="sub-header">修改角色</h2>
<a href="/admin/rolelist" class="btn btn-primary">返回</a>
<div class="container col-md-8 ">
    {{flash.output()}}
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputUsername">角色名：</label>
            <div class="col-sm-10">
                <input class="form-control" name="name" id="inputName" value="{{admin.name}}">
                <input type="hidden" class="form-control" name="id" id="inputId" value="{{admin.id}}"/>
                <input type="hidden" class="form-control" name="parent_id" id="inputId" value="{{admin.parent_id}}"/>
            </div>
        </div>

        <div class="form-group" class="checkbox col-sm-2 control-label">
            <label class="col-sm-2 control-label" for="inputIs_valid">启用：</label>
            <div class="col-sm-10 form-horizontal">
                <input type="checkbox" name="is_valid" id="inputIs_valid" {%if admin.is_valid%} checked="checked"
                {%endif%}/>
            </div>
        </div>
        <div  class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">提交保存</button>
            </div>

        </div>
    </form>
</div>
