<div class="row no-gutters">
    <div class="col-lg-6 d-none d-lg-block">
        <img src="../../statics/img/spex-coletes.jpeg" class="card-img" alt="..." width="100%" height="100%">
    </div>
    <div class="col-lg-6 overflow-auto" style="max-height: 668.98px;">
        <div class="p-5">
            <div class="text-center">
                <img src="../../statics/img/logo-pp.png" alt="" width="100" height="100">
                <h1 class="h4 text-gray-900">Plantão Extraordinário</h1>
                <h5 class="h6 mb-3 font-weight-nornal mb-4">Primeiro Acesso</h5>
            </div>

            <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>

            <form class="user" method="POST" action="../../registro/primeiro.php">
                <div class="form-group ">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" placeholder="Digite o nome completo" required autofocus
                        name="nome" id="nome" onkeyup="maiuscula(this)">
                </div>

                <div class="form-group ">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" class="form-control" placeholder="Digite a matrícula sem o vínculo" required
                        name="matricula" id="matricula">
                </div>

                <div class="form-group ">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" placeholder="___.___.___-__" required name="cpf" id="cpf">
                </div>

                <div class="form-group">
                    <label for="fone">Telefone:</label>
                    <input type="text" class="form-control" placeholder="(00) 00000-0000" required name="fone"
                        id="fone">
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" placeholder="Digite o e-mail" required name="email">
                </div>

                <div class="form-group">
                    <label for="dtnasc">Data de Nascimento:</label>
                    <input type="text" class="form-control" placeholder="__/__/____" required autofocus name="dtnasc"
                        id="data">
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" aria-describedby="senhaHelp"
                        placeholder="Digite a senha" required>
                    <!-- <small id="cpfHelp" class="form-text text-muted">Utilize seu cpf para acessar.</small> -->
                </div>

                <div class="form-group">
                    <label for="rsenha">Confirmar Senha:</label>
                    <input type="password" class="form-control" placeholder="Confirme a nova senha" required
                        name="rsenha">

                </div>

                <div class="form-group">
                    <label for="captcha">Captcha:</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text p-0">
                                <img src="captcha.php" alt="captcha" class="captcha-img">
                            </span>
                        </div>
                        <input type="text" class="form-control" maxlength="8" ame="captcha"
                            placeholder="Digite o captcha" required>
                    </div>
                </div>
                <button class="btn btn-dark btn-block" type="submit">Cadastrar</button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small  w-100 text-dark" href="login.php">Já possui acesso? Clique aqui para ir para a tela
                    de login.</a>
            </div>
        </div>
    </div>
</div>