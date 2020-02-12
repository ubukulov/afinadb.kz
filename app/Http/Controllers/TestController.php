<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TestController extends BaseController
{
    public function index()
    {
        $this->seo()->setTitle('Список тестов');
        $tests = Test::all();
        return view('testing.index', compact('tests'));
    }

    public function create()
    {
        $this->seo()->setTitle('Создать тест');
        return view('testing.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $test = Test::create([
                'user_id' => $user->id, 'title' => $data['test_title'], 'active' => 1
            ]);

            foreach($data['question'] as $key=>$value){
                $question = Question::create([
                    'test_id' => $test->id, 'title' => $value
                ]);

                foreach($data['answer'][$key] as $answer) {
                    $pos = strpos($answer, '@');
                    $correct_answer = ($pos === false) ? false : true;
                    $answer = ($pos === false) ? $answer : substr($answer, 1);
                    Answer::create([
                        'question_id' => $question->id, 'title' => $answer, 'correct_answer' => $correct_answer
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('testing');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function start($id)
    {
        $test = Test::findOrFail($id);
        $this->seo()->setTitle('Тестирование по тему - '.$test->title);
        $questions = $test->questions;
        return view('testing.start', compact('test', 'questions'));
    }

    public function end(Request $request, $id)
    {
        $data = $request->all();
        $test = Test::findOrFail($id);
        $this->seo()->setTitle('Результаты тестирование по тему - '.$test->title);
        $user = Auth::user();

        $count_right_answers = [];
        $count_wrong_answers = [];
        $count_all_questions = $test->questions;

        foreach($data['answer'] as $question_id=>$item) {
            $answer = Answer::findOrFail($item[0]);
            if ($answer->correct_answer) {
                $count_right_answers[] = $answer->id;
            } else {
                $count_wrong_answers[] = $answer->id;
            }
            UserTest::create([
                'test_id' => $test->id, 'user_id' => $user->id, 'question_id' => $question_id, 'answer_id' => $answer->id
            ]);
        }



        return view('testing.result', compact('test', 'count_right_answers', 'count_wrong_answers', 'count_all_questions'));
    }

    public function statistics($id)
    {
        $test = Test::findOrFail($id);
        $this->seo()->setTitle('Результаты тестирование по тему - '.$test->title);
        $statistics = UserTest::where(['test_id' => $test->id])
                ->join('accounts', 'accounts.id', '=', 'user_tests.user_id')
                ->get();

        $result = [];
        foreach($statistics as $statistic) {
            $answer = Answer::findOrFail($statistic->answer_id);
            if (array_key_exists($statistic->user_id, $result)) {
                $result[$statistic->user_id]['user'] = $statistic->name." ".$statistic->last_name;
                if ($answer->correct_answer) {
                    $result[$statistic->user_id]['r_cnt'] = (isset($result[$statistic->user_id]['r_cnt'])) ? $result[$statistic->user_id]['r_cnt'] + 1 : 1;
                } else {
                    $result[$statistic->user_id]['c_cnt'] = (isset($result[$statistic->user_id]['c_cnt'])) ? $result[$statistic->user_id]['c_cnt'] + 1 : 1;
                }
                $result[$statistic->user_id]['dt'] = date('d.m.Y H:i:s', strtotime($statistic->created_at));
            } else {
                $result[$statistic->user_id]['user'] = $statistic->name." ".$statistic->last_name;
                if ($answer->correct_answer) {
                    $result[$statistic->user_id]['r_cnt'] = 1;
                } else {
                    $result[$statistic->user_id]['c_cnt'] = 1;
                }
                $result[$statistic->user_id]['dt'] = date('d.m.Y H:i:s', strtotime($statistic->created_at));
            }
        }

        return view('testing.statistics', compact('test', 'result'));
    }
}
