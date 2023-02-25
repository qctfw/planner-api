<?php

namespace App\Services;

use App\Enums\PlanStatus;
use App\Models\Plan;

class PlanService
{
    public function __construct()
    {

    }

    public function create(array $data, string $user_id)
    {
        $plan = new Plan();

        $plan->user_id = $user_id;
        $plan->title = $data['title'];
        $plan->status = PlanStatus::ToDo;
        $plan->description = $data['description'];
        $plan->deadline_at = $data['deadline_at'];
        $plan->done_at = null;

        $plan->save();

        return $plan;
    }

    public function find(string $id)
    {
        return Plan::query()->find($id);
    }

    public function getByUserId(string $user_id, int $per_page = 10, int $page = 1)
    {
        if ($per_page > 50) $per_page = 50;

        return Plan::query()->where('user_id', $user_id)->paginate(perPage: $per_page, page: $page);
    }

    public function getByStatus(string $user_id, PlanStatus $status, int $per_page = 10, int $page = 1)
    {
        if ($per_page > 50) $per_page = 50;

        return Plan::query()->where([
            'user_id' => $user_id,
            'status' => $status,
        ])->paginate(perPage: $per_page, page: $page);
    }

    public function update(Plan $plan, array $data)
    {
        $plan->title = $data['title'];
        $plan->status = $data['status'];
        $plan->description = $data['description'];
        $plan->deadline_at = $data['deadline_at'];
        $plan->done_at = ($data['status'] == PlanStatus::Done) ? now() : null;

        $plan->save();

        return $plan;
    }

    public function delete(string $id)
    {
        $plan = Plan::query()->find($id);

        if (!$plan)
            return null;

        return $plan->delete();
    }
}
