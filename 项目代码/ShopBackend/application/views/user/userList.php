<div class="col-md-10">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" style="width: 80%;margin-left: 10%;margin-top: 5%">
                共<b><?php echo $total;?></b>用户
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>用户姓名</th>
                        <th>用户联系方式</th>
                        <th>用户地址</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $value) {?>
                        <tr>
                            <td><?php echo $value['name']?></td>
                            <td><?php echo $value['mobile']?></td>
                            <td><?php echo $value['province'].$value['city'].$value['country'].$value['detail']?></td>
                            <td><?php echo $value['create_time']?></td>
                            <td><?php echo $value['update_time']?></td>
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
