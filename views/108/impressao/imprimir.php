        <style media="all">
            html, boady{
                font-size:9px;
                height: 700px;
                page-break-before: 700px
            }
            .largura-colunas{
                font-size:11px;
                column-width: 50%;
                column-gap: 10px;
                column-number: 2;

                -moz-column-width: 350px;         /* Tamanho de cada coluna */
                -moz-column-gap: 15px;            /* Espaço entre as colunas */
                -moz-column-rule: 1px solid #666;
                -webkit-column-width: 350px;      /* Tamanho de cada coluna */
                -webkit-column-gap: 15px;         /* Espaço entre as colunas */
                -webkit-column-rule: 1px solid #666;
            }

            .numero-colunas{
                column-width: 50%;
                column-gap: 10px;
                column-number: 2;
                -moz-column-count: 2;             /* número de colunas */
                -moz-column-gap: 15px;            /* Espaço entre as colunas */
                -moz-column-rule: 1px solid #ccc;
                -webkit-column-count: 2;          /* número de colunas */
                -webkit-column-gap: 15px;         /* Espaço entre as colunas */
                -webkit-column-rule: 1px solid #ccc;
            }
            .largura-colunas img{
                width:150px;
                height:auto
            }
        </style>
            <?
            foreach ($questoes as $row) {
                echo $row['POSICAO'] . ') ' . $row['DC_QUESTAO'];
            }
            ?>