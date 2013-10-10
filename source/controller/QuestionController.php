<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class QuestionController extends Controller
{
    function viewAction()
    {
        $question = $this->questionDao->findOne($this->id);
        $answers = $question->getAnswers();
        $this->addScripts('jquery.form');
        $this->renderView('master', compact('question', 'answers'));
    }
}
