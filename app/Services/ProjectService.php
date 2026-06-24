<?php

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Models\Project;

class ProjectService
{
    public function create(array $data): Project
    {
        $project = Project::create($data);

        if (isset($data['categories'])) {
            $project->categories()->sync($data['categories']);
        }

        return $project;
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);

        if (isset($data['categories'])) {
            $project->categories()->sync($data['categories']);
        }

        return $project;
    }

    public function publish(Project $project): Project
    {
        $project->update([
            'status' => ProjectStatus::Published->value,
            'published_at' => now(),
        ]);

        return $project;
    }

    public function archive(Project $project): Project
    {
        $project->update(['status' => ProjectStatus::Archived->value]);

        return $project;
    }

    public function getFeaturedProjects(int $limit = 6)
    {
        return Project::published()->featured()
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();
    }

    public function getPublishedProjects()
    {
        return Project::published()
            ->orderByDesc('published_at')
            ->paginate(12);
    }

    public function getProjectsByCategory(string $categorySlug)
    {
        return Project::published()
            ->whereHas('categories', fn ($q) => $q->where('slug', $categorySlug))
            ->orderByDesc('published_at')
            ->paginate(12);
    }
}
