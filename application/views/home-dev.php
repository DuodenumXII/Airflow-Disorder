<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="../../semantic/dist/semantic.css">

    <script src="../../semantic/dist/jquery-3.2.1.min.js"></script>
    <script src="../../semantic/dist/semantic.js"></script>
    <script>
        $(document).ready(function(){
            $('.menu .item').tab();
            $('[name$="time"]').val(getNowFormatDate());
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
    </script>
</head>
<body>

<!-- Following Menu -->
<div class="ui purple inverted borderless menu">
    <div class="ui container">
        <a class="active item">首页</a>
        <a class="item">机票</a>
        <a class="item">酒店</a>
        <a class="item">火车票</a>
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
    <div class="ui purple inverted segment">

        <div class="ui top attached purple inverted tabular menu">
            <a class="active item" data-tab="plane">机票</a>
            <a class="item" data-tab="hotel">酒店</a>
            <a class="item" data-tab="train">火车票</a>
            <a class="item" data-tab="travel">旅行</a>
        </div>
        <div class="ui active bottom attached tab segment" data-tab="plane">
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="plane/local">国内机票</a>
                <a class="item" data-tab="plane/foreign">国际/港澳台机票</a>
            </div>

            <!--        国内机票-->

            <div class="ui bottom attached active tab segment" data-tab="plane/local">
                <form class="ui form">
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-no" checked="checked">
                                <label for="return-no">单程</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-yes">
                                <label for="return-yes">往返</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <div class="field">
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">出发</div>
                                    <input type="text" name="start" placeholder="北京">
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">到达</div>
                                    <input type="text" name="end" placeholder="上海">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui icon basic button">
                                <i class="ui icon exchange"></i>
                            </div>
                        </div>
                        <div class="wide field">

                        </div>
                        <div class="field">
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    220,000
                                </div>
                                <div class="label">
                                    条航线可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!--        国际/港澳台机票-->

            <div class="ui bottom attached tab segment" data-tab="plane/foreign">
                <form class="ui form">
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-no" checked="checked">
                                <label for="return-no">单程</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-yes">
                                <label for="return-yes">往返</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <div class="field">
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">出发</div>
                                    <input type="text" name="start" placeholder="香港">
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">到达</div>
                                    <input type="text" name="end" placeholder="纽约">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui icon basic button">
                                <i class="ui icon exchange"></i>
                            </div>
                        </div>
                        <div class="wide field">

                        </div>
                        <div class="field">
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    220,000
                                </div>
                                <div class="label">
                                    条航线可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="ui bottom attached tab segment" data-tab="hotel">
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="hotel/search">酒店搜索</a>
                <a class="item" data-tab="hotel/inn">客栈民宿</a>
                <a class="item" data-tab="hotel/hign-end">高端酒店</a>
            </div>

            <!--        酒店搜索-->

            <div class="ui bottom attached active tab segment" data-tab="hotel/search">
                <form class="ui form">
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="local" id="local-yes" checked="checked">
                                <label for="local-yes">国内酒店</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="local" id="local-no">
                                <label for="local-no">国际/港澳台酒店</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <div class="four wide field">
                            <div class="ui labeled input">
                                <div class="ui label">目的地</div>
                                <input type="text" name="city" placeholder="北京">
                            </div>
                        </div>

                        <div class="six wide field">
                            <div class="ui input">
                                <input type="text" name="hotel-name" placeholder="酒店名称">
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">入住日期</div>
                                <input type="date" name="check-in-date">
                            </div>
                        </div>

                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">离店日期</div>
                                <input type="date" name="check-out-date">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    730,000
                                </div>
                                <div class="label">
                                    家酒店可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--        客栈民宿-->
            <div class="ui bottom attached tab segment" data-tab="hotel/inn">
                <form class="ui form">
                    <br>
                    <div class="inline fields">
                        <div class="four wide field">
                            <div class="ui labeled input">
                                <div class="ui label">目的地</div>
                                <input type="text" name="city" placeholder="北京">
                            </div>
                        </div>

                        <div class="six wide field">
                            <div class="ui input">
                                <input type="text" name="hotel-name" placeholder="酒店名称">
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">入住日期</div>
                                <input type="date" name="check-in-date">
                            </div>
                        </div>

                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">离店日期</div>
                                <input type="date" name="check-out-date">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    730,000
                                </div>
                                <div class="label">
                                    家酒店可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--        高端酒店-->
            <div class="ui bottom attached tab segment" data-tab="hotel/hign-end">
                <form class="ui form">
                    <br>
                    <div class="inline fields">
                        <div class="four wide field">
                            <div class="ui labeled input">
                                <div class="ui label">目的地</div>
                                <input type="text" name="city" placeholder="北京">
                            </div>
                        </div>

                        <div class="six wide field">
                            <div class="ui input">
                                <input type="text" name="hotel-name" placeholder="酒店名称">
                            </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">入住日期</div>
                                <input type="date" name="check-in-date">
                            </div>
                        </div>

                        <div class="five wide field">
                            <div class="ui labeled input">
                                <div class="ui label">离店日期</div>
                                <input type="date" name="check-out-date">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    730,000
                                </div>
                                <div class="label">
                                    家酒店可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="ui bottom attached tab segment" data-tab="train">
            <div class="ui top attached tabular menu">
                <a class="active item" data-tab="train/s2s">站站搜索</a>
                <a class="item" data-tab="train/name">车次搜索</a>
            </div>

            <!--        站站搜索-->

            <div class="ui bottom attached tab segment" data-tab="train/s2s">
                <form class="ui form" id="train-s2s-form" action="/index.php/train/info" method="post">
                    <div class="inline fields">
                        <div class="field">
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">出发</div>
                                    <input type="text" name="start" id="train-start" placeholder="北京">
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">到达</div>
                                    <input type="text" name="end" id="train-end" placeholder="上海">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui icon basic button" onclick="exchange('#train-start', '#train-end')">
                                <i class="ui icon exchange"></i>
                            </div>
                        </div>
                        <div class="wide field">

                        </div>
                        <div class="field">
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time" id="train-date">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    2,448
                                </div>
                                <div class="label">
                                    个车站可供查询
                                </div>
                            </div>
                        </div>
                        <div class="five wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button" onclick="submit_form('#train-s2s-form')">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!--        车次搜索-->

            <div class="ui bottom attached tab segment" data-tab="train/name">
                <form class="ui form">
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-no" checked="checked">
                                <label for="return-no">单程</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="return" id="return-yes">
                                <label for="return-yes">往返</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <div class="field">
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">出发</div>
                                    <input type="text" name="start" placeholder="香港">
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">到达</div>
                                    <input type="text" name="end" placeholder="纽约">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui icon basic button">
                                <i class="ui icon exchange"></i>
                            </div>
                        </div>
                        <div class="wide field">

                        </div>
                        <div class="field">
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                            <br>
                            <div class="field">
                                <div class="ui icon labeled input">
                                    <div class="ui label">日期</div>
                                    <input type="date" name="dep-time">
                                    <i class="ui icon calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui horizontal statistic">
                                <div class="value">
                                    220,000
                                </div>
                                <div class="label">
                                    条航线可供查询
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">

                        </div>
                        <div class="field">
                            <div class="ui primary button">
                                立即查询
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="ui bottom attached tab segment" data-tab="travel">
            <form class="ui form">
                <br>
                <div class="inline fields">
                    <div class="four wide field">
                        <div class="ui labeled input">
                            <div class="ui label">出发</div>
                            <input type="text" name="start" placeholder="北京">
                        </div>
                    </div>

                    <div class="six wide field">
                        <div class="ui input">
                            <input type="text" name="destination" placeholder="目的地">
                        </div>
                    </div>
                </div>

                <br>
                <div class="inline fields">
                    <div class="field">
                        <div class="ui horizontal statistic">
                            <div class="value">
                                1,350,713
                            </div>
                            <div class="label">
                                条旅游路线
                            </div>
                        </div>
                    </div>
                    <div class="four wide field">

                    </div>
                    <div class="field">
                        <div class="ui primary button">
                            立即查询
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
