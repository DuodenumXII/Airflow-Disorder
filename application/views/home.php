<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Homepage - Semantic</title>
    <link rel="stylesheet" type="text/css" href="../../semantic/dist/semantic.min.css">
    <script src="../../semantic/dist/jquery-3.2.1.min.js"></script>
    <script src="../../semantic/dist/semantic.min.css"></script>
    <script>
        $(document)
            .ready(function() {
                $.tab();
            });
    </script>
</head>
<body>

<div class="ui inverted purple borderless menu">
    <div class="ui container">
        <a class="active item">首页</a>
        <a class="item">机票</a>
        <a class="item">酒店</a>
        <a class="item">火车票</a>
        <div class="right item">
            <div class="ui icon input">
                <i class="search icon"></i>
                <input type="text" placeholder="搜索">
            </div>
            <a class="ui item">登录</a>
            <a class="ui item">注册</a>
        </div>
    </div>
</div>

<div class="ui container">
    <div class="ui top attached tabular menu">
        <div class="active item" data-tab="plane">机票</div>
        <div class="item" data-tab="hotel">酒店</div>
        <div class="item" data-tab="train">火车票</div>
    </div>
    <div class="ui bottom attached active tab segment" data-tab="plane">
        <div class="ui top attached tabular menu">
            <div class="active item" data-tab="local-plane">国内机票</div>
            <div class="item" data-tab="foreign-plane">国际/港澳台机票</div>
        </div>
        <div class="ui bottom attached active tab segment" data-tab="local-plane">
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
                                <input type="text" name="departure" placeholder="北京">
                            </div>
                        </div>
                        <br>
                        <div class="field">
                            <div class="ui labeled input">
                                <div class="ui label">到达</div>
                                <input type="text" name="arrival" placeholder="上海">
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
        <div class="ui bottom attached tab segment" data-tab="foreign-plane">
            国际/港澳台机票
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="hotel">
        酒店
    </div>
    <div class="ui bottom attached tab segment" data-tab="train">
        火车票
    </div>
</div>


<div class="ui inverted purple vertical footer segment">
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
