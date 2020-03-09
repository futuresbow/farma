<?php

class MY_Loader extends CI_Loader {

    public function __construct() {

        $this->_ci_ob_level  = ob_get_level();

        $this->_ci_view_paths = array(
            FCPATH . TEMAMAPPA.'/' => TRUE
        );

        $this->_ci_library_paths = array(APPPATH, BASEPATH);

        $this->_ci_model_paths = array(APPPATH);

        $this->_ci_helper_paths = array(APPPATH, BASEPATH);

        log_message('debug', "Loader Class Initialized");

    }
}
