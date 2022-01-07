<div class="box feed-item" data-id="<?= $data->id; ?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?= $base ?>/perfil/<?= $data->user->id ?>"><img src="<?= $base; ?>/media/avatars/<?= $data->user->avatar; ?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?= $base ?>/perfil/<?= $data->user->id ?>"><span class="fidi-name"><?= $data->user->nome; ?></span></a>
                <span class="fidi-action">
                    <?php
                    switch ($data->type) {
                        case 'text':
                            echo 'Fez um post';
                            break;
                        case 'foto':
                            echo 'Postou uma foto';
                            break;
                    }

                    ?>
                </span>
                <br />
                <span class="fidi-date"><?php $agora = new DateTime($data->created_at);
                                        echo $agora->format('d/m/Y H:i:s')  ?></span>
            </div>
            <?php if($data->mine): ?>
            <div class="feed-item-head-btn">
                <img src="<?= $base; ?>/assets/images/more.png" />
                <div class="feed-item-more-window">
                    <a href="<?=$base;?>/post/<?=$data->id;?>/delete" onclick="return confirm('Tem certeza que deseja excluir o post??')">Excluir Post</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?php switch ($data->type) {
                case 'text':
                    nl2br($data->body);
                    break;

                case 'photo':
                    echo '<img src="' . $base . '/media/uploads/' . $data->body . '">';
                    break;
            } ?>

        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= ($data->liked ? 'on' : '')  ?>"><?= $data->likeCount; ?></div>
            <div class="msg-btn"><?php echo count($data->comments); ?></div>
        </div>
        <div class="feed-item-comments">

            <div class="feed-item-comments-area">
                <?php foreach ($data->comments as $item) : ?>

                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href="<?= $base ?>/perfil/<?= $item['user']['id'] ?>"><img src="<?= $base; ?>/media/avatars/<?= $item['user']['avatar'] ?>" /></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?= $base ?>/perfil/<?= $item['user']['id'] ?>"><?= $item['user']['nome']; ?></a>
                            <?= $item['body']; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>




            <style>
                .fic-btn {
                    width: 45px;
                    height: 36px;
                    padding: 5px;
                    cursor: pointer;
                    border: 1px solid grey;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 50%;
                    margin-left: 10px;
                    background-color: #ddd;
                }

                .fic-btn span {
                    cursor: pointer;
                }
            </style>
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?= $base ?>/perfil/<?= $data->user->id ?>"><img src="<?= $base; ?>/media/avatars/<?= $loggedUser->avatar; ?>" /></a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />

                <div class="fic-btn" id="btn_comment"> <span>Enviar</span> </div>
            </div>
        </div>
    </div>
</div>