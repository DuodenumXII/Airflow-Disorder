<script>
    $(document).ready(function(){
        $('title').html('Airflow-Disorder火车票查询');
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
                        button += `<p><a href="javascript:void(0);" onclick="buyTicket(this)" data-info="${name}&${start}&${end}&${temp['price_type']}&${temp['price']}&${start_time}&${end_time}">购票</a></p>
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
        var data = $(e).attr('data-info').split('&');
        var name, start, end, priceType, price, startTime, endTime;
        [name, start, end, priceType, price, startTime, endTime] = data;
        var date = $('[name="dep-time"]').val();
        $.post(
            '/airflow.php/user/create/order',
            JSON.stringify({
                'type': 'train',
                'seller': '25',
                'price': price,
                'detail': {
                    '席次': priceType,
                    '起始时间': `${date} ${startTime}-${endTime}`
                }
            }),
            function (response) {
                console.log(response);
                var listHtml = '';
                if (!response.err_code) {
                    listHtml = `<div class="item">订单号: ${response.data.result.order_id}</div>
<div class="item">类型: 火车票</div>
<div class="item">价格: ￥${response.data.result.price}</div>
<div class="item">状态: 未支付</div>
<div class="item">类型: 火车票</div>
`;
                    $.each(JSON.parse(response.data.result.detail), function (index, item) {
                        listHtml += `<div class="item">${index}: ${item}</div>
                                `;
                    });
                    $('#order-info').html(listHtml);
                    $('#order-modal')
                        .modal({
                            onApprove: function () {
                                $.post(
                                    '/airflow.php/user/pay/order',
                                    JSON.stringify({
                                        'money': response.data.result.price,
                                        'order_id': response.data.result.order_id
                                    }),
                                    function (response) {
                                        console.log(response);
                                        if (!response.err_code) {
                                            if (response.data.result == true) {
                                                $('#success-modal').modal('show');
                                            }
                                        } else {
                                            $('#error-modal .msg').html(response.err_msg);
                                            $('#error-modal').modal('show');
                                        }
                                    }
                                );
                            }
                        })
                        .modal('setting', 'closable', false)
                        .modal('show')
                    ;
                }
            }
        );

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

<div class="ui basic modal" id="order-modal">
    <div class="ui icon header">
        <i class="ui browser icon"></i>
        订单信息
    </div>
    <div class="content">
        <div class="ui container" style="border: 1px solid white; padding: 5%;">
            <div class="ui bulleted list" id="order-info">

            </div>
        </div>
        <div class="actions" style="padding-top: 50px">
            <div class="ui red basic cancel inverted right floated button">
                <i class="remove icon"></i>
                取消
            </div>
            <div class="ui green ok inverted right floated button">
                <i class="checkmark icon"></i>
                支付
            </div>
        </div>
    </div>
</div>

<div class="ui basic modal" id="success-modal">
    <div class="ui icon header">
        <i class="checkmark icon"></i>
        支付成功<br>
        <div class="msg"></div>
    </div>
</div>

<div class="ui basic modal" id="error-modal">
    <div class="ui icon header">
        <i class="warning sign icon"></i>
        支付失败<br>
        <div class="msg"></div>
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