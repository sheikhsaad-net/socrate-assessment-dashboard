<?php

namespace App\Http\Controllers;

use App\Models\QaUserAnswer;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Models\Exercise;
use App\Models\Track;
use App\Models\ExerciseItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QaUserAnswerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'question_id' => 'required|integer',
        ]);

        $row = QaUserAnswer::create([
            'user_id'     => $req->user()->id,
            'question_id' => $req->question_id,
            'selected_at' => now()->toDateString(),
        ]);

        return response()->json([
            'status'    => 'stored',
            'entry_id'  => $row->id,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, $id)
    {
        $req->validate([
            'answer_id' => 'required|integer',
        ]);

        $row = QaUserAnswer::findOrFail($id);

        $row->update([
            'answer_id' => $req->answer_id,
        ]);

        return response()->json([
            'status'    => 'updated',
            'entry_id'  => $row->id,
        ], 200);
    }

    public function getQuestionSurway()
    {
        $rows = SurveyQuestion::all('id', 'title');

        return response()->json($rows, 200);
    }

    public function storeQuestionSurway(Request $req)
    {
        $req->validate([
            'entry_id' => 'required|integer',
            'survey_question_1'  => 'nullable|string',
            'survey_question_2'  => 'nullable|string',
            'survey_question_3'  => 'nullable|string',
            'survey_question_4'  => 'nullable|string',
            'survey_question_5'  => 'nullable|string',
            'survey_question_6'  => 'nullable|string',
            'survey_question_7'  => 'nullable|string',
            'survey_question_8'  => 'nullable|string',
            'survey_question_9'  => 'nullable|string',
            'survey_question_10' => 'nullable|string',
            'survey_question_11' => 'nullable|string',
            'survey_question_12' => 'nullable|string',
            'survey_question_13' => 'nullable|string',
        ]);

        $qa = QaUserAnswer::findOrFail($req->entry_id);

        SurveyAnswer::create([
            'entry_id'           => $req->entry_id,
            'question_id'        => $qa->question_id,
            'answer_id'          => null,
            'survey_question_1'  => $req->survey_question_1,
            'survey_question_2'  => $req->survey_question_2,
            'survey_question_3'  => $req->survey_question_3,
            'survey_question_4'  => $req->survey_question_4,
            'survey_question_5'  => $req->survey_question_5,
            'survey_question_6'  => $req->survey_question_6,
            'survey_question_7'  => $req->survey_question_7,
            'survey_question_8'  => $req->survey_question_8,
            'survey_question_9'  => $req->survey_question_9,
            'survey_question_10' => $req->survey_question_10,
            'survey_question_11' => $req->survey_question_11,
            'survey_question_12' => $req->survey_question_12,
            'survey_question_13' => $req->survey_question_13,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }

    public function storeAnswerSurway(Request $req)
    {
        $req->validate([
            'entry_id'           => 'required|integer',
            'survey_question_1'  => 'nullable|string',
            'survey_question_2'  => 'nullable|string',
            'survey_question_3'  => 'nullable|string',
            'survey_question_4'  => 'nullable|string',
            'survey_question_5'  => 'nullable|string',
            'survey_question_6'  => 'nullable|string',
            'survey_question_7'  => 'nullable|string',
            'survey_question_8'  => 'nullable|string',
            'survey_question_9'  => 'nullable|string',
            'survey_question_10' => 'nullable|string',
            'survey_question_11' => 'nullable|string',
            'survey_question_12' => 'nullable|string',
            'survey_question_13' => 'nullable|string',
        ]);

        $qa = QaUserAnswer::findOrFail($req->entry_id);

        SurveyAnswer::create([
            'entry_id'           => $req->entry_id,
            'question_id'        => null,
            'answer_id'          => $qa->answer_id,
            'survey_question_1'  => $req->survey_question_1,
            'survey_question_2'  => $req->survey_question_2,
            'survey_question_3'  => $req->survey_question_3,
            'survey_question_4'  => $req->survey_question_4,
            'survey_question_5'  => $req->survey_question_5,
            'survey_question_6'  => $req->survey_question_6,
            'survey_question_7'  => $req->survey_question_7,
            'survey_question_8'  => $req->survey_question_8,
            'survey_question_9'  => $req->survey_question_9,
            'survey_question_10' => $req->survey_question_10,
            'survey_question_11' => $req->survey_question_11,
            'survey_question_12' => $req->survey_question_12,
            'survey_question_13' => $req->survey_question_13,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }

    public function createExercise(Request $request)
    {
        $exercise = Exercise::create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'exercise_id' => $exercise->id,
        ], 201);
    }

    public function addExerciseItems(Request $request)
    {
        
        $request->validate([
            'exercise_id'      => 'required|exists:exercises,id',
            'items'            => 'required|array|max:20',
            'items.*.title'    => 'required|string|max:255',
            'items.*.rate'     => 'required|string|max:255',
            'items.*.time'     => 'required|string|max:255', 
        ]);

        foreach ($request->items as $item) {
            ExerciseItem::create([
                'exercise_id' => $request->exercise_id,
                'title'       => $item['title'],
                'rate'        => $item['rate'],
                'time'        => $item['time'], 
            ]);
        }

        return response()->json([
            'message' => 'Items added successfully',
        ], 201);
    }

    /**
    * Display the specified resource.
    */
    public function show(User $user)
    {
        $answers = QaUserAnswer::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('answers', compact('answers', 'user'));
    }

    public function survey($entryId)
    {
        
        $entry = QaUserAnswer::findOrFail($entryId);
        $user = User::findOrFail($entry->user_id);

        $question = SurveyQuestion::all();

        $questionSurvey = SurveyAnswer::where('entry_id', $entry->id)->whereNotNull('question_id')->where('question_id', $entry->question_id)->first();
        $answerSurvey = SurveyAnswer::where('entry_id', $entry->id)->whereNotNull('answer_id')->where('answer_id', $entry->answer_id)->first();

        return view('survey', compact('entry', 'user', 'question','questionSurvey', 'answerSurvey'));
    }

    public function exercise(User $user)
    {
        
        $exercises = Exercise::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('exercise', compact('exercises', 'user'));
    }

    public function viewExercise($id)
    {
        $items = ExerciseItem::where('exercise_id', $id)->get();

        return view('exercise-item', compact('items', 'id'));
    }

    public function downloadUserCsv(User $user)
    {
        $fileName = 'user_answers_' . $user->id . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function() use ($user) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'User Name', 'Entry ID', 'Question ID', 'Answer ID',
                'Survey Q1','Survey Q2','Survey Q3','Survey Q4','Survey Q5',
                'Survey Q6','Survey Q7','Survey Q8','Survey Q9','Survey Q10',
                'Survey Q11','Survey Q12','Survey Q13'
            ]);

            $qaEntries = QaUserAnswer::where('user_id', $user->id)->get();

            foreach ($qaEntries as $entry) {
                $surveyAnswers = SurveyAnswer::where('entry_id', $entry->id)->get();

                foreach ($surveyAnswers as $answer) {
                    fputcsv($file, [
                        trim(($user->setting->first_name ?? '') . ' ' . ($user->setting->last_name ?? '')) ?: 'N/A',
                        $entry->id,
                        $answer->question_id,
                        $answer->answer_id,
                        $answer->survey_question_1,
                        $answer->survey_question_2,
                        $answer->survey_question_3,
                        $answer->survey_question_4,
                        $answer->survey_question_5,
                        $answer->survey_question_6,
                        $answer->survey_question_7,
                        $answer->survey_question_8,
                        $answer->survey_question_9,
                        $answer->survey_question_10,
                        $answer->survey_question_11,
                        $answer->survey_question_12,
                        $answer->survey_question_13
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadExerciseCsv(User $user)
    {
        $fileName = 'user_exercises_' . $user->id . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function() use ($user) {
            $file = fopen('php://output', 'w');

            // Header row in Italian
            fputcsv($file, ['Nome Utente', 'Exercise ID', 'Titolo', 'Rate', 'Tempo (sec)', 'Data Creazione']);

            // Fetch all exercises for the user
            $exercises = Exercise::where('user_id', $user->id)->get();

            foreach ($exercises as $exercise) {
                // Fetch items for this exercise like SurveyAnswer example
                $items = ExerciseItem::where('exercise_id', $exercise->id)->get();

                foreach ($items as $item) {
                    fputcsv($file, [
                        trim(($user->setting->first_name ?? '') . ' ' . ($user->setting->last_name ?? '')) ?: 'N/A',
                        $exercise->id,
                        $item->title,
                        $item->rate,
                        $item->time,
                        $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A'
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function storeTrackListen(Request $request, $question_id)
    {
        // Validate incoming JSON array
        $request->validate([
            'items'                 => 'required|array|max:20',
            'items.*.track_number' => 'required|integer',
            'items.*.exercise_number'=> 'required|integer',
            'items.*.listen_count'  => 'required|integer|min:0',
        ]);

        $created = [];

        foreach ($request->items as $item) {
            $record = Track::create([
                'user_id'         => $request->user()->id,
                'question_id'     => $question_id,
                'track_number'   => $item['track_number'],
                'exercise_number' => $item['exercise_number'],
                'listen_count'    => $item['listen_count'],
            ]);
            $created[] = $record;
        }

        // Return JSON response
        return response()->json([
            'message' => 'Track listen saved successfully',
        ], 201);
    }

    
    public function tracks($user, $question)
    {

        $tracks = Track::where('user_id', $user)->where('question_id', $question)->get();

        // Return view with track details
        return view('tracks', compact('tracks'));
    }

}
