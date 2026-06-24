<?php

namespace App\Services;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Events\LeadCaptured;
use App\Models\Lead;

class LeadService
{
    public function capture(array $data): Lead
    {
        $data['source'] ??= LeadSource::Website->value;
        $data['status'] ??= LeadStatus::New->value;
        $data['lead_score'] ??= $this->calculateScore($data);

        $lead = Lead::create($data);

        event(new LeadCaptured($lead));

        return $lead;
    }

    public function assign(Lead $lead, int $userId): Lead
    {
        $lead->update(['assigned_to' => $userId]);

        return $lead;
    }

    public function changeStatus(Lead $lead, LeadStatus $status): Lead
    {
        $lead->update(['status' => $status->value]);

        return $lead;
    }

    public function addNote(Lead $lead, string $note): Lead
    {
        $existing = $lead->notes;
        $lead->update([
            'notes' => $existing ? $existing . "\n\n" . $note : $note,
        ]);

        return $lead;
    }

    public function calculateScore(array $data): int
    {
        $score = 0;

        if (! empty($data['company'])) {
            $score += 10;
        }

        if (! empty($data['phone'])) {
            $score += 10;
        }

        if (! empty($data['message']) && strlen($data['message']) > 50) {
            $score += 10;
        }

        if (! empty($data['service_interest'])) {
            $score += 5;
        }

        return $score;
    }

    public function getNewLeads()
    {
        return Lead::new()->latest()->paginate(20);
    }

    public function getLeadsByStatus(string $status)
    {
        return Lead::byStatus($status)->latest()->paginate(20);
    }

    public function getUnassignedLeads()
    {
        return Lead::unassigned()->latest()->paginate(20);
    }
}
