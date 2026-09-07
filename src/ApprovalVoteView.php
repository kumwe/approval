<?php

declare(strict_types=1);

namespace Kumwe\Approval;

use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Redacted immutable decision shown in an authorized approval detail view.
 *
 * @since  0.1.0
 */
final readonly class ApprovalVoteView
{
    /**
     * Create one validated and redacted approval decision projection.
     *
     * @param  string             $id          Vote UUID.
     * @param  string             $approverId  Accountable approver identity.
     * @param  string             $decision    Closed `approve` or `reject` decision.
     * @param  ?string            $reason      Optional bounded operator note.
     * @param  DateTimeImmutable  $decidedAt   Decision instant.
     *
     * @since  0.1.0
     */
    public function __construct(
        public string $id,
        public string $approverId,
        public string $decision,
        public ?string $reason,
        public DateTimeImmutable $decidedAt,
    ) {
        if (
            !\Ramsey\Uuid\Uuid::isValid($id)
            || preg_match('/^[A-Za-z0-9][A-Za-z0-9._:-]{0,190}$/D', $approverId) !== 1
        ) {
            throw new InvalidArgumentException('An approval view identity is invalid.');
        }
        if (!in_array($decision, ['approve', 'reject'], true)) {
            throw new InvalidArgumentException('An approval view decision is invalid.');
        }
        if (
            $reason !== null && (
                trim($reason) === '' || !mb_check_encoding($reason, 'UTF-8') || mb_strlen($reason, 'UTF-8') > 500
                || preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $reason) === 1
            )
        ) {
            throw new InvalidArgumentException('An approval view reason is invalid.');
        }
    }
}
