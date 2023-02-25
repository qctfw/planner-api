<?php

namespace App\Http\Controllers;

use App\Enums\PlanStatus;
use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Http\Resources\PlanResource;
use App\Services\PlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class PlanController extends Controller
{
    public function __construct(private PlanService $plan_service)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $plans = $this->plan_service->getByUserId(auth()->id(), $request->integer('per_page', 10), $request->integer('page', 1));

        return PlanResource::collection($plans);
    }

    public function getByStatus(Request $request, PlanStatus $status): AnonymousResourceCollection
    {
        $plans = $this->plan_service->getByStatus(auth()->id(), $status, $request->integer('per_page', 10), $request->integer('page', 1));

        return PlanResource::collection($plans);
    }

    public function store(PlanCreateRequest $request): PlanResource
    {
        $plan = $this->plan_service->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline_at' => $request->date('deadline_at')
        ], auth()->id());

        return new PlanResource($plan);
    }

    public function show($id): PlanResource
    {
        $plan = $this->plan_service->find($id);

        abort_if(is_null($plan) || $plan->user_id != auth()->id(), Response::HTTP_NOT_FOUND);

        return new PlanResource($plan);
    }

    public function update(PlanUpdateRequest $request, $id): PlanResource
    {
        $plan = $this->plan_service->find($id);

        abort_if(is_null($plan) || $plan->user_id != auth()->id(), Response::HTTP_NOT_FOUND);

        $plan = $this->plan_service->update($plan, [
            'title' => $request->input('title'),
            'status' => $request->enum('status', PlanStatus::class),
            'description' => $request->input('description'),
            'deadline_at' => $request->date('deadline_at')
        ]);

        return new PlanResource($plan);
    }

    public function destroy($id): JsonResponse
    {
        $plan = $this->plan_service->find($id);

        abort_if(is_null($plan) || $plan->user_id != auth()->id(), Response::HTTP_NOT_FOUND);

        $this->plan_service->delete($id);

        return response()->json([
            'message' => 'Plan has been deleted.'
        ]);
    }
}
