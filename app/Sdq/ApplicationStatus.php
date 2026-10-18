<?php

namespace App\Sdq;

/**
 * Workflow states of an application (one child's SDQ record). The string
 * values are the exact names stored in the legacy "status" table.
 */
enum ApplicationStatus: string
{
    case PreTest = 'Pre Test';
    case PreTestPending = 'Pre Test Pending';
    case PreTestCompleted = 'Pre Test Completed';
    case PostTest = 'Post Test';
    case PostTestPending = 'Post Test Pending';
    case PostTestCompleted = 'Post Test Completed';
    case Done = 'Done';
    case Dropout = 'Dropout';
    case PreTestNoPermission = 'Pre Test No Permission';
    case PostTestNoPermission = 'Post Test No Permission';
    case NotApplicable = 'NA';

    /** States in which the pre-test may still be edited. */
    public function allowsPreTestEdit(): bool
    {
        return in_array($this, [self::PreTest, self::PreTestPending], true);
    }

    /** States in which a post-test may be created or edited. */
    public function allowsPostTestEdit(): bool
    {
        return in_array($this, [self::PostTest, self::PostTestPending, self::PreTestCompleted], true);
    }

    /** States that count as "finished" and are excluded from pending lists. */
    public function isTerminal(): bool
    {
        return in_array($this, [self::Done, self::Dropout, self::NotApplicable, self::PreTestNoPermission, self::PostTestNoPermission], true);
    }

    /** Human label used in the UI. */
    public function label(): string
    {
        return match ($this) {
            self::NotApplicable => 'Not applicable (too many NA answers)',
            default => $this->value,
        };
    }
}
