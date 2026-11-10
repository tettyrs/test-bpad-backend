<?php

namespace App\Services;

use App\Exceptions\ConflictException;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = isset($filters['search']) ? addcslashes($filters['search'], '%_\\') : null;

        return User::query()
            ->when($search, fn ($query) => $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->when($filters['role'] ?? null, fn ($query, $role) => $query->where('role', $role))
            ->when(array_key_exists('is_active', $filters), fn ($query) => $query->where(
                'is_active',
                filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN)
            ))
            ->orderBy('name')
            ->paginate($filters['per_page'] ?? 10);
    }

    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => $data['password'],
            'role' => $data['role'],
            'is_active' => true,
        ]);
    }

    public function update(User $actor, User $target, array $data): User
    {
        if (isset($data['role']) && $data['role'] !== $target->role) {
            if ($actor->is($target)) {
                throw new ConflictException('Anda tidak bisa mengubah peran akun sendiri.');
            }

            if ($target->isAdmin() && $target->is_active && $data['role'] !== User::ROLE_ADMIN) {
                $this->ensureAnotherActiveAdmin($target);
            }
        }

        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        $target->update($data);

        return $target->refresh();
    }

    public function setStatus(User $actor, User $target, bool $active): User
    {
        if ($active === $target->is_active) {
            return $target;
        }

        if (! $active) {
            if ($actor->is($target)) {
                throw new ConflictException('Anda tidak bisa menonaktifkan akun sendiri.');
            }

            if ($target->isAdmin()) {
                $this->ensureAnotherActiveAdmin($target);
            }

            $target->tokens()->delete();
        }

        $target->update(['is_active' => $active]);

        return $target->refresh();
    }

    public function resetPassword(User $target, string $password): void
    {
        $target->update(['password' => $password]);
        $target->tokens()->delete();
    }

    private function ensureAnotherActiveAdmin(User $target): void
    {
        $others = User::query()
            ->where('role', User::ROLE_ADMIN)
            ->where('is_active', true)
            ->whereKeyNot($target->id)
            ->count();

        if ($others === 0) {
            throw new ConflictException('Minimal harus ada satu admin yang aktif.');
        }
    }
}
