<?php

namespace App\Repositories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AgentRepository
{
    public function find(int $id): Agent
    {
        return Agent::findOrFail($id);
    }

    public function selectAgents(): array
    {
        return Agent::published()->pluck('company_name', 'id')->toArray();
    }

    public function getAll(): Collection
    {
        return Agent::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return Agent::query()
            ->when($filters['search'], function ($query, $value) {
                return $query->where('company_name', 'like', "%{$value}%")
                    ->orWhere('telephone', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('line', 'like', "%{$value}%")
                    ->orWhere('whatsapp', 'like', "%{$value}%")
                    ->orWhere('wechat', 'like', "%{$value}%")
                    ->orWhere('telegram', 'like', "%{$value}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): Agent
    {
        $agent = new Agent;

        return $this->valuable($agent, $data);
    }

    public function update(int $id, array $data): Agent
    {
        $agent = $this->find($id);

        return $this->valuable($agent, $data);
    }

    public function valuable(Agent $agent, array $param = []): Agent
    {
        $param = (object) $param;

        !isset($param->company_name) ?: $agent->company_name = $param->company_name;
        !isset($param->logo) ?: $agent->logo = $param->logo;
        !isset($param->telephone) ?: $agent->telephone = $param->telephone;
        !isset($param->email) ?: $agent->email = $param->email;
        !isset($param->line) ?: $agent->line = $param->line;
        !isset($param->whatsapp) ?: $agent->whatsapp = $param->whatsapp;
        !isset($param->wechat) ?: $agent->wechat = $param->wechat;
        !isset($param->telegram) ?: $agent->telegram = $param->telegram;
        !isset($param->status) ?: $agent->status = $param->status;
        !isset($param->password) ?: $agent->password = $param->password;
        !isset($param->password_not_encrypted) ?: $agent->password_not_encrypted = $param->password_not_encrypted;

        $agent->save();

        return $agent;
    }
}
