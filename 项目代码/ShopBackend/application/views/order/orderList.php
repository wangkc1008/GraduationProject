<div class="col-md-10">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" style="width: 80%;margin-left: 10%;margin-top: 5%">
               共<b><?php echo $total['total'];?></b>个订单，已支付<b><?php echo $total['up'];?></b>个订单，未支付<b style="color: red"><?php echo $total['down'];?></b>个订单
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>用户名</th>
                        <th>创建时间</th>
                        <th>总价</th>
                        <th>状态</th>
                        <th>订单商品</th>
                        <th>订单名称</th>
                        <th>商品数量</th>
                        <th>更新时间</th>
                        <th>查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $value) {?>
                        <tr>
                            <td><?php echo $value['user_name']?></td>
                            <td><?php echo $value['create_time']?></td>
                            <td><?php echo $value['total_price']?></td>
                            <td style="color: red"><b><?php echo $value['status_desc']?></b></td>
                            <td><img src="<?php echo $value['snap_img']?>" style="width: 150px;height: 150px"></td>
                            <td><?php echo $value['snap_name']?></td>
                            <td><?php echo $value['total_count']?></td>
                            <td><?php echo $value['update_time']?></td>
                            <td>
                                <span class="btn btn-sm btn-info seeOrder" _id="<?php echo $value['id']?>">查看订单<i class="icon-edit icon-on-right"></i></span>&nbsp&nbsp
                                <span class="btn btn-sm btn-info seeUser" _id="<?php echo $value['id']?>">查看用户<i class="icon-edit icon-on-right"></i></span>
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
        $(".seeOrder").click(function(){
            var id = $(this).attr('_id');
            layui.use("layer",function(){
                layer.open({
                    type: 2,
                    area: ['70%','500px'],
                    shadeClose: true,
                    shade: 0.6,
                    content: './orderSee?active=1&id='+id,
                    end: function () {
                        window.location.href="./orderList";
                    }
                });
            });
        });
        $(".seeUser").click(function(){
            var id = $(this).attr('_id');
            layui.use("layer",function(){
                layer.open({
                    type: 2,
                    area: ['70%','200px'],
                    shadeClose: true,
                    shade: 0.6,
                    content: './orderSeeUser?active=1&id='+id,
                    end: function () {
                        window.location.href="./orderList";
                    }
                });
            });
        });
    });

</script>
