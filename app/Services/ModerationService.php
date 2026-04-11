<?php

namespace App\Services;

use App\Models\AdminActionLog;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Models\User;
use Illuminate\Support\Carbon;

class ModerationService
{
    public function moderateDispute(User $admin, Dispute $dispute, string $status, ?string $reason = null): Dispute
    {
        $dispute->update([
            'status' => $status,
            'moderated_by' => $admin->id,
            'moderated_at' => Carbon::now(),
        ]);

        $this->log(
            admin: $admin,
            actionType: $status === Dispute::STATUS_HIDDEN ? 'hide_dispute' : 'show_dispute',
            targetType: Dispute::class,
            targetId: $dispute->id,
            metadata: ['reason' => $reason]
        );

        return $dispute->refresh();
    }

    public function moderateFeedback(User $admin, ClientFeedback $feedback, string $status, ?string $reason = null): ClientFeedback
    {
        $feedback->update([
            'status' => $status,
            'moderated_by' => $admin->id,
            'moderated_at' => Carbon::now(),
        ]);

        $this->log(
            admin: $admin,
            actionType: $status === ClientFeedback::STATUS_HIDDEN ? 'hide_feedback' : 'show_feedback',
            targetType: ClientFeedback::class,
            targetId: $feedback->id,
            metadata: ['reason' => $reason]
        );

        return $feedback->refresh();
    }

    public function deleteDispute(User $admin, Dispute $dispute, ?string $reason = null): void
    {
        $dispute->delete();

        $this->log(
            admin: $admin,
            actionType: 'delete_dispute',
            targetType: Dispute::class,
            targetId: $dispute->id,
            metadata: ['reason' => $reason]
        );
    }

    public function deleteFeedback(User $admin, ClientFeedback $feedback, ?string $reason = null): void
    {
        $feedback->delete();

        $this->log(
            admin: $admin,
            actionType: 'delete_feedback',
            targetType: ClientFeedback::class,
            targetId: $feedback->id,
            metadata: ['reason' => $reason]
        );
    }

    public function suspendUser(User $admin, User $target, ?string $reason = null): User
    {
        $target->update(['status' => User::STATUS_SUSPENDED]);

        $this->log(
            admin: $admin,
            actionType: 'suspend_user',
            targetType: User::class,
            targetId: $target->id,
            metadata: ['reason' => $reason]
        );

        return $target->refresh();
    }

    public function unsuspendUser(User $admin, User $target, ?string $reason = null): User
    {
        $target->update(['status' => User::STATUS_ACTIVE]);

        $this->log(
            admin: $admin,
            actionType: 'unsuspend_user',
            targetType: User::class,
            targetId: $target->id,
            metadata: ['reason' => $reason]
        );

        return $target->refresh();
    }

    protected function log(User $admin, string $actionType, string $targetType, int $targetId, array $metadata = []): void
    {
        AdminActionLog::create([
            'admin_user_id' => $admin->id,
            'action_type' => $actionType,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'metadata' => $metadata,
        ]);
    }
}

