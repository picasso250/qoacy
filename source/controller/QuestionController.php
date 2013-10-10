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
        $answers = array_map(function ($a) {
            $a->attitudeInfo();
            $a->content = nl2br($a->content);
            return $a;
        }, $answers);
        usort($answers, function ($a, $b) {
            $goodSort = $b->goodCount - $a->goodCount;
            return $goodSort ?: ($a->badCount - $b->badCount);
        });
        $me = $GLOBALS['user'];
        add_scripts('jquery.form');
        render_view('master', compact('question', 'answers', 'me'));
    }
}
