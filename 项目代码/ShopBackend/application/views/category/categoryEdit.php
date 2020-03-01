<div class="col-xs-10">
    <div class="form-horizontal" style="width: 80%;margin-left: 30%;margin-top: 50px">
        <div class="space-12"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">名称：</label>
            <div  class="col-sm-4">
                <input class="form-control" id="category_name" value="<?php echo $category_info['name'];?>">
            </div>
        </div>
        <div class="form-group">
            <span class="btn btn-sm btn-success confirm" style="margin-left: 30%" _id="<?php echo $category_info['id'];?>">确定</span>
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
            var category_name = $.trim($("#category_name").val());
            var data = {
                active: 2,
                id: id,
                category_name: category_name
            };
            $.post('./categoryEdit',data,function (res) {
                if (res.match("^{(.+:.+,*){1,}}$")){
                    res = eval('(' + res + ')');
                    if (res.status == 200 ){
                        layui.use("layer",function() {
                            layer.msg(res.desc);
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
