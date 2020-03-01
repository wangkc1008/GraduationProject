<div class="col-md-10">
    <div class="row">
        <div class="col-xs-12">

            <div class="table-responsive" style="width: 80%;margin-left: 10%;margin-top: 5%">
                <span class="btn btn-sm btn-info add">添加管理员<i class="icon-edit icon-on-right" style="margin-left:80%;"></i></span>
                &nbsp;&nbsp;&nbsp;共<b><?php echo $total['total'];?></b>名管理员，正常使用<b><?php echo $total['up'];?></b>名管理员，禁用<b style="color: red"><?php echo $total['down'];?></b>名管理员
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>创建时间</th>
                        <th>登录次数</th>
                        <th>上次登陆时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $value) {?>
                        <tr>
                            <td><?php echo $value['user_name']?></td>
                            <td><?php echo $value['create_time']?></td>
                            <td><?php echo $value['login_count']?></td>
                            <td><?php echo $value['login_time']?></td>
                            <td>
                                <span class="btn btn-sm btn-info mod" _id="<?php echo $value['id']?>">修改<i class="icon-edit icon-on-right"></i></span>&nbsp;&nbsp;
                                <?php if ($value['id'] != 1 && $value['is_delete'] == 0) {?>
                                <span class="btn btn-sm btn-danger del" _id="<?php echo $value['id']?>">删除<i class="icon-remove icon-on-right"></i></span>
                                <?php }?>
                                <?php if ($value['is_delete'] == 1) {?>
                                <span class="btn btn-sm btn-warning up" _id="<?php echo $value['id']?>">恢复<i class="icon-remove icon-on-right"></i></span>
                                <?php }?>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".mod").click(function(){
            var id = $(this).attr('_id');
            layui.use("layer",function(){
                layer.open({
                    type: 2,
                    area: ['50%','200px'],
                    shadeClose: true,
                    shade: 0.6,
                    content: './adminEdit?active=1&id='+id,
                    end: function () {
                        window.location.href="./adminList";
                    }
                });
            });
        });
        $(".del").click(function(){
            var id = $(this).attr('_id');
            var data = {
                active: 1,
                id: id
            };
            layui.use("layer",function() {
                layer.confirm('确定删除？', {icon: 3, title:'提示'}, function(index){
                    layer.close(index);
                    $.post('./adminDel',data,function (res) {
                        if (res.match("^{(.+:.+,*){1,}}$")){
                            res = eval('(' + res + ')');
                            if (res.status == 200 ){
                                layui.use("layer",function() {
                                    layer.msg(res.desc,{time:1000});
                                    window.location.href="./adminList";
                                });
                            }
                            layui.use("layer",function() {
                                layer.msg(res.desc);
                            });
                        } else {
                            layui.use("layer",function() {
                                layer.msg('操作失败，请联系管理员');
                            });
                        }
                    });
                });
            });
        });
        $(".up").click(function(){
            var id = $(this).attr('_id');
            var data = {
                active: 1,
                id: id
            };
            layui.use("layer",function() {
                layer.confirm('确定恢复？', {icon: 3, title:'提示'}, function(index){
                    layer.close(index);
                    $.post('./adminUp',data,function (res) {
                        if (res.match("^{(.+:.+,*){1,}}$")){
                            res = eval('(' + res + ')');
                            if (res.status == 200 ){
                                layui.use("layer",function() {
                                    layer.msg(res.desc,{time:1000});
                                    window.location.href="./adminList";
                                });
                            }
                            layui.use("layer",function() {
                                layer.msg(res.desc);
                            });
                        } else {
                            layui.use("layer",function() {
                                layer.msg('操作失败，请联系管理员');
                            });
                        }
                    });
                });
            });
        });
        $(".add").click(function(){
            layui.use("layer",function(){
                layer.open({
                    type: 2,
                    area: ['50%','200px'],
                    shadeClose: true,
                    shade: 0.6,
                    content: './adminAdd',
                    end: function () {
                        window.location.href="./adminList";
                    }
                });
            });
        });
    });

</script>
