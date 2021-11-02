<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCourse;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $courses = $this->courseService->getCourses();

        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdateCourse $request
     * @return CourseResource
     */
    public function store(StoreUpdateCourse $request): CourseResource
    {
        $course = $this->courseService->createNewCourse($request->validated());

        return new CourseResource($course);
    }
    /**
     * Display the specified resource.
     *
     * @param string $identify
     * @return CourseResource
     */
    public function show(string $identify): CourseResource
    {
        $course = $this->courseService->getCourse($identify);

        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateCourse $request
     * @param string $identify
     * @return JsonResponse
     */
    public function update(StoreUpdateCourse $request, string $identify): JsonResponse
    {
        $this->courseService->updateCourse($identify, $request->validated());

        return response()->json(['message' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $identify
     * @return JsonResponse
     */
    public function destroy($identify)
    {
        $this->courseService->deleteCourse($identify);

        return response()->json([], 204);
    }
}
