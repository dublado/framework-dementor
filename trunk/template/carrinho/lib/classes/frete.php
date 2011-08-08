<?php
    class frete
    {

        function __construct($cep)
        {

            $pgs = new PgsFrete();

            //$valores = $pgs->gerar("04552050",$_POST['pesoTotal'],0, $_POST['cepDestino']);
            $valores = $pgs->gerar("04552050",0.10,0, $cep);
            //var_dump($valores);
            $this->frete = $valores;
            $this->valor = $valores['Sedex'];


        }
        


    }
