<div class="row">
    <div class="col-12 text-center">
        <h2 class="page-header"></h2>
    </div>
</div>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6 ">
        <div class="card border-secondary">
            <div class="card-header">Efetue login com a sua credêncial</div>
            <div class="card-body">
                <form class="form-signin" method="post" action="<?php echo HOME_PATH ?>/auth/login" name="frm" id="frm" onsubmit="return login()">
                    
                    <div class="div-login">
                        <label for="inputMatricula">Matrícula</label>
                        <input type="text" name="inputMatricula" id="inputMatricula" class="form-control" placeholder="Matrícula" required autofocus>
                        <br/>
                        <label for="inputSenha">Senha</label>
                        <input type="password" name="inputSenha" id="inputSenha" class="form-control" placeholder="Senha" required>
                        <br/>
                    </div>

                    <div class="div-periodo">
                        <label for="inputPeriodo">Período</label>
                        <select name="inputPeriodo" id="inputPeriodo" class="form-control" required>
                            <?php if (count($periodos) == 0): ?>
                                <option value="0" disabled selected hidden="hidden">Nenhum período disponivel no sistema</option>
                            <?php endif; ?>
                            <?php foreach ($periodos as $periodo): ?>
                                <option value="<?php echo $periodo['periodo_id'] ?>">
                                    <?php echo $periodo['periodo_nome']; ?> / 
                                    <?php echo $periodo['periodo_ano'] ?> - <?php echo $periodo['periodo_sequencia'] ?>
                                    <?php   
                                    echo ($periodo['periodo_status_id'] == PeriodoStatusEnum::PERIODO_STATUS_FECHADO || $periodo['periodo_ok'] == '0') ? ' [Fechado]' : ''; // aparece pois pode acessar via whitelist
                                    echo ($periodo['periodo_status_id'] == PeriodoStatusEnum::PERIODO_STATUS_FINALIZADO) ? ' [Finalizado]' : ''; // resguardo pois nunca deve aparecer
                                    ?>

                                </option>
                            <?php endforeach ?>
                        </select>
                        <br/>
                    </div>
                    <button type="submit" id="btnSubmit" class="btn btn-lg btn-primary btn-block">Continuar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-4"></div>
</div>

<script>
    function login(){
        if ($('#inputPeriodo').val() == 0 || $('#inputPeriodo').val() == null || $('#inputPeriodo').val() == undefined){
            alert('Selecione um período');
            return false;
        }else{
            return true;
        }
    }

    $(document).ready(function(){
        $('.loader').hide();

        var browser = {
            isIe: function () {
                return navigator.appVersion.indexOf("MSIE") != -1;
            },
            navigator: navigator.appVersion,
            getVersion: function() {
                var version = 999;
                if (navigator.appVersion.indexOf("MSIE") != -1)
                    version = parseFloat(navigator.appVersion.split("MSIE")[1]);
                return version;
            }
    };

    if (browser.isIe() && browser.getVersion() <= 9) {
        alert("Você está usando o navegador Internet Explorer " + browser.getVersion() + ", algumas funcionalidades do site podem não funcionar corretamente, para uma melhor experiência de uso utilize um navegador com uma versão mais recente.")
    }

    });
</script>
