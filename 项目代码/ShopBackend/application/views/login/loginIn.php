<div class="form row" style="margin-top: 10%">
    <form class="form-horizontal col-sm-offset-3 col-md-offset-3" id="login_form" action="./checkLogin" method="post">
        <h1 class="form-title" style="margin-left: 22%">微信手机商城后台</h1>
        <br>
        <br>
        <div class="col-sm-5 col-md-5" style="margin-left: 15%">
            <div class="form-group">
                <i class="fa fa-user fa-lg"></i>
                <input class="form-control required" type="text" placeholder="Username" name="username" autofocus="autofocus" maxlength="20"/>
            </div>
            <div class="form-group">
                <i class="fa fa-lock fa-lg"></i>
                <input class="form-control required" type="password" placeholder="Password" name="password" maxlength="8"/>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="checkbox">-->
<!--                    <input type="checkbox" name="remember" value="1"/> Remember me-->
<!--                </label>-->
<!--                <hr />-->
<!--                <a href="javascript:;" id="register_btn" class="">Create an account</a>-->
<!--            </div>-->
            <input name="active" value="1" style="display: none">
            <div class="form-group" style="text-align: center">
                <input type="submit" class="btn btn-success" value="Login "/>
            </div>
        </div>
    </form>
</div>
</div>
</div>
<script type="text/javascript">
    $(function () {
        $('#main-nav').hide();
        $('#breadcrumbs').hide();
        $('#sidebar').hide();
        $('#select-div').hide();
        $('.history').hide();
        $('#menu-toggler').hide();
        $('.main-content').css('margin-left','0');
    });
</script>
