<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gabarito extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("sica/aluno_model", "aluno", true);

        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

    function prova_impressa() {
        $codigo = $this->session->userdata("SCL_SSS_USU_CODIGO");

        $data = array(
            "titulo" => "GABARITOS DE PROVAS",
            "token" => base64_encode($codigo)
        );

        $this->load->view("provas/gabarito/prova_impressa", $data);
    }

    function prova_online() {
        $codigo = $this->session->userdata("SCL_SSS_USU_CODIGO");

        $data = array(
            "titulo" => "GABARITOS DE PROVAS ONLINE",
            "token" => base64_encode($codigo)
        );

        $this->load->view("provas/gabarito/prova_online", $data);
    }

    
    function grid_prova_impressa() {
        $token = $this->input->post("token");
        $bimestre = $this->input->post("bimestre");
        $aluno = base64_decode($token);

        $data = array(
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $this->aluno->listaGabaritosProvas($aluno, $bimestre)
        );

        $this->load->view('provas/gabarito/grid_prova_impressa', $data);
    }

    function grid_prova_online() {
        $token = $this->input->post("token");
        $bimestre = $this->input->post("bimestre");
        $aluno = base64_decode($token);

        $aux = $this->aluno->listaGabaritosProvasOnline($aluno, $bimestre);

        //montar um vetor de provas em que um dos elementos é um vetor com todas
        //as resposta, gabarito e tempo de resolução
        $provas = array();
        $codigoProva = null;
        $i = -1;
        foreach ($aux as $row) {
            if ($codigoProva != $row['CD_PROVA']) {
                $i++;
                $codigoProva = $row['CD_PROVA'];
                $provas[$i] = $row;
            }

            if ($codigoProva == $row['CD_PROVA']) {
                $provas[$i]['QUESTOES'][] = array(
                    'POSICAO' => $row['POSICAO'],
                    'CORRETA' => $row['CORRETA'],
                    'RESPOSTA' => $row['RESPOSTA'],
                    'NR_TEMPO_RESPOSTA' => $row['NR_TEMPO_RESPOSTA']
                );
            }
        }

        $data = array(
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $provas,
            'token' => $token
        );

        $this->load->view('provas/gabarito/grid_prova_online', $data);
    }

}
