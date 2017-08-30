<script src="https://cdn.bootcss.com/wangEditor/3.0.8/wangEditor.min.js"></script>
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
        var E = window.wangEditor;
        var editor = new E('#commodity-introduction-editor');
        editor.customConfig.uploadImgShowBase64 = true;
        editor.create();
        $('#commodity-submit').click(function () {
            $.post(
                '/airflow.php/user/create/commodity',
                JSON.stringify({
                    'type': $('input[name="commodity-type"]:checked').val(),
                    'name': $('#commodity-title').val(),
                    'subtitle': $('#commodity-subtitle').val(),
                    'city': $('#commodity-city').val(),
                    'price': $('#commodity-price').val(),
                    'title_image': $('#commodity-title-image-base64').val(),
                    'introduction': editor.txt.html(),
                    'detail': {}
                }),
                function (response) {
                    console.log(response);
                    if (!response.err_code) {
                        $('#success-modal').modal('show');
                    } else {
                        $('#error-modal .msg').html(response.err_msg);
                        $('#error-modal').modal('show');
                    }
                }
            );
        });
    });
    
    function uploadTitleImage() {
        var img = event.target.files[0];
        if(!img){
            return ;
        }
        if(!(img.type.indexOf('image')==0 && img.type && /\.(?:jpg|png|gif)$/.test(img.name)) ){
            alert('图片只能是jpg,gif,png');
            return ;
        }
        var reader = new FileReader();
        reader.readAsDataURL(img);
        reader.onload = function(e){ // reader onload start
            $('#commodity-title-image-base64').val(e.target.result);
            $('#commodity-title-image-preview').attr('src', e.target.result);
        };
    }

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

<div class="ui basic modal" id="success-modal">
    <div class="ui icon header">
        <i class="checkmark icon"></i>
        <div class="msg">已发起上架申请，等待管理员审批<br></div>
    </div>
</div>

<div class="ui basic modal" id="error-modal">
    <div class="ui icon header">
        <i class="warning sign icon"></i>
        发起申请失败<br>
        <div class="msg"></div>
    </div>
</div>

<div class="ui grid divided container">
    <div class="ui four wide column">
        <img class="ui fluid image" src="" id="user-icon">
        <div class="ui huge header" id="huge-user-name"></div>
        <div class="ui secondary fluid vertical pointing menu">
            <a class="active item" data-func="upload-commodity">
                商品上架
            </a>
            <a class="item" data-func="my-order" onclick="updateMyOrder()">
                我的订单
            </a>
        </div>
    </div>
    <div class="ui container twelve wide column" id="func-area" style="padding: 3%">
        <div id="upload-commodity">
            <h2 class="ui header">
                商品上架
            </h2>
            <form class="ui form" id="upload-commodity-form">
                <div class="inline fields">
                    <label>商品类型</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="commodity-type" tabindex="0" value="hotel">
                            <label>酒店</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="commodity-type" tabindex="0" value="commodity" checked="checked">
                            <label>其它</label>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>大标题</label>
                    <textarea id="commodity-title" rows="2"></textarea>
                </div>
                <div class="field">
                    <label>副标题</label>
                    <textarea id="commodity-subtitle" rows="2"></textarea>
                </div>
                <div class="field">
                    <label>城市</label>
                    <input type="text" id="commodity-city">
                </div>
                <div class="field">
                    <label>价格</label>
                    <input type="number" id="commodity-price">
                </div>
                <div class="field">
                    <label>封面图片</label>
                    <input class="ui button" type="file" id="commodity-title-image" onchange="uploadTitleImage()" accept="image/*">
                    <input type="hidden" id="commodity-title-image-base64">
                    <img class="ui fluid image" src="" id="commodity-title-image-preview">
                </div>
                <div class="field">
                    <label>详细介绍</label>
                    <div id="commodity-introduction-editor"></div>
                    <br>
                    <p style="color:grey; float: right">Powered by WangEditor</p>
                </div>
                <div class="field">
                    <div class="ui green basic button" id="commodity-submit">提交上架申请</div>
                </div>
            </form>
        </div>
        <div id="my-order" style="display: none">
            <h2 class="ui header">
                我的订单
            </h2>
        </div>
    </div>
</div>