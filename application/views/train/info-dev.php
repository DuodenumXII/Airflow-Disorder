<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Airflow Disorder-火车票查询结果</title>
    <link rel="stylesheet" type="text/css" href="../../../semantic/dist/semantic.css">

    <script src="../../../semantic/dist/jquery-3.2.1.min.js"></script>
    <script src="../../../semantic/dist/semantic.js"></script>
    <script>
        $(document).ready(function(){

        });

        function buy_ticket(e) {
            var data = e.getAttribute('data-info').split('&');
            alert(data);
            return false;
        }
    </script>
</head>
<body>

<!-- Following Menu -->
<div class="ui purple inverted borderless menu">
    <div class="ui container">
        <a class="item">首页</a>
        <a class="item">机票</a>
        <a class="item">酒店</a>
        <a class="active item">火车票</a>
        <a class="item">旅游</a>
        <div class="right menu">
            <div class="item">
                <div class="ui icon input">
                    <input type="text" placeholder="搜索...">
                    <i class="search link icon"></i>
                </div>
            </div>
            <a class="item">登陆</a>
            <a class="item">注册</a>
        </div>
    </div>
</div>

<div class="ui container">
    <table class="ui fixed table">
        <thead>
        <tr><th>车次</th>
            <th>发站/到站</th>
            <th>发/到时间</th>
            <th>运行时间</th>
            <th>参考票价</th>
            <th>操作</th>
        </tr></thead>
        <tbody>
        <tr>
            <td>
                <h3 class="ui header">G4</h3>
                <a>查看经停</a>
            </td>
            <td>
                <h4>[始]北京南</h4>
                <h4>[终]上海虹桥</h4>
            </td>
            <td>
                <h4>07:00</h4>
                <h4>11:55</h4>
            </td>
            <td>
                <span>4小时55分</span>
            </td>
            <td>
                <p>二等座<span style="color:red">￥553</span></p>
                <p>一等座<span style="color:red">￥993</span></p>
                <p>商务座<span style="color:red">￥1748</span></p>
            </td>
            <td>
                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&二等座">购票</a></p>
                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&一等座">购票</a></p>
                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&商务座">购票</a></p>
            </td>
        </tr>
        </tbody>
    </table>

</div>
<!--footer-->
<br>
<div class="ui purple inverted vertical footer segment">
    <div class="ui container">
        <div class="ui stackable inverted divided equal height stackable grid">
            <div class="three wide column">
                <h4 class="ui inverted header">About</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Sitemap</a>
                    <a href="#" class="item">Contact Us</a>
                    <a href="#" class="item">Religious Ceremonies</a>
                    <a href="#" class="item">Gazebo Plans</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui inverted header">Services</h4>
                <div class="ui inverted link list">
                    <a href="#" class="item">Banana Pre-Order</a>
                    <a href="#" class="item">DNA FAQ</a>
                    <a href="#" class="item">How To Access</a>
                    <a href="#" class="item">Favorite X-Men</a>
                </div>
            </div>
            <div class="seven wide column">
                <h4 class="ui inverted header">Footer Header</h4>
                <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
            </div>
        </div>
    </div>
</div>

</body>

</html>
