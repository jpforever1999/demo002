<?php
class MY_Loader extends CI_Loader {

    public function template($template_name, $args = array(), $return = FALSE)
    {
        if($return){
    #        $content  = $this->view('common/header', $args, $return);
    #        $content .= $this->view($template_name, $args, $return);
    #        $content .= $this->view('common/footer', $args, $return);
    #        return $content;
            $this->view($template_name, $args);
        }else{
            $type = isset($_SESSION['type']) ? $_SESSION['type'] : 'customer';
            if($type == 'customer'){
                if(isset($args['homepage']) && $args['homepage']){
                    $this->view("$type/header", $args);
                    $this->view($template_name, $args);
                    $this->view("$type/footer", $args);
                }else{
                    $this->view("$type/headerinner", $args);
                    $this->view($template_name, $args);
                    $this->view("$type/footer", $args);
                }
            }if($type == 'admin'){
                $this->view("$type/header", $args);
                $this->view($template_name, $args);
                $this->view("$type/footer", $args);
            }
        }
    }
}

?>
