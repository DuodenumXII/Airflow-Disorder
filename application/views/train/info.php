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
                '/airflow.php/user/query/trains2s',
                JSON.stringify({'start': '北京', 'end': '上海', 'date': '+2 day'}),
                function (response) {
                    updateInfoList(response);
                }
            );
            $('.ui.dropdown')
                .dropdown()
            ;
            $('[name$="time"]').val(getNowFormatDate());
            $('#exchange-btn').click(function () {
                exchange('[name="start"]', '[name="end"]');
            });
            $('#search-btn').click(function () {
                $('tbody').transition('slide down', '500ms');
                $.post(
                    '/airflow.php/user/query/trains2s',
                    JSON.stringify({
                        'start': $('[name="start"]').val(),
                        'end': $('[name="end"]').val(),
                        'date': $('[name="dep-time"]').val()
                    }),
                    function (response) {
                        updateInfoList(response);
                        //$('tbody').transition('slide down', '500ms');
                    }
                );
            });
        });

        function exchange(a, b) {
            var temp = $(b).val();
            $(b).val($(a).val());
            $(a).val(temp);
        }

        function getNowFormatDate() {
            var date = new Date();
            var seperator1 = "-";
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = year + seperator1 + month + seperator1 + strDate;
            return currentdate;
        }

        function updateInfoList(response) {
            console.log(response);
            if (response.data.reason == "查询成功") {
                var tbody_html = '';

                $.each(response.data.result.list, function (index, item) {
                    var name = item['train_no'];
                    var start = '[' + item['start_station_type'] + ']' + item['start_station'];
                    var end = '[' + item['end_station_type'] + ']' + item['end_station'];
                    var start_time = item['start_time'];
                    var end_time = item['end_time'];
                    var run_time = item['run_time'];
                    var price_list = item['price_list'];
                    var seat_class = '';
                    var button = '';
                    $.each(price_list, function (key, temp) {
                        {
                            seat_class += `<p>${temp['price_type']}<span style="color:red">￥${temp['price']}</span></p>
`;
                            button += `<p><a href="javascript:void(0);" onclick="buyTicket(this)" data-info="${name}&${start}&${end}&${temp['price_type']}&${temp['price']}">购票</a></p>
`;
                        }
                    });
                    var tr_html = `<tr>
            <td>
                <h3 class="ui header">${name}</h3>
                <a href="javascript:void(0);" name="query-info" data-name="${name}" onclick="queryTrainInfo(this)">查看经停</a>
                <div class="ui flowing popup bottom center hidden">
                    <table class="ui very basic table" id="${name}-info">
                        <thead>
                        <tr><th>站次</th>
                            <th>站名</th>
                            <th>到达时间</th>
                            <th>离开时间</th>
                        </tr></thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
                });
                var infoList = $('#info-list tbody');
                infoList.html(tbody_html);
                infoList.transition('slide down', '500ms');
                $('#main-loader').removeClass('active');
                $('[name="query-info"]')
                    .popup({
                        on: 'click',
                        position: 'bottom center',
                        lastResort: 'botto'
                    })
                ;
                return;
            }
            alert('加载列车信息失败，请检查查询条件后重试');
        }

        function buyTicket(e) {
            var data = e.getAttribute('data-info').split('&');
            alert(data);
            return false;
        }

        function queryTrainInfo(e) {
            var name = e.getAttribute('data-name');
            var tbody_html = '';
            $.post(
                '/airflow.php/user/query/traininfo',
                JSON.stringify({'name': name}),
                function (response) {
                    console.log(response);
                    if (response.data.resultcode == '200') {
                        $.each(response.data.result.station_list, function (index, item) {
                            var tr_html = `
                        <tr>
                            <td>${item['train_id']}</td>
                            <td>${item['station_name']}</td>
                            <td>${item['arrived_time']}</td>
                            <td>${item['leave_time']}</td>
                        </tr>`;
                            tbody_html += tr_html;
                        });
                    }
                    console.log(`#${name}-info`);
                    $(`#${name}-info tbody`).html(tbody_html);
                }
            );
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
    <div class="ui form">
        <div class="inline fields">
            <div class="field">
                <select class="ui dropdown" id="search-type" name="search-type">
                    <option value="0">站站搜索</option>
                    <option value="1">车次搜索</option>
                </select>
            </div>
            <div class="field">
                <div class="ui labeled purple input">
                    <div class="ui label">出发</div>
                    <input type="text" name="start" placeholder="北京">
                </div>
            </div>
            <div class="field">
                <div class="ui icon basic button" id="exchange-btn">
                    <i class="ui icon exchange"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui labeled input">
                    <div class="ui label">到达</div>
                    <input type="text" name="end" placeholder="上海">
                </div>
            </div>
            <div class="field">
                <div class="ui icon labeled input">
                    <div class="ui label">日期</div>
                    <input type="date" name="dep-time">
                    <i class="ui icon calendar"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui primary button" id="search-btn">
                    立即查询
                </div>
            </div>
        </div>
    </div>
    <table class="ui fixed table" id="info-list">
        <thead>
        <tr><th>车次</th>
            <th>发站/到站</th>
            <th>发/到时间</th>
            <th>运行时间</th>
            <th>参考票价</th>
            <th>操作</th>
        </tr></thead>
        <tbody style="display: none">
        <div class="ui active inverted dimmer" id="main-loader">
            <div class="ui text loader">加载</div>
        </div>
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
