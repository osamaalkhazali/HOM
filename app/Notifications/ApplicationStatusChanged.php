<?php

namespace App\Notifications;

use App\Models\Application;

/**
 * @deprecated Use ApplicationStatusNotification instead.
 */
class ApplicationStatusChanged extends ApplicationStatusNotification
{
    public function __construct(Application $application, string $oldStatus, string $newStatus)
    {
        parent::__construct($application, $newStatus, 'user');
    }
}
