<div class="row no-gutters">
    <div class="col-lg-6 d-none d-lg-block">
        <img src="imagens/flyers/spex-unidade.jpg" class="card-img" alt="..." width="100%" height="100%">
    </div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <img src="../../statics/img/logo-pp.png" alt="" width="100" height="100">
                <h1 class="h4 text-gray-900">Plantão Extraordinário</h1>
                <h5 class="h6 mb-3 font-weight-nornal mb-4">Acesso do Servidor</h5>
            </div>

            <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>

            <form class="user" method="POST" action="../../registro/valida.php">
                <div class="form-group">
                    <label for="usuario">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="usuario" aria-describedby="cpfHelp"
                        placeholder="___.___.___-__" autofocus required>
                    <!-- <small id="cpfHelp" class="form-text text-muted">Utilize seu cpf para acessar.</small> -->
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" aria-describedby="senhaHelp"
                        placeholder="Digite a senha" required>
                    <!-- <small id="cpfHelp" class="form-text text-muted">Utilize seu cpf para acessar.</small> -->
                </div>
                <div class="form-group">
                    <label for="captcha">Captcha:</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-0">
                                <img src="captcha.php" alt="captcha" class="captcha-img">
                            </span>
                        </div>
                        <input type="text" class="form-control" maxlength="8" name="captcha"
                            placeholder="Digite o captcha" required>
                    </div>
                    <!-- <small id="cpfHelp" class="form-text text-muted">Utilize seu cpf para acessar.</small> -->
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Manter-me conectado</label>
                    </div>
                </div>
                <button class="btn btn-dark btn-block" type="submit">Entrar</button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small  w-100 text-dark" href="../../register.php">Primeiro
                    acesso? Clique aqui para criar ou redefinir sua senha.</a>
            </div>
        </div>
    </div>
</div>