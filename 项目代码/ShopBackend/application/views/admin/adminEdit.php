<div class="col-xs-10">
    <div class="form-horizontal" style="width: 80%;margin-left: 20%">
        <div class="space-12"></div>
        <div class="form-group" style="margin-left: 20%;margin-top: 30px">
            <label class="col-sm-2 control-label no-padding-right">名称</label>
            <div  class="col-sm-4">
                <input class="form-control" id="admin_name" value="<?php echo $admin_info['user_name'];?>">
            </div>
        </div>
        <div class="form-group">
            <span class="btn btn-sm btn-success confirm" style="margin-left: 45%" _id="<?php echo $admin_info['id'];?>">确定</span>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function () {
        if(top.location != self.location){
            $('#main-nav').hide();
            $('#breadcrumbs').hide();
            $('#sidebar').hide();
            $('#select-div').hide();
            $('.history').hide();
            $('#menu-toggler').hide();
            $('.main-content').css('margin-left','0');
        }
    });
    $(document).ready(function(){
        $(".confirm").click(function(){
            var id = $(this).attr('_id');
            var admin_name = $.trim($("#admin_name").val());
            var data = {
                active: 2,
                id: id,
                admin_name: admin_name
            };
            $.post('./adminEdit',data,function (res) {
                if (res.match("^{(.+:.+,*){1,}}$")){
                    res = eval('(' + res + ')');
                    if (res.status == 200 ){
                        layui.use("layer",function() {
                            layer.msg(res.desc,{time:1000});
//                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
//                        parent.layer.close(index); //再执行关闭
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
</script>
