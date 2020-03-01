<div class="col-md-10" style="width: 80%;margin-left: 10%;margin-top: 5%">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" >
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>用户姓名</th>
                        <th>用户联系方式</th>
                        <th>用户地址</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $data['name']?></td>
                            <td><?php echo $data['mobile']?></td>
                            <td><?php echo $data['province'].$data['city'].$data['country'].$data['detail']?></td>
                            <td><?php echo $data['create_time']?></td>
                        </tr>
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
