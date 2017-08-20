<script>
    $(document).ready(function () {
        $('title').html('Airflow-Disorder | 个人中心');
        $('#user-icon').attr('src', $('#avatar').attr('src'));
        $('#huge-user-name').html($('#user-name').html());
        $.post(
            '/airflow.php/user/query/todo',
            JSON.stringify({'status': 0}),
            function (response) {
                console.log(response);
                if (!response.err_code) {
                    $.each(response.data.result, function (index, item) {
                        var cardHtml = `<div class="ui segment" data-id="${item.id}">
            <div class="ui bulleted list" id="order-info"">
                <div class="item">id: ${item.id}</div>
                <div class="item">类型: ${item.type}</div>
                <div class="item">状态: 待办</div>
                {detail}
                <div class="item">创建时间: ${item.create_time}</div>
            </div>
        </div>
        <div class="ui borderless operation menu" data-id="${item.id}">
            <a class="item" data-id="${item.id}" data-value="1" onclick="submitOperation(this)">同意</a>
            <a class="item" data-id="${item.id}" data-value="2" onclick="submitOperation(this)">拒绝</a>
            <a class="item" data-id="${item.id}" data-value="3" onclick="submitOperation(this)">忽略</a>
            <a class="item" data-id="${item.id}" data-value="4" onclick="submitOperation(this)">删除</a>
        </div>
`;
                        var detail = JSON.parse(item.detail);
                        var detailHtml = '';
                        $.each(detail, function (index, item) {
                            detailHtml += `<div class="item">${index}: ${item}</div>
                            `;
                        });
                        cardHtml = cardHtml.replace('{detail}', detailHtml);
                        $('#func-area').append(cardHtml);
                    });
                };
            }
        );
    });

    function submitOperation(e) {
        $.post(
            '/airflow.php/user/update/todo',
            JSON.stringify({
                'id': $(e).attr('data-id'),
                'status': $(e).attr('data-value')
            }),
            function (response) {
                console.log(response);
                if (response.data.result == true) {
                    console.log('审批成功');
                    console.log(`[data-id="${$(e).attr('data-id')}"]`);
                    $(`[data-id="${$(e).attr('data-id')}"]`).hide();
                } else {
                    console.log('审批失败，' + response.err_msg);
                    console.log(`[data-id="${$(e).attr('data-id')}"]`);
                    $(`[data-id="${$(e).attr('data-id')}"]`).hide();
                }
            }
        );
    }
</script>

<div class="ui grid divided container">
    <div class="ui four wide column">
        <img class="ui fluid image" src="" id="user-icon">
        <div class="ui huge header" id="huge-user-name"></div>
        <div class="ui vertical fluid menu">
            <a class="active teal item">
                待办事项
            </a>
            <a class="item">
                已处理
                <div class="ui label" id="processed-num">0</div>
            </a>
            <a class="item">
                未处理
                <div class="ui label" id="todo-num">0</div>
            </a>
        </div>
    </div>
    <div class="ui container twelve wide column" id="func-area">
        <h2 class="ui header">待办事项</h2>
    </div>
</div>
