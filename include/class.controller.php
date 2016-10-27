<?php

/*
 * controller class
 */

class controller {
    /*
     * database connection object
     */
    protected $db;

    /*
     * object name 
     */
    protected $name;

    /*
     * controller constructer
     */
    function controller() {
        global $db, $site;

        $this->db = $db;
        $this->name = get_class($this);
        $this->site = $site;
    }

    /*
     * main index method
     */
    function index() {
        $this->view('index');
    }

    /*
     * main not_found method
     */
    function not_found($name) {
        return strip_tags($name) . ' method not found';
    }

    /*
     * controller view connection
     */
    function view($view, $vars = array()) {
        global $site;

        $dir = DR . '/view/' . THEME . '/' . $this->name . '/' . $view . '.tpl.php';

        if (file_exists($dir)) {
            if ($vars) extract($vars, 1);

            ob_start();
            @include $dir;
            $out = ob_get_contents();
            ob_end_clean();

            return $out;
        } else {
            return $view . ' view not found.';
        }
    }

    /*
     * system message services. add new message to queue
     */
    function add_message($message, $status = 0) {
        $_SESSION['message'][$status][] = '• ' . $message;
    }

    /*
     * system message service. add new messages to queue
     */
    function add_messages($message, $status = 0) {
        if ($message) foreach ($message as $m) $this->add_message($m, $status);
    }

    /*
     * create message
     */
    function create_message($message, $status = "info") {
        return '<div class="alert alert-' . $status . '">' . $message . '</div>';
    }

    /*
     * get all messages and cleat the queue
     */
    function get_message() {
        if ($_SESSION['message']) {
            foreach ($_SESSION['message'] as $type => $messages) {
                $message .= $this->create_message(implode('<br>', $messages), $type);
            }
            $_SESSION['message'] = null;
        }

        return $message;
    }
}
