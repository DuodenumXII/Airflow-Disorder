<script>
    $(document).ready(function () {
        if (sessionStorage.getItem('hotel')) {
            var commodity = JSON.parse(sessionStorage.getItem('hotel'));
            updateInfoList(commodity.city);
            sessionStorage.removeItem('hotel');
        }
        $('#search-btn').click(function () {
            $('#result-items').html('');
            updateInfoList($('#search-form [name="end"]').val());
        });
    });

    function updateInfoList(city) {
        $.post(
            '/airflow.php/user/query/commodity',
            JSON.stringify({
                'type': 'hotel',
                'city': city
            }),
            function (response) {
                console.log(response);
                if (!response.err_code) {
                    $.each(response.data.result, function (index, item) {
                        var cardHtml = `<div class="item">
            <div class="image">
                <img src="${item.title_image}">
            </div>
            <div class="content">
                <a class="header">${item.name}</a>
                <div class="meta">
                    <span>${item.subtitle}</span>
                </div>
                <div class="description">
                    <p>￥${item.price}</p>
                </div>
                <div class="extra">
                    <div class="ui right floated primary button" data-id="${item.commodity_id}" onclick="queryCommodityInfo(this)">查看详情</div>
                </div>
            </div>
        </div>`;
                        $('#result-items').append(cardHtml);
                    });
                }
            }
        );
    }

    function queryCommodityInfo(e) {
        location.href = "/airflow.php/hotel/info?id=" + $(e).attr('data-id');
    }
</script>

<div class="ui grid container" style="margin-bottom: 30px">
    <div class="ui sixteen wide column form" id="search-form" style="margin-top: 20px">
        <div class="inline fields">
            <div class="field">
                <div class="ui labeled purple input">
                    <div class="ui label">出发</div>
                    <input type="text" name="start" placeholder="北京">
                </div>
            </div>
            <div class="field">
                <div class="ui labeled input">
                    <div class="ui label">目的地</div>
                    <input type="text" name="end" placeholder="上海">
                </div>
            </div>
            <div class="field">
                <div class="ui primary button" id="search-btn">
                    立即查询
                </div>
            </div>
        </div>
    </div>
    <div class="ui items" id="result-items">

    </div>
</div>