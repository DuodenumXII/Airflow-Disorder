<script>
    $(document).ready(function () {
        $('title').html('Airflow-Disorder | 个人中心');
        $('#user-icon').attr('src', $('#avatar').attr('src'));
        $('#huge-user-name').html($('#user-name').html());
        $('.ui.menu')
            .on('click', '.item', function() {
                if(!$(this).hasClass('dropdown')) {
                    $(this)
                        .addClass('active')
                        .siblings('.item')
                        .removeClass('active');
                }
                var func = $(this).attr('data-func');
                $('#' + func)
                    .show()
                    .siblings('div')
                    .hide();
            })
        ;
    });

    function updateMyOrder() {
        $.post(
            '/airflow.php/user/query/order',
            {},
            function (response) {
                console.log(response);
                if (!response.err_code) {
                    $.each(response.data.result, function (index, item) {
                        var statusList = ['未支付', '已支付', '已取消'];
                        var cardHtml = `<div class="ui segment" data-id="${item.order_id}">
            <div class="ui bulleted list" id="order-info"">
                <div class="item">订单id: ${item.order_id}</div>
                <div class="item">类型: ${item.type}</div>
                <div class="item">状态: ${statusList[parseInt(item.status)]}</div>
                <div class="item">价格: ￥${item.price}</div>
                {detail}
                <div class="item">创建时间: ${item.create_time}</div>
            </div>
        </div>`;
                        if (item.status == 0) {
                            cardHtml +=  `<div class="ui purple inverted borderless operation menu" data-id="${item.order_id}">
            <a class="item" data-id="${item.order_id}" data-value="1" onclick="payOrder(this)">支付</a>
            <a class="item" data-id="${item.order_id}" data-value="2" onclick="payOrder(this)">取消订单</a>
        </div>`;
                        }

                        var detail = JSON.parse(item.detail);
                        var detailHtml = '';
                        $.each(detail, function (index, item) {
                            detailHtml += `<div class="item">${index}: ${item}</div>
                            `;
                        });
                        cardHtml = cardHtml.replace('{detail}', detailHtml);
                        $('#my-order').append(cardHtml);
                    });
                }
            }
        )
    }

    function payOrder(e) {
        var value = $(e).attr('data-value');
        if (value == "1") {
            $('#pay-modal')
                .modal({
                    onApprove: function () {
                        $.post(
                            '/airflow.php/user/update/order',
                            JSON.stringify({
                                'money': 0,
                                'order_id': $(e).attr('data-id'),
                                'status': 1
                            }),
                            function (response) {
                                console.log(response);
                                if (!response.err_code) {
                                    alert('支付成功');
                                    $(`#my-order [data-id="${$(e).attr('data-id')}"]`).hide();
                                } else {
                                    alert('支付失败 ' + response.err_msg);
                                }
                            }
                        )
                    }
                })
                .modal('show')
            ;
        } else {
            $.post(
                '/airflow.php/user/update/order',
                JSON.stringify({
                    'money': 0,
                    'order_id': $(e).attr('data-id'),
                    'status': 2
                }),
                function (response) {
                    console.log(response);
                    if (!response.err_code) {
                        alert('取消成功');
                        $(`#my-order [data-id="${$(e).attr('data-id')}"]`).hide();
                    } else {
                        alert('取消失败 ' + response.err_msg);
                    }
                }
            )
        }
    }
</script>

<div class="ui grid divided container">
    <div class="ui four wide column">
        <img class="ui fluid image" src="" id="user-icon">
        <div class="ui huge header" id="huge-user-name"></div>
        <div class="ui secondary fluid vertical pointing menu">
            <a class="active item" data-func="my-order" onclick="updateMyOrder()">
                我的订单
            </a>
        </div>
    </div>
    <div class="ui container twelve wide column" id="func-area" style="padding: 3%">
        <div id="my-order">
            <h2 class="ui header">
                我的订单
            </h2>
        </div>
    </div>
</div>