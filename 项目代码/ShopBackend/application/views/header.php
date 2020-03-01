<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信商城后台</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link href="/ShopBackend/public/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="/ShopBackend/public/jquery-2.1.1/jquery.min.js"></script>
<script src="/ShopBackend/public/layui/layui.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="/ShopBackend/public/bootstrap-3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="/ShopBackend/public/layui/css/layui.css"  media="all">
<div class="container-fluid">
        <div class="col-md-2">
            <ul id="main-nav" class="nav nav-tabs nav-stacked" style="">
                <li class="active">
                    <a href="#">
                        <i class="glyphicon glyphicon-th-large"></i>
                        首页
                    </a>
                </li>
                <li>
                    <a href="#systemSetting" class="nav-header collapsed" data-toggle="collapse">
                        <i class="glyphicon glyphicon-cog"></i>
                        商品管理
                        <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul id="systemSetting" class="nav nav-list collapse secondmenu" style="height: 0px;">
                        <li><a href="<?php echo $base_url; ?>/category/categoryList"><i class="glyphicon glyphicon-credit-card"></i>商品分类</a></li>
                        <li><a href="<?php echo $base_url; ?>/product/productList"><i class="glyphicon glyphicon-th-list"></i>商品详情</a></li>
                        <li><a href="<?php echo $base_url; ?>/order/orderList"><i class="glyphicon glyphicon-asterisk"></i>订单管理</a></li>
                        <li><a href="<?php echo $base_url; ?>/user/userList"><i class="glyphicon glyphicon-user"></i>用户信息</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/admin/adminList">
                        <i class="glyphicon glyphicon-user"></i>
                        管理员管理
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/login/logout">
                        <i class="glyphicon glyphicon-log-out"></i>
                        退出登录
                    </a>
                </li>
            </ul>
        </div>
