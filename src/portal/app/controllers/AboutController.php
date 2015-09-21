<?php

class AboutController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setVar('title','公司简介');
    }

    public function cooperationAction()
    {
        $this->view->setVar('title','合作伙伴');
    }

    public function contactAction()
    {
        $this->view->setVar('title','联系我们');
    }

}

