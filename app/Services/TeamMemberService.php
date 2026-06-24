<?php

namespace App\Services;

use App\Models\TeamMember;

class TeamMemberService
{
    public function getActiveMembers()
    {
        return TeamMember::active()->ordered()->get();
    }

    public function updateOrder(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            TeamMember::where('id', $id)->update(['display_order' => $index]);
        }
    }
}
