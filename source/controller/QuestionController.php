<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class QuestionController extends Controller
{
    public function viewAction()
    {
        $question = $this->questionDao->findOne($this->id);
        $answers = $question->getAnswers();
        $this->addScripts('jquery.form');
        $this->renderView('master', compact('question', 'answers'));
    }

    public function askAction()
    {
        $title = $this->param('title');
        $question = $this->questionDao
                ->add(array(
                    'title' => $title,
                    'user_id' => $this->currentUser->id;
                ));
        $this->redirect("/question/$question->id");
    }

    public function answerAction()
    {
        $content = $this->param('content');
        $this->answerDao
            ->add(array(
                'question_id' => $this->param('question_id'),
                'content' => $content,
                'user_id' => $this->currentUser->id,
            ));
        return $this->renderBlock('question/answer');
    }
}
