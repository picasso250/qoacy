<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

use ptf\Controller as ptfController;

class Controller extends ptfController
{
    public function __construct()
    {
        $this->userDao = new UserDao;
        $this->questionDao = new QuestionDao;

        // login
        $this->currentUser = $this->userDao->getCurrentLoginUser();

        $this->page->description = $this->config['description'];
        $this->page->keywords = $this->config['keywords'];
    }
    
    public function init()
    {
        if ($this->currentUser == null) {
            // login check
            preg_match('/^(\w+)Controller$/', get_called_class(), $matches);
            $controller = $matches[1];
            if (in_array(array($controller, $this->action), $this->config['controllers.login'])) {
                $this->redirect("login?back=$_SERVER[x]");
            }
        }
    }
}

