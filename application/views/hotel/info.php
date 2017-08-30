<script>
    $(document).ready(function () {
        $.post(
            '/airflow.php/user/query/commodity',
            JSON.stringify({
                'commodity_id': location.href.split('?')[1].split('=')[1]
            }),
            function (response) {
                console.log(response);
                $.each(response.data.result, function (index, item) {
                    $('#commodity-title').html(item.name);
                    $('#commodity-subtitle').html(item.subtitle);
                    $('#commodity-title-image').attr('src', item.title_image);
                    $('#commodity-price').html(item.price);
                    $('#commodity-introduction').html(item.introduction);
                    return;
                });
            }
        );
    });

    function buyCommodity() {
        var id = location.href.split('?')[1].split('=')[1];
        console.log($('#commodity-price').val());
        $.post(
            '/airflow.php/user/create/order',
            JSON.stringify({
                'type': 'hotel',
                'seller': 25,
                'price': $('#commodity-price').html(),
                'detail': {
                    'name': $('#commodity-title').html()
                }
            }),
            function (response) {
                console.log(response);
                var listHtml = '';
                if (!response.err_code) {
                    listHtml = `<div class="item">订单号: ${response.data.result.order_id}</div>
<div class="item">类型: 酒店</div>`;
                    $.each(JSON.parse(response.data.result.detail), function (index, item) {
                        listHtml += `<div class="item">${index}: ${item}</div>
                                `;
                    });
                    listHtml += `
<div class="item">价格: ￥${response.data.result.price}</div>
<div class="item">状态: 未支付</div>
`;
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
        )
    }
</script>

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

<div class="ui grid container" style="margin-top: 30px">
    <div class="eight wide column">
        <img class="ui fluid image" id="commodity-title-image" src="">
    </div>
    <div class="eight wide column">
        <h1 class="ui header">
            <div id="commodity-title"></div>
            <div class="sub header" id="commodity-subtitle"></div>
        </h1>
        <div class="ui purple segment">
            <h1 class="ui header" style="display: inline; color: #ff4000;">
                ￥<span id="commodity-price"></span>
            </h1>
            起/人
            <p style="margin-top: 20px; color: grey">
                Airflow Disorder暂时只是一个展示用网站，并不提供真实消费功能，价格仅为示意，不代表当前市场上的真实价格。
                如果内容上与真实情况出现较大偏差，请忽视就好。<br><br>但是如果这种偏差引起了你的强烈不适，请
                <a href="http://www.sbnk.cn/" target="_blank">点击这里</a>。
            </p>
        </div>
        <div class="ui positive basic huge right floated button" id="commodity-buy" onclick="buyCommodity()">立即购买</div>
    </div>

    <div class="ui sixteen wide column segment" id="commodity-introduction">

    </div>

    <div class="ui sixteen wide column minimal comments" id="comments">
        <h3 class="ui dividing header">Comments</h3>
        <div class="comment">
            <a class="avatar">
                <img src="http://7xoydz.com1.z0.glb.clouddn.com/%E5%A4%B4%E5%83%8F%201.png">
            </a>
            <div class="content">
                <a class="author">Matt</a>
                <div class="metadata">
                    <span class="date">Today at 5:42PM</span>
                </div>
                <div class="text">
                    How artistic!
                </div>
                <div class="actions">
                    <a class="reply">Reply</a>
                </div>
            </div>
        </div>
        <div class="comment">
            <a class="avatar">
                <img src="http://7xoydz.com1.z0.glb.clouddn.com/%E5%A4%B4%E5%83%8F%201.png">
            </a>
            <div class="content">
                <a class="author">Elliot Fu</a>
                <div class="metadata">
                    <span class="date">Yesterday at 12:30AM</span>
                </div>
                <div class="text">
                    <p>This has been very useful for my research. Thanks as well!</p>
                </div>
                <div class="actions">
                    <a class="reply">Reply</a>
                </div>
            </div>
            <div class="comments">
                <div class="comment">
                    <a class="avatar">
                        <img src="http://7xoydz.com1.z0.glb.clouddn.com/%E5%A4%B4%E5%83%8F%201.png">
                    </a>
                    <div class="content">
                        <a class="author">Jenny Hess</a>
                        <div class="metadata">
                            <span class="date">Just now</span>
                        </div>
                        <div class="text">
                            Elliot you are always so right :)
                        </div>
                        <div class="actions">
                            <a class="reply">Reply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comment">
            <a class="avatar">
                <img src="http://7xoydz.com1.z0.glb.clouddn.com/%E5%A4%B4%E5%83%8F%201.png">
            </a>
            <div class="content">
                <a class="author">Joe Henderson</a>
                <div class="metadata">
                    <span class="date">5 days ago</span>
                </div>
                <div class="text">
                    Dude, this is awesome. Thanks so much
                </div>
                <div class="actions">
                    <a class="reply">Reply</a>
                </div>
            </div>
        </div>
        <form class="ui reply form">
            <div class="field">
                <textarea></textarea>
            </div>
            <div class="ui blue labeled submit icon button">
                <i class="icon edit"></i> Add Reply
            </div>
        </form>
    </div>
</div>
