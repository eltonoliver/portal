<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aula_model extends CI_Model {

    /**
     * Atributo que indica a porcentagem minima de tempo que o professor deve
     * ministrar da aula.
     *
     * @var float
     */
    private $porcentagemTempoMinimo = 0.8;

    function __construct() {
        parent::__construct();
        $this->load->model("pajela/livro_assunto_model", "livro", true);
        $this->load->model("sica/configuracao_model", "configuracao", true);
        $this->load->model("sica/plano_ensino_model", "plano", true);
        $this->load->model("sica/turma_model", "turma", true);
        $this->load->database();
    }

    /**
     * Abre a aula do professor, registrando o inicio da aula.
     * 
     * @param int $aula
     * @return boolean TRUE caso aula seja aberta. FALSE caso contrário
     */
    public function abrir($aula) {
        $this->db->trans_start();

        //verificar o curso da turma
        $aux = $this->consultar($aula);
        $turma = $this->turma->consultar($aux['CD_TURMA'], $aux['PERIODO']);
        $infantil = $turma['CD_CURSO'] == 1;

        //abrir geminadas caso exista
        $geminadas = $this->listaAulasGeminada($aula);
        if (count($geminadas) > 0) {
            $this->abrirGeminadas($geminadas, $infantil);
        } else {
            //registra uma aula normalmente
            $hora = $this->getHoraAtual();
            $this->db->where("CD_CL_AULA", $aula);
            $this->db->update("BD_PAJELA.PJ_CL_AULA", array(
                "HR_ABERTURA" => $infantil ? $aux['HR_TEMPO_INICIO'] : $hora,
            ));
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Abre uma aula de forma retroativa.
     * 
     * @param int $aula
     * @return boolean
     */
    public function abrirRetroativo($aula) {
        $obj = $this->consultar($aula);
        $hora = $obj['HR_TEMPO_INICIO'];

        $this->db->where("CD_CL_AULA", $aula);
        return $this->db->update("BD_PAJELA.PJ_CL_AULA", array(
                    "HR_ABERTURA" => $hora,
        ));
    }

    /**
     * Fecha uma aula de forma retroativa.
     * 
     * @param int $aula
     * @return boolean
     */
    public function fecharRetroativo($aula) {
        $obj = $this->consultar($aula);
        $hora = $obj['HR_TEMPO_FIM'];

        $this->db->where("CD_CL_AULA", $aula);
        return $this->db->update("BD_PAJELA.PJ_CL_AULA", array(
                    "HR_FECHAMENTO" => $hora,
        ));
    }

    /**
     * Abre todas as aulas geminadas     
     *      
     * @param array $aulas
     * @param boolean $infantil Indica quando a aula é do infantil
     */
    private function abrirGeminadas($aulas, $infantil) {
        $i = 0;
        foreach ($aulas as $row) {
            $params = array(
                'HR_ABERTURA' => $row['HR_TEMPO_INICIO']
            );

            //primeira aula registra com horário da abertura exceto se for infantil
            if ($i == 0 && !$infantil) {
                $params['HR_ABERTURA'] = $this->getHoraAtual();
            }

            $this->db->where("CD_CL_AULA", $row['CD_CL_AULA']);
            $this->db->update("BD_PAJELA.PJ_CL_AULA", $params);
            $i++;
        }
    }

    /**
     * Fecha a aula do professor, registrando o término da aula
     * 
     * @param int $aula
     * @return boolean TRUE caso aula seja fechada. FALSE caso contrário
     */
    public function fechar($aula) {
        $this->db->trans_start();

        //verificar o curso da turma
        $aux = $this->consultar($aula);
        $turma = $this->turma->consultar($aux['CD_TURMA'], $aux['PERIODO']);
        $infantil = $turma['CD_CURSO'] == 1;

        //fechar geminadas caso exista
        $geminadas = $this->listaAulasGeminada($aula);
        if (count($geminadas) > 0) {
            $this->fecharGeminadas($geminadas, $infantil);
        } else {
            //registra uma aula normalmente
            $hora = $this->getHoraAtual();
            $this->db->where("CD_CL_AULA", $aula);
            $this->db->update("BD_PAJELA.PJ_CL_AULA", array(
                "HR_FECHAMENTO" => $infantil ? $aux['HR_TEMPO_FIM'] : $hora,
            ));
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Fecha todas as aulas que foram geminadas da aula passada por parametro.     
     * 
     * @param array $aulas
     * @param boolean $infantil Indica quando a aula é do infantil
     */
    private function fecharGeminadas($aulas, $infantil) {
        $i = 0;
        $total = count($aulas);
        foreach ($aulas as $row) {
            $i++;
            $params = array(
                'HR_FECHAMENTO' => $row['HR_TEMPO_FIM']
            );

            //curso infantil registra com hora inicio
            if ($i == $total && !$infantil) {
                $params['HR_FECHAMENTO'] = $this->getHoraAtual();
            }

            $this->db->where("CD_CL_AULA", $row['CD_CL_AULA']);
            $this->db->update("BD_PAJELA.PJ_CL_AULA", $params);
        }
    }

    /**
     * Lista todo o conteúdo ministrado para uma turma, aluno e disciplina.
     * 
     * @param int $disciplina
     * @param string $turma
     * @param string $periodo
     * @return array
     */
    public function listaConteudo($disciplina, $turma, $periodo) {
        $this->db->select("AL.CD_CL_AULA,
           AL.PERIODO,
           AL.CD_TURMA,
           AL.CD_DISCIPLINA,
           DS.NM_DISCIPLINA,
           DS.NM_DISC_RED,
           AL.CD_PROFESSOR,
           PF.NM_PROFESSOR,
           AL.CD_HORARIO,
           AL.TURNO,
           AL.TEMPO_AULA,
           AL.DT_AULA,
           AL.CONTEUDO,
           AL.TAREFA_CASA"
        );

        $this->db->from("BD_PAJELA.PJ_CL_AULA AL");
        $this->db->join("BD_SICA.CL_DISCIPLINA DS", "AL.CD_DISCIPLINA = DS.CD_DISCIPLINA");
        $this->db->join("BD_SICA.T_PROFESSOR PF", "AL.CD_PROFESSOR = PF.CD_PROFESSOR");
        $this->db->where("AL.CD_DISCIPLINA", $disciplina);
        $this->db->where("AL.CD_TURMA", $turma);
        $this->db->where("AL.PERIODO", $periodo);
        $this->db->order_by("AL.DT_AULA DESC");

        $query = $this->db->get();
        $aulas = $query->result_array();
        return $this->listaAssuntoLivro($aulas);
    }

    /**
     * Lista todos os registros conforme parametros informados.
     * 
     * @param array $params Vetor onde a chave são colunas da tabela e o valor
     * o filtro a ser feito.
     * 
     * @return array
     */
    public function listar($params = null) {
        $this->db->from("BD_PAJELA.PJ_CL_AULA");

        if ($params != null) {
            $this->db->where($params);
        }

        $this->db->order_by("DT_AULA DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista os conteúdos ministrados por um determinado periodo, turma, 
     * disciplina, data inicio e data fim.
     * 
     * @param array $params Array na estrutura:
     * array(
     *  'CD_TURMA' => value,
     *  'CD_DISCIPLINA' => value,
     *  'DT_INICIO' => value,
     *  'DT_FIM' => value,
     *  'PERIODO' => value
     * )
     * 
     * @return array 
     */
    public function listaConteudoPeriodo($params) {
        $this->db->select('AL.CD_CL_AULA, '
                . 'AL.DT_AULA, '
                . 'PF.NM_PROFESSOR, '
                . 'AL.CONTEUDO'
        );
        $this->db->from('BD_PAJELA.PJ_CL_AULA AL');
        $this->db->join('BD_SICA.CL_DISCIPLINA DS', 'AL.CD_DISCIPLINA = DS.CD_DISCIPLINA');
        $this->db->join('BD_SICA.T_PROFESSOR PF', 'AL.CD_PROFESSOR = PF.CD_PROFESSOR');
        $this->db->join('BD_SICA.TURMA TR', 'AL.CD_TURMA = TR.CD_TURMA AND AL.PERIODO = TR.PERIODO');
        $this->db->join('BD_SICA.SERIES SR', 'SR.CD_CURSO = TR.CD_CURSO AND SR.ORDEM_SERIE = TR.CD_SERIE');
        $this->db->where(array(
            'AL.CD_TURMA' => $params['CD_TURMA'],
            'AL.CD_DISCIPLINA' => $params['CD_DISCIPLINA'],
            'AL.PERIODO' => $params['PERIODO'],
            'AL.DT_AULA >=' => $params['DT_INICIO'],
            'AL.DT_AULA <=' => $params['DT_FIM']
        ));
        $this->db->order_by('DT_AULA, TEMPO_AULA, NM_DISCIPLINA ASC');
        $query = $this->db->get();
        $aulas = $query->result_array();
        return $this->listaAssuntoLivro($aulas);
    }

    /**
     * Retorna todas as datas de aulas que possuem de conteudo.
     * 
     * @param string $periodo
     * @param int $professor
     * @return array
     */
    public function listaDatasPendente($periodo, $professor) {
        $this->db->distinct();
        $this->db->select("DT_AULA");

        $this->db->from("BD_SICA.VW_AULA_PENDENCIAS");
        $this->db->where("PERIODO", $periodo);
        $this->db->where("CD_PROFESSOR", $professor);
        $this->db->where("DT_AULA != TRUNC(SYSDATE)");
        $this->db->where("CONTEUDO IS NULL");

        $this->db->order_by("DT_AULA");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as aulas que o conteúdo não foi lançado. A consulta leva em
     * conta apenas o conteúdo lançado de forma textual e não o conteúdo do 
     * livro.
     * 
     * @param string $periodo
     * @param int $professor
     * @param string $data Data no formato brasileiro (DD/MM/YYYY)
     * @return array
     */
    public function listaConteudoPendente($periodo, $professor, $data) {
        if (empty($data)) {
            return array();
        }

        $this->db->select("
            AULA.PERIODO,
            AULA.CD_TURMA,
            AULA.DT_AULA,
            AULA.CD_DISCIPLINA,
            AULA.CD_PROFESSOR,
            DIS.NM_DISCIPLINA,
            TUR.CD_TURMA,
            TUR.CD_CURSO,
            AULA.CD_CL_AULA,
            AULA.HR_TEMPO_INICIO,
            AULA.HR_TEMPO_FIM,
            AULA.TEMPO_AULA,
            SE.ORDEM_SERIE
        ");

        $this->db->from("BD_PAJELA.PJ_CL_AULA AULA");

        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = AULA.CD_TURMA "
                . "AND TUR.PERIODO = AULA.PERIODO");
        $this->db->join("BD_SICA.CURSOS CUR", "CUR.CD_CURSO = TUR.CD_CURSO");
        $this->db->join("BD_SICA.CL_DISCIPLINA DIS", "AULA.CD_DISCIPLINA = DIS.CD_DISCIPLINA");
        $this->db->join("BD_SICA.SERIES SE", "SE.CD_CURSO = CUR.CD_CURSO "
                . "AND TUR.CD_SERIE = SE.ORDEM_SERIE");

        $this->db->where("AULA.CONTEUDO IS NULL");
        $this->db->where("AULA.PERIODO", $periodo);
        $this->db->where("AULA.CD_PROFESSOR", $professor);
        $this->db->where("TO_CHAR(AULA.DT_AULA, 'DD/MM/YYYY') =", $data);

        $this->db->order_by("AULA.TURNO, AULA.TEMPO_AULA, AULA.HR_TEMPO_INICIO");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as datas de aulas pendentes de professores anteriores ao 
     * professor atual.
     * 
     * @param int $professorAtual 
     * @param array $disciplinas
     * @param array $turmas
     * @return array
     */
    public function listaDiasPendente($professorAtual, $disciplinas, $turmas) {

        $this->db->distinct();
        $this->db->select("AL.DT_AULA");
        $this->db->from("BD_SICA.VW_AULA_PENDENCIAS AL");
        $this->db->where("AL.CD_PROFESSOR", $professorAtual);
        $this->db->where("TRUNC(AL.DT_AULA) BETWEEN TO_DATE('01/02/2017', 'DD/MM/YYYY') AND TO_DATE('30/06/2017', 'DD/MM/YYYY')");
        $this->db->where_in("AL.CD_DISCIPLINA", $disciplinas);
        $this->db->where_in("AL.CD_TURMA", $turmas);
        $this->db->where(" NOT EXISTS( SELECT 1
                                         FROM BD_SICA.FC_CALENDARIO
                                        WHERE TIPO IN ('F')
                                          AND TRUNC(DATA) = TRUNC(AL.DT_AULA)) ", '', FALSE);
        $this->db->order_by("AL.DT_AULA");
        $query = $this->db->get()->result_array();
        
        // $this->db->last_query();

        return $query;
    }

    /**
     * Retornas aulas com pendências de professores anteriores ao atual. As 
     * pendência a serem consideradas são:
     * 
     * - Aula que não foi aberta;
     * - Aula que não foi fechada;
     * - Chamada não realizada;
     * - Conteúdo escrito ou da lista que não foi lançado.
     * 
     * @param int $professorAtual Professor atual.
     * @param string $data Data da aula pendente no formato dd/mm/yyyy
     * @param array $disciplinas Vetor com o código de todas as disciplinas
     * @param array $turmas Vetor com as turmas do professor
     * @return array 
     */
    public function listaAulasPendente($professorAtual, $data, $disciplinas, $turmas) {
        $this->db->from("BD_SICA.VW_AULA_PENDENCIAS"            );
        $this->db->where("DT_AULA = TO_DATE('" . $data . "', 'DD/MM/YYYY')");
        $this->db->where("TRUNC(DT_AULA) BETWEEN TO_DATE('01/02/2017', 'DD/MM/YYYY') AND TO_DATE('30/06/2017', 'DD/MM/YYYY')");
        $this->db->where_in("CD_DISCIPLINA", $disciplinas       );
        $this->db->where_in("CD_TURMA"     , $turmas            );
        $this->db->where("CD_PROFESSOR"    , $professorAtual    );
        $this->db->order_by("TURNO, TEMPO_AULA, HR_TEMPO_INICIO");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Obtem o assunto do livro das aulas informadas por parametro. O vetor deve
     * possuir o indice CD_CL_AULA para obter os livros de cada aula
     * 
     * @param array $aulas
     * @return array As aulas com conteudo escrito e de livro;
     */
    private function listaAssuntoLivro($aulas) {
        foreach ($aulas as &$row) {
            $row['ASSUNTO_LIVRO'] = $this->livro->listar($row['CD_CL_AULA']);
        }
        return $aulas;
    }

    /**
     * Verifica se a aula informada caso seja de uma turma regular, extra ou 
     * mista possui alunos para realizar chamada.
     * 
     * @param int $aula
     */
    public function hasAluno($aula) {
        //verificar quantos alunos de turmas regulares existe
        $this->db->from("BD_PAJELA.PJ_CL_AULA AU");
        $this->db->join("BD_SICA.TURMA TU", "AU.CD_TURMA = TU.CD_TURMA "
                . "AND AU.PERIODO = TU.PERIODO"
        );
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_TURMA = AU.CD_TURMA "
                . "AND AD.PERIODO = AU.PERIODO "
                . "AND AU.CD_DISCIPLINA = AD.CD_DISCIPLINA"
        );
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = AD.CD_ALUNO");
        $this->db->where_in("TU.TIPO", array("N", "X"));
        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->where("AU.CD_CL_AULA", $aula);

        $result = $this->db->count_all_results();

        if ($result > 0) {
            return true;
        }

        //verificar turmas mistas
        $this->db->from("BD_PAJELA.PJ_CL_AULA AU");
        $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA TM", "TM.CD_TURMA_MISTA = AU.CD_TURMA "
                . "AND TM.PERIODO = AU.PERIODO "
                . "AND TM.CD_DISCIPLINA = AU.CD_DISCIPLINA"
        );
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALU_DISC = TM.CD_ALU_DISC");
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = AD.CD_ALUNO");
        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->where("AU.CD_CL_AULA", $aula);

        $result = $this->db->count_all_results();


        if ($result > 0) {
            return true;
        }

        return false;
    }

    /**
     * Verifica se a aula informada necessita realizar chamada.
     * 
     * @param int $aula
     * @return boolean TRUE quando precisa realizar chamada. FALSE caso contrário
     */
    public function deveRealizarChamada($aula) {
        $this->db->from("BD_PAJELA.PJ_CL_AULA AL");
        $this->db->join("BD_SICA.TURMA TU", "TU.CD_TURMA = AL.CD_TURMA "
                . "AND AL.PERIODO = TU.PERIODO"
        );
        $this->db->where_in("TU.TIPO", array('N', 'X', '+'));
        $this->db->where("AL.CD_CL_AULA", $aula);
        $result = $this->db->count_all_results() > 0;
        return $result;
    }

    /**
     * Obtem o registro da aula informada.
     * 
     */
    public function consultar($aula) {
        $this->db->from("BD_PAJELA.PJ_CL_AULA");
        $this->db->where("CD_CL_AULA", $aula);

        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Realiza a validação dos horários para abrir e fechar aula.
     * 
     * @param int $codigo Código da aula     
     * @param boolean $abertura TRUE indica para validar o horário de abertura da 
     * aula. FALSE o horário de fechamento da aula.
     * 
     * @return boolean TRUE caso horário cumpra as regras. FALSE caso contrário.
     */
    public function validarHorario($codigo, $abertura = true) {
        $hora = $this->getHoraAtual();
        $aula = $this->consultar($codigo);
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);

        $status = true;

        /*
         * obter parametros para verificar se a trava esta ativa e configuração
         * para tolerancia para abrir e fechar.
         */
        $parametro = $this->configuracao->parametros();

        //não validar caso seja educação infantil ou trava não esteja ativa
        if ($turma['CD_CURSO'] == 1 || $parametro['FLG_ABERT_FECHAMENTO'] == 'N') {
            return true;
        }

        $horarioRegistrado = new DateTime($hora);
        if ($abertura) {
            //validar abertura
            $minimo = new DateTime($aula['HR_TEMPO_INICIO']);
            $maximo = new DateTime($aula['HR_TEMPO_INICIO']);

            //aplicar tolerancias de tempo antes e depois do horario
            $horarioMinimoAbrir = $minimo->sub(new DateInterval("PT" . $parametro['TOL_INI_ABERTURA'] . "M"));
            $horarioMaximoAbrir = $maximo->add(new DateInterval("PT" . $parametro['TOL_FIM_ABERTURA'] . "M59S"));

            //checar se o horario que registrou está dentro da tolerancia
            $status = $horarioRegistrado >= $horarioMinimoAbrir && $horarioRegistrado <= $horarioMaximoAbrir;
        } else {
            $geminadas = $this->listaAulasGeminada($codigo);
            $tempoFim = $aula['HR_TEMPO_FIM'];

            if (count($geminadas) > 0) {
                $tempoFim = $geminadas[count($geminadas) - 1]['HR_TEMPO_FIM'];
            }

            //obter tolerancia maxima para fechar aula
            $maximo = new DateTime($tempoFim);
            $horarioMaximoFechar = $maximo->add(new DateInterval("PT" . $parametro['TOL_FIM_FECHAMENTO'] . "M59S"));

            //obter quanto tempo falta para cumprir o minito restante
            $tempoMinimoRestante = $this->tempoMinimoRestante($codigo, $hora);

            //checa se professor ministrou o tempo necessario e dentro da tolerância
            $status = $tempoMinimoRestante <= 0 && $horarioRegistrado <= $horarioMaximoFechar;
        }

        return $status;
    }

    /**
     * Retorna em minutos quanto falta para o professor cumprir o tempo minimo 
     * em sala de aula.
     * 
     * @param int $codigo Codigo da Aula.
     * @param string $horaFechamento Horário que finalizou a aula.
     * 
     * @return int Número positivo indicando quanto tempo falta. Número menor ou
     * igual zero indicando que cumpriu o minimo necessário.
     */
    public function tempoMinimoRestante($codigo, $horaFechamento = null) {
        if ($horaFechamento === null) {
            $horaFechamento = $this->getHoraAtual();
        }

        $geminadas = $this->listaAulasGeminada($codigo);

        //calcular o tempo total da aula e obter a hora que abriu a aula
        $totalMinutos = 0;
        $horaAbertura = "";
        if (count($geminadas) > 0) {
            $horaAbertura = $geminadas[0]['HR_ABERTURA'];

            foreach ($geminadas as $row) {
                $inicio = new DateTime($row['HR_TEMPO_INICIO']);
                $fim = new DateTime($row['HR_TEMPO_FIM']);
                $diferenca = $fim->diff($inicio);
                $totalMinutos += $diferenca->format("%H") * 60 + $diferenca->format("%i");
            }
        } else {
            $aula = $this->consultar($codigo);
            $horaAbertura = $aula['HR_ABERTURA'];
            $inicio = new DateTime($aula['HR_TEMPO_INICIO']);
            $fim = new DateTime($aula['HR_TEMPO_FIM']);
            $diferenca = $fim->diff($inicio);
            $totalMinutos = $diferenca->format("%H") * 60 + $diferenca->format("%i");
        }

        //calcular quantos minutos o professor deve ministrar
        $tempoMinimo = $totalMinutos * $this->porcentagemTempoMinimo;

        //calcular quantos minutos restam para o professor ministrar
        $abertura = new DateTime($horaAbertura);
        $fechamento = new DateTime($horaFechamento);
        $diferenca = $fechamento->diff($abertura);
        $tempoMinistrado = $diferenca->format("%H") * 60 + $diferenca->format("%i");

        return $tempoMinimo - $tempoMinistrado;
    }

    /**
     * Obtem a aula que deve ser fechada.
     * 
     * @param int $professor
     * @param string $periodo
     * 
     * @return array
     */
    public function listaAulaFechar($professor, $periodo) {
        $parametros = $this->configuracao->parametros();
        $aulas = $this->listaAulaDia($professor, $periodo);

        foreach ($aulas as $row) {
            //obter dados da turma para verificar o curso
            $turma = $this->turma->consultar($row['CD_TURMA'], $row['PERIODO']);

            //não checa se deve fechar o ultimo tempo geminado ou aulas fechadas
            if (($row['GEMINADO'] && $row['QTDE_GEMINADO'] == 0) || $row['HR_FECHAMENTO'] != null || $turma['CD_CURSO'] == 1) {
                continue;
            }

            //se trava estiver habilitada somente exibir quem pode ser fechado
            if ($this->validarHorario($row['CD_CL_AULA'], false) &&
                    $parametros['FLG_ABERT_FECHAMENTO'] == 'S') {
                return $row['GEMINADO'] ? $row['ULTIMO_GEMINADO'] : $row;
            }

            //se trava não estiver habilitada mostrar com 5 minutos antes de fechar o tempo
            $horaMaximo = new DateTime($row['HR_TEMPO_FIM']);
            $horaMinimo = new DateTime($row['HR_TEMPO_FIM']);
            $horaMinimo = $horaMinimo->sub(new DateInterval("PT5M"));
            $horaAtual = new DateTime($this->getHoraAtual());
            if ($horaMinimo <= $horaAtual && $horaAtual <= $horaMaximo &&
                    $parametros['FLG_ABERT_FECHAMENTO'] == "N") {
                return $row['GEMINADO'] ? $row['ULTIMO_GEMINADO'] : $row;
            }
        }

        return null;
    }

    /**
     * Retorna todas aulas que um determinado professor possui na data corrente 
     * e período letivo.
     * 
     * @param int $professor     
     * @param string $periodo
     * @param int $subturma
     * @return array
     */
    public function listaAulaDia($professor, $periodo, $subturma = null) {
        $this->db->select("AULA.PERIODO,
            AULA.CD_TURMA,
            AULA.DT_AULA,
            AULA.CD_DISCIPLINA,
            AULA.CD_PROFESSOR,
            DIS.NM_DISCIPLINA, 
            TUR.CD_TURMA,
            TUR.CD_CURSO,
            AULA.TURNO,
            CUR.NM_CURSO,
            AULA.TEMPO_AULA,
            AULA.CD_CL_AULA,
            AULA.CD_CL_HORARIO_REF,
            AULA.HR_ABERTURA,
            AULA.HR_FECHAMENTO,
            AULA.SUBTURMA,
            AULA.HR_TEMPO_INICIO,
            AULA.HR_TEMPO_FIM,
            SE.ORDEM_SERIE, 
            AULA.HR_TEMPO_INICIO,                            
            DT.HR_INICIO AS HR_INICIO_PREV,
            DT.HR_FIM AS HR_FIM_PREV
        ");
        $this->db->from("BD_PAJELA.PJ_CL_AULA AULA");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = AULA.CD_TURMA "
                . "AND TUR.PERIODO = AULA.PERIODO");
        $this->db->join("BD_SICA.CURSOS CUR", "CUR.CD_CURSO = TUR.CD_CURSO");
        $this->db->join("BD_SICA.CL_DISCIPLINA DIS", "AULA.CD_DISCIPLINA = DIS.CD_DISCIPLINA");
        $this->db->join("BD_SICA.SERIES SE", "SE.CD_CURSO = CUR.CD_CURSO "
                . "AND TUR.CD_SERIE = SE.ORDEM_SERIE");
        $this->db->join("BD_RH.CL_DURACAO_TEMPO DT ", "DT.CD_CURSO = CUR.CD_CURSO "
                . "AND DT.ORDEM_SERIE = SE.ORDEM_SERIE "
                . "AND DT.TURNO_TEMPO = AULA.TURNO_TEMPO");
        $this->db->where("AULA.CD_PROFESSOR", $professor);
        $this->db->where("TUR.PERIODO", $periodo);
        $this->db->where("TRUNC(AULA.DT_AULA) = TRUNC(SYSDATE)");

        if ($subturma !== null) {
            $this->db->where("AULA.SUBTURMA", $subturma);
        }

        $this->db->order_by("AULA.TURNO, AULA.TEMPO_AULA, AULA.HR_TEMPO_INICIO");

        $query = $this->db->get();
        $aux = $query->result_array();

        //verificar quais aulas são geminadas
        $aulas = array();
        $qtde = 0;
        foreach ($aux as $row) {
            $geminados = array();
            if ($qtde == 0) {
                $geminados = $this->listaAulasGeminada($row['CD_CL_AULA']);
                $qtde = count($geminados);
            }

            //indicar quais aulas são geminadas            
            $row['GEMINADO'] = $qtde > 0;

            //contador de aulas para marcar como geminada caso exista
            $qtde--;
            $qtde = $qtde < 0 ? 0 : $qtde;

            /*
             * o tempo mais recente dos geminados possui o total de geminadas
             * para mesclar celulas; Obtem o último geminado para preencher 
             * dados de horário;
             */
            if (count($geminados) > 0) {
                $row['QTDE_GEMINADO'] = count($geminados);
                $row['ULTIMO_GEMINADO'] = $geminados[count($geminados) - 1];
            } else {
                $row['QTDE_GEMINADO'] = 0;
                $row['ULTIMO_GEMINADO'] = null;
            }

            $aulas[] = $row;
        }

        return $aulas;
    }

    /**
     * Retorna todas as aulas germinadas a partir da aula informada por 
     * parametro.
     * 
     * @param int $aula     
     * @return array
     */
    public function listaAulasGeminada($aula) {
        $aux = $this->consultar($aula);

        //obter as aulas que batem na disciplina, professor, turma e turno
        $this->db->from("BD_PAJELA.PJ_CL_AULA");
        $this->db->where('CD_DISCIPLINA', $aux['CD_DISCIPLINA']);
        $this->db->where('TURNO', $aux['TURNO']);
        $this->db->where('CD_TURMA', $aux['CD_TURMA']);
        $this->db->where('CD_PROFESSOR', $aux['CD_PROFESSOR']);
        $this->db->where('TEMPO_AULA >=', $aux['TEMPO_AULA']);
        $this->db->where('PERIODO', $aux['PERIODO']);
        $this->db->where("DT_AULA", $aux['DT_AULA']);
        $this->db->order_by("TEMPO_AULA");

        $query = $this->db->get();
        $aulas = $query->result_array();

        //obter as geminadas
        $geminadas = array();
        $proximoTempo = $aux['TEMPO_AULA'];
        foreach ($aulas as $row) {
            $horaInicio = new DateTime($row['HR_TEMPO_INICIO']);
            $horaAtual = new DateTime($this->getHoraAtual());

            /*
             * Somente considerar geminado se ainda é um tempo válido para 
             * registrar aula. Aulas que ainda não começaram não válidadas
             */
            if (($horaAtual < $horaInicio || ($this->validarHorario($row['CD_CL_AULA']) &&
                    $row['HR_ABERTURA'] == null) || $row['HR_ABERTURA'] != null) &&
                    $row['TEMPO_AULA'] == $proximoTempo) {
                $geminadas[] = $row;
            } else {
                break;
            }

            $proximoTempo++;
        }

        if (count($geminadas) == 1) {
            $geminadas = array();
        }

        return $geminadas;
    }

    /**
     * Salva todo o conteúdo lançado da aula, seja o conteúdo escrito ou do 
     * livro. Caso a aula seja geminada a ação é replicada para as demais aulas.
     * 
     * @param array $aula Vetor no seguinte formato:
     * array(
     *      'CD_CL_AULA' => <int>
     *      'CONTEUDO' => <string>
     *      'TAREFA_CASA' => <string>
     * )
     * @param array $assuntos Vetor com os codigos do assunto do livro.
     * @param boolean $checkGeminado Quando deve verificar se existe tempos 
     * geminados;
     */
    public function salvarConteudo($aula, $assuntos, $checkGeminado = true) {
        if ($checkGeminado) {
            $geminados = $this->listaAulasGeminada($aula['CD_CL_AULA']);
        }

        //verifica quantas aulas vai replicar os dados
        $aulas = array();
        if (count($geminados) > 0) {
            foreach ($geminados as $row) {
                $aulas[] = $row['CD_CL_AULA'];
            }
        } else {
            $aulas[] = $aula['CD_CL_AULA'];
        }

        $this->db->trans_start();

        //inserindo conteudo para cada aula geminada
        foreach ($aulas as $row) {
            $params = array(
                'CONTEUDO' => $aula['CONTEUDO'],
                'TAREFA_CASA' => $aula['TAREFA_CASA']
            );

            $this->db->where("CD_CL_AULA", $row);
            $this->db->update("BD_PAJELA.PJ_CL_AULA", $params);

            //preparar assuntos livros para inserir em lote
            $values = array();
            foreach ($assuntos as $assunto) {
                $aux = array(
                    'CD_CL_AULA' => $row,
                    'ID_LIVRO_ASSUNTO' => $assunto
                );
                $values[] = $aux;
            }

            //registrando assunto do livro se tiver
            if (!empty($values)) {
                $this->db->insert_batch("BD_PAJELA.PJ_CL_AULA_ASSUNTO", $values);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Obtém a hora atual do banco de dados para validar abrir e fechar aula
     * 
     * @return string
     */
    public function getHoraAtual() {
        $this->db->select("TO_CHAR(SYSDATE, 'HH24:MI:SS') HORA", false);
        $this->db->from("DUAL");
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['HORA'];
    }

}
