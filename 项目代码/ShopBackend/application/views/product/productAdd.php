<div class="col-xs-10">
    <form action="./productAdd" method="post" enctype="multipart/form-data">
    <div class="form-horizontal" style="width: 80%;margin-left: 20%">
        <div class="space-12"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">名称</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_name" name="product_name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">价格</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_price" name="product_price">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">库存量</label>
            <div  class="col-sm-4">
                <input class="form-control" id="product_stock" name="product_stock">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">所属分类</label>
            <div  class="col-sm-4">
                <select class="form-control" id="product_category" name="product_category">
                    <?php foreach ($category as $key => $value) {?>
                        <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <input type="file" name="img" />
        <input name="active" value="1" style="display: none"/>
        <div class="form-group">
            <input class="btn btn-sm btn-success confirm" style="margin-left: 45%" type="submit" name="sub" value="确定" />
        </div>
    </div>
    </form>
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
</script>
