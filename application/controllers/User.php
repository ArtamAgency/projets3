<?php

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function connexion()
    {

        if(!empty($this->session->userdata('user_infos'))) {
            redirect('compte');
        }
        //$this->load->view('user/login.php');

        //Récupérer les données saisies envoyées en POST
        $login = $this->input->post('login');
        $password = md5($this->input->post('password'));

        $this->form_validation->set_rules('login', '"Identifiant"', 'trim|required');
        $this->form_validation->set_rules('password', '"Mot de passe"', 'trim|required');
        $result = $this->User_model->userLogin($login,$password);
        //var_dump($result);

        if($this->form_validation->run() === true && !empty($result))
        {
            //var_dump($result);
            $this->session->set_userdata('user_infos', $result);
            $this->session->set_flashdata('connect', 'Connecté en tant que');
            redirect('compte');
        }
        elseif($this->form_validation->run() == true && empty($result))
        {
            $this->session->set_flashdata('noconnect', 'Aucun compte ne correspond à vos identifiants ');
            $this->load->view('user/login');
        }
        else
        {
            $this->load->view('user/login');
        }

    }

    public function account()
    {
        if(!empty($this->session->userdata('user_infos'))) {
            $this->load->view('user/account');
        }else {
            redirect('User/connexion');
        }
    }

    public function cgPassword()
    {
        $curpaswd = md5($this->input->post('curpaswd'));
        $newpaswd = md5($this->input->post('newpaswd'));
        $rpnewpaswd = md5($this->input->post('rpnewpaswd'));

        $this->form_validation->set_rules('curpaswd', '"Mot de passe actuel"', 'trim|required');
        $this->form_validation->set_rules('newpaswd', '"Nouveau mot de passe"', 'trim|required');
        $this->form_validation->set_rules('rpnewpaswd', '"Répéter nouveau mot de passe"', 'trim|required');
        if ($curpaswd == $_SESSION['user_infos'][0]['user_password'] && $newpaswd == $rpnewpaswd) {
            $this->User_model->updatePassword($newpaswd);
            $this->session->set_flashdata('change', 'Ca a fonctionné ! reconnecte-toi maintenant.');
            $this->logout();
        }else {
            $this->session->set_flashdata('nochange', 'Tu n\'as pas rempli correctement les champs');
            redirect('compte');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('User/connexion');
    }
}