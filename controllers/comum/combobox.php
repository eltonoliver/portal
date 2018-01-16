<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Combobox extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("sica/turma_professor_model", "turma_professor", true);
        $this->load->model('sica/aluno_disciplina_model', 'alunoDisciplina', true);
    }

    /**
     * Prepara o HTML que irá popular a combo de disciplinas do professor
     * de acordo com a turma selecionada na combo de turma.
     * 
     * @param POST turma
     * @return string HTML para ser populado na combo
     */
    public function listaDisciplinaRegular() {
        $turma = $this->input->post("turma");
        $professor = $this->session->userdata("SCL_SSS_USU_PCODIGO");
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $result = $this->turma_professor->listaDisciplinasRegular($professor, $turma, $periodo);
        $disciplinas = "<option value=''>Selecione uma disciplina</option>";

        foreach ($result as $row) {
            $disciplinas .= "<option value='" . $row['CD_DISCIPLINA'] . "'>" . $row['NM_DISCIPLINA'] . "</option>";
        }

        echo $disciplinas;
    }
    
    public function listaAlunosTurma() {
        $turma = $this->input->post("turma");
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $result = $this->alunoDisciplina->listaAlunosTurma($turma, $periodo);
        
        foreach ($result as $row) {
            $disciplinas .= "<option value='" . $row['CD_ALUNO'] . "'>" .$row['CD_ALUNO']." - ".$row['NM_ALUNO'] . "</option>";
        }

        echo $disciplinas;
    }
    
    

}
