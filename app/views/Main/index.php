<div class="container">
    <button class="btn-default" id="send">Кнопка</button>
    <?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?= $post['title'] ?></div>
            <div class="panel-body">
                <?= $post['text'] ?>
            </div>
        </div>
    <?php endforeach ?>
    <?php endif ?>
</div>
<script src="/js/test.js"></script>
<script>
    $(function() {
        $('#send').click(function(){
            $.ajax({
                url: '/main/test',
                type: 'POST',
                data: {'id': 2},
                success: function(res){
                    console.log(res)
                },
                error: function(){
                    alert('Error!');
                }
            });
        });
    });
</script>