<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Airflow Disorder-火车票查询结果</title>
    <link href="https://cdn.bootcss.com/semantic-ui/2.2.11/semantic.min.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/semantic-ui/2.2.11/semantic.min.js"></script>
    <script>
        $(document).ready(function(){
            $.post(
                '/index.php/user/query/trains2s',
                JSON.stringify({'start': '北京', 'end': '上海', 'date': '+2 day'}),
                function (data) {
                    //var arr = JSON.parse(data);
                    var arr = data;
//                    for (var i in arr['data']) {
//                        alert(i);
//                    }
                    var tbody_html = '';
//                    alert(arr.toSource());
                    for (var item in arr['data']['result']['list']) {
                        var name = item['train_no'];
                        var start = '[' + item['start_station_type'] + ']' +  item['start_station'];
                        var end = '[' + item['end_station_type'] + ']' +  item['end_station'];
                        var start_time = item['start_time'];
                        var end_time = item['end_time'];
                        var run_time = item['run_time'];
                        var price_list = item['price_list'];
                        var seat_class = '';
                        var button = '';
                        for (var temp in price_list) {
                            seat_class += `<p>${temp['price_type']}<span style="color:red">￥${temp['price']}</span></p>
`;
                            button += `<p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="${name}&{start}&${end}&${temp['price_type']}">购票</a></p>
`;
                        }
                        var tr_html = `<tr>
            <td>
                <h3 class="ui header">${name}</h3>
                <a>查看经停</a>
            </td>
            <td>
                <h4>${start}</h4>
                <h4>${end}</h4>
            </td>
            <td>
                <h4>${start_time}</h4>
                <h4>${end_time}</h4>
            </td>
            <td>
                <span>${run_time}</span>
            </td>
            <td>
                ${seat_class}
            </td>
            <td>
                ${button}
            </td>
        </tr>`;
                        tbody_html += tr_html;
                    }
                    alert(tbody_html);
                    $('tbody').html(tbody_html);
                }
            );
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
    <table class="ui fixed table" id="result-list">
        <thead>
        <tr><th>车次</th>
            <th>发站/到站</th>
            <th>发/到时间</th>
            <th>运行时间</th>
            <th>参考票价</th>
            <th>剩余票量</th>
            <th> </th>
        </tr></thead>
        <tbody>

        </tbody>
    </table>
<!--    <table class="ui fixed table">-->
<!--        <thead>-->
<!--        <tr><th>车次</th>-->
<!--            <th>发站/到站</th>-->
<!--            <th>发/到时间</th>-->
<!--            <th>运行时间</th>-->
<!--            <th>参考票价</th>-->
<!--            <th>剩余票量</th>-->
<!--            <th> </th>-->
<!--        </tr></thead>-->
<!--        <tbody>-->
<!--        <tr>-->
<!--            <td>-->
<!--                <h3 class="ui header">G4</h3>-->
<!--                <a>查看经停</a>-->
<!--            </td>-->
<!--            <td>-->
<!--                <h4>[始]北京南</h4>-->
<!--                <h4>[终]上海虹桥</h4>-->
<!--            </td>-->
<!--            <td>-->
<!--                <h4>07:00</h4>-->
<!--                <h4>11:55</h4>-->
<!--            </td>-->
<!--            <td>-->
<!--                <span>4小时55分</span>-->
<!--            </td>-->
<!--            <td>-->
<!--                <p>二等座<span style="color:red">￥553</span></p>-->
<!--                <p>一等座<span style="color:red">￥993</span></p>-->
<!--                <p>商务座<span style="color:red">￥1748</span></p>-->
<!--            </td>-->
<!--            <td>-->
<!--                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&二等座">购票</a></p>-->
<!--                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&一等座">购票</a></p>-->
<!--                <p><a href="javascript:void(0);" onclick="buy_ticket(this)" data-info="G4&北京南&上海虹桥&商务座">购票</a></p>-->
<!--            </td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->

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
