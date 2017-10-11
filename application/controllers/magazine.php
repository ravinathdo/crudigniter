<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of magazine
 *
 * @author User
 */
class Magazine extends CI_Controller {

    //put your code here

    public function index() {
        /*
          $this->load->model('Publication');
          $this->Publication->publication_name = 'Sandy Show';
          $this->Publication->save();
          echo '<tt><pre>'. var_export($this->Publication, TRUE).'</pre></tt>';

          $this->load->model('Issue');
          $issue = new Issue();
          $issue->publication_id =  $this->Publication->publication_id;
          $issue->issue_number = 1522;
          $issue->issue_cover = "Cover Issue";
          $issue->issue_date_publication = date('2017-05-20');
          $issue->save();
          echo '<tt><pre>'. var_export($issue, TRUE).'</pre></tt>';

          $this->load->view('magazines');
         */


        $data = array();
        $this->load->model('Publication');
        $publication = new Publication();
        $publication->load(1);
        echo '<tt><pre>' . var_export($publication, TRUE) . '</pre></tt>';
        $data['publication'] = $publication;

        $this->load->model('Issue');
        $issue = new Issue();
        $issue->load(1);
        $data['issue'] = $issue;

        $this->load->view('magazine', $data);
    }

    public function add() {
        //populate Publication Model
        $this->load->model('Publication');
        $publications = $this->Publication->get();


        $publication_form_option = array();
        foreach ($publications as $id => $publication) {
            $publication_form_option[$id] = $publication->publication_name;
        }



//---------form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'publication_id',
                'label' => 'publication',
                'rules' => 'required',
            ),
            array(
                'field' => 'issue_number',
                'label' => 'Issue Number',
                'rules' => 'required|is_numeric',
            ),
            array(
                'field' => 'issue_date_publication',
                'label' => 'publication Date',
                'rules' => 'required|callback_date_validation', //custome call back function
            ),
        ));
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        if (!$this->form_validation->run()) {
            $this->load->view('magazine_form', array('publication_form_options' => $publication_form_option
            ));
        } else {

//-------------collect the input and store

//-------------//collect the input and store



            $this->load->view('magazine_form_success');
        }
        //---------//form validation
    }

    public function date_validation($input) {
        $test_date = explode("-", $input);
        if (!@checkdate($test_date[2], $test_date[1], $test_date[0])) {
            $this->form_validation->set_message('date_validation', 'date must YYYY-MM-DD');
            return FALSE;
        }
        return TRUE;
    }

}
