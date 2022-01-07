<?=$render('header', ['loggedUser' => $loggedUser]);?>
<section class="container main">
    <?=$render('sidebar', ['activeMenu' => 'config']);?>
    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">
                <h1>Configurações</h1>
                <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>
                <?php endif; ?>
                <br/><br/>
                <form method="POST" class="form-config" action="<?=$base;?>/config" enctype="multipart/form-data">
                    <label for="avatar">Novo Avatar:</label><br>
                    <img class="image-edit" src="<?=$base?>/media/avatars/<?=$user->avatar;?>" alt="Foto de Perfil">
                    <br/>
                    <input type="file" name="avatar" id="avatar" />
                    <br/><br/>
                    <label for="cover">Nova Capa:</label>
                    <br/>
                    <input type="file" name="cover" id="cover" /><br>
                    <img class="image-edit" src="<?=$base?>/media/covers/<?=$user->cover;?>" alt="Foto de Capa">
                    <br/><br/>
                    <hr />
                    <br/>
                    <label for="name">Nome Completo:</label>
                    <br/>
                    <input type="text" name="name" id="name" />
                    <br/><br/>
                    <label for="birthdate">Data de nascimento:</label>
                    <br/>
                    <input type="text" name="birthdate" id="birthdate" maxlength="10" />
                    <br/><br/>
                    <label for="email">E-mail:</label>
                    <br/>
                    <input type="email" name="email" id="email" />
                    <br/><br/>
                    <label for="city">Cidade:</label>
                    <br/>
                    <input type="text" name="city" id="city" />
                    <br/><br/>
                    <label for="work">Trabalho:</label>
                    <br/>
                    <input type="text" name="work" id="work" />
                    <br/><br/>
                    <hr />
                    <br/>
                    <label for="password">Nova Senha:</label>
                    <br/>
                    <input type="password" name="password" id="password" />
                    <br/><br/>
                    <label for="password-conf">Confirmar Senha:</label>
                    <br/>
                    <input type="password" name="password-conf" id="password-conf" />
                    <br/><br/>
                    <button class="button" type="submit">Salvar</button>
                </form>
                
            </div>
            <div class="column side pl-5">
                <?=$render('right-side');?>
            </div>
        </div>
    </section>
</section>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById('birthdate'),
        {
            mask: '00/00/0000'
        }
    );
</script>
<?=$render('footer');?>