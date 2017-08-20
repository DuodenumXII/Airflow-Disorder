<script>
    $(document).ready(function () {
        $('#user-icon').attr('src', $('#avatar').attr('src'));
        $('#huge-user-name').html($('#user-name').html());
    });
</script>

<div class="ui grid divided container">
    <div class="ui four wide column">
        <img class="ui fluid image" src="" id="user-icon">
        <div class="ui huge header" id="huge-user-name"></div>
        <div class="ui vertical fluid menu">
            <a class="active teal item">
                收件箱
                <div class="ui teal left pointing label">1</div>
            </a>
            <a class="item">
                垃圾箱
                <div class="ui label">51</div>
            </a>
            <a class="item">
                更新
                <div class="ui label">1</div>
            </a>
            <div class="item">
                <div class="ui transparent icon input">
                    <input type="text" placeholder="搜索邮件...">
                    <i class="search icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="ui container twelve wide column">
        <h2 class="ui header" id="func-area">Dogs Roles with Humans</h2>
        <p>Domestic dogs inherited complex behaviors, such as bite inhibition, from their wolf ancestors, which would have been pack hunters with complex body language. These sophisticated forms of social cognition and communication may account for their trainability, playfulness, and ability to fit into human households and social situations, and these attributes have given dogs a relationship with humans that has enabled them to become one of the most successful species on the planet today.

            The dogs' value to early human hunter-gatherers led to them quickly becoming ubiquitous across world cultures. Dogs perform many roles for people, such as hunting, herding, pulling loads, protection, assisting police and military, companionship, and, more recently, aiding handicapped individuals. This impact on human society has given them the nickname "man's best friend" in the Western world. In some cultures, however, dogs are also a source of meat.</p>
        <p></p>
    </div>
</div>
