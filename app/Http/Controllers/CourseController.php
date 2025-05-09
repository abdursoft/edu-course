<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'preview' => 'required|file|mimes:mp4,mov,avi|max:51200',
            'preview_image' => 'required|file|mimes:jpeg,jpg,png,webp|max:1200'
        ]);

        if($validator->fails()){
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => "Course creation failed",
                    "errors" => $validator->errors()
                ],
                400
            );
        }


        try {
            DB::beginTransaction();

            $course = Course::create([
                'title' => $request->title,
                'price' => $request->price,
                'preview' => Storage::disk('public')->put('preview',$request->file('preview')) ?? nullValue(),
                'preview_image' => Storage::disk('public')->put('preview_image',$request->file('preview_image')) ?? nullValue(),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'user_id' => $request->user['user_id']
            ]);

            foreach ($request->modules as $mod) {
                $module = $course->modules()->create([
                    'title' => $mod['title'],
                    'duration' => $mod['duration'] ?? '',
                ]);

                foreach ($mod['contents'] as $content) {
                    $module->contents()->create([
                        'content_type' => $content['content_type'],
                        'video' => $content['content_url'],
                        'duration' => $content['duration'],
                    ]);
                }
            }

            DB::commit();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => "Course creation successful",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => "Course creation failed",
                    "errors" => $th->getMessage()
                ],
                400
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Request $request)
    {
        $course->load('modules.contents');
        $user = $request->user;
        return view('pages.user.course-details',compact('course', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
