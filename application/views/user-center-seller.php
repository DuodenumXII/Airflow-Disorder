<script src="https://cdn.bootcss.com/wangEditor/3.0.8/wangEditor.min.js"></script>
<script>
    $(document).ready(function () {
        $('title').html('Airflow-Disorder | 个人中心');
        $('#user-icon').attr('src', $('#avatar').attr('src'));
        $('#huge-user-name').html($('#user-name').html());
        var E = window.wangEditor;
        var editor = new E('#commodity-introduction-editor');
        editor.customConfig.uploadImgShowBase64 = true;
        editor.create();
        $('#commodity-submit').click(function () {
            alert("传火");
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
            alert('传火');
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
</script>

<div class="ui basic modal" id="success-modal">
    <div class="ui icon header">
        <i class="checkmark icon"></i>
        已发起上架申请，等待管理员审批<br>
        <div class="msg"></div>
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
        <div class="ui vertical fluid menu">
            <a class="active teal item">
                商品上架
            </a>
            <a class="item">
                我的订单
                <div class="ui label" id="processed-num">0</div>
            </a>
            <a class="item">
                未完待续
                <div class="ui label" id="todo-num">0</div>
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
    </div>
</div>