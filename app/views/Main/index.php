<div class="container">
    <div id="answer"></div>
    <button class="btn-default" id="send">Кнопка</button>
    <br>
    <?php new \fw\widgets\menu\Menu([
            'tpl'       => WWW.'/menu/select.php',
            'container' => 'select',
            'class'     => 'my_select',
            'table'     => 'categories',
            'cache'     => 60,
    ]) ?>
    <?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?= $post['title'] ?></div>
            <div class="panel-body">
                <?= $post['text'] ?>
            </div>
        </div>
    <?php endforeach ?>
    <div class="text-center">
        <p>Статей: <?= count($posts) ?> из <?= $total ?></p>
        <?php if ($pagination->countPages > 1): ?>
        <?= $pagination ?>
        <?php endif ?>
    </div>
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
                    $('#answer').html(res);
                },
                error: function(){
                    alert('Error!');
                }
            });
        });
    });
</script>