<div class="col-md-10" style="width: 80%;margin-left: 10%;margin-top: 5%">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>商品价格</th>
                        <th>商品数量</th>
                        <th>下单时是否有库存</th>
                        <th>商品总价</th>
                        <th>商品图片</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $value) {?>
                        <tr>
                            <td><?php echo $value['name']?></td>
                            <td><?php echo $value['price']?></td>
                            <td><?php echo $value['counts']?></td>
                            <td><?php echo $value['haveStock_desc']?></td>
                            <td><?php echo $value['totalPrice']?></td>
                            <td><img src="<?php echo $value['main_img_url']?>" style="width: 150px;height: 150px"></td>
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
