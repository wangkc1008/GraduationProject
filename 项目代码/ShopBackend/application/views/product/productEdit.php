<div class="col-xs-10">
    <div class="form-horizontal" style="width: 80%;margin-left: 20%">
        <div class="space-12"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">名称</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_name" value="<?php echo $product_info['name'];?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">价格</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_price" value="<?php echo $product_info['price'];?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">库存量</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_stock" value="<?php echo $product_info['stock'];?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">所属分类</label>
            <div  class="col-sm-4">
                <select class="form-control" id="product_category">
                    <?php foreach ($category as $key => $value) {?>
                    <option value="<?php echo $value['id'];?>" <?php if ($value['id'] == $product_info['category_id']){ echo "selected";}?>><?php echo $value['name'];?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <span class="btn btn-sm btn-success confirm" style="margin-left: 45%" _id="<?php echo $product_info['id'];?>">确定</span>
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
            var product_name = $.trim($("#product_name").val());
            var product_price = $.trim($("#product_price").val());
            var product_stock = $.trim($("#product_stock").val());
            var product_category = $.trim($("#product_category").val());
            var data = {
                active: 2,
                id: id,
                product_name: product_name,
                product_price: product_price,
                product_stock: product_stock,
                product_category: product_category
            };
            $.post('./productEdit',data,function (res) {
                if (res.match("^{(.+:.+,*){1,}}$")){
                    res = eval('(' + res + ')');
                    if (res.status == 200 ){
                        layui.use("layer",function() {
                            layer.msg(res.desc,{time:1000});
//                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
//                            parent.layer.close(index); //再执行关闭
                        });
                    }
                    layui.use("layer",function() {
                        layer.msg(res.desc,{time:1000});
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
