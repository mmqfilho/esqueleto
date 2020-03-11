<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Erro:</span>
            <?php echo $this->__get('exception')->getMessage() ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Detalhes Tecnicos
        </button>
        <br/><br/>
        <div class="collapse" id="collapseExample">
            <div class="well">
                <pre style="background-color: #000; color: #FFF;"><?php print_r($this->__get('exception')) ?></pre>
            </div>
        </div>

    </div>
</div>
