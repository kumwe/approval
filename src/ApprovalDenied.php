<?php

declare(strict_types=1);

namespace Kumwe\Approval;

/**
 * Generic approval failure that deliberately does not disclose request existence or rule detail.
 *
 * @since  0.1.0
 */
final class ApprovalDenied extends \RuntimeException
{
    /**
     * Create the common non-enumerating approval denial.
     *
     * @since  0.1.0
     */
    public function __construct()
    {
        parent::__construct('The requested approval operation is not permitted.');
    }
}
