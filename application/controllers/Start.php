<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("email");
    }

    public function index()
    {
        if ($this->input->get("secret_key") != "dev") {
            die("wrong secret");
        }
        if ($this->input->get("recipient_email") == "") {
            die("missing recipient email");
        }


        $data['recipient_name'] = $this->input->get("recipient_name") == "" ? "Ihr Firmenname" : $this->input->get("recipient_name");
        $data['recipient_logo'] = $this->input->get("recipient_logo");
        $data['recipient_web'] = $this->input->get("recipient_web") == "" ? "Ihr Firmenlink" : $this->input->get("recipient_web");
        $data['recipient_email'] = $this->input->get("recipient_email");
        //$this->input->get("sender_id");

        $this->load->view('start', $data);
    }

    public function sendmail()
    {
        parse_str($this->input->post("data"), $data);
        $fileName = time() . ".png";

        file_put_contents(__DIR__ . "/../../data/" . $fileName, file_get_contents($data['capture-img']));

        $this->email->from($this->config->item("mystb_email_from"));
        $this->email->to($data['recipient-email']);
        $this->email->subject('Email Test');
        $this->email->message('Testing the email.');
        $this->email->attach(__DIR__ . "/../../data/" . $fileName);

        $this->email->send();
    }
}
