<?php

namespace App\Utils;

use App\Utils\Enums\AlertIconEnum;
use App\Utils\Enums\AlertTypeEnum;

trait Alerts
{
    /** @var array */
    private $alerts;

    public function __construct()
    {
        $this->alerts = [];
    }

    /**
     * The function "addAlert" adds an alert to an array with a specified type, message, attributes, and
     * translation option.
     *
     * @param AlertTypeEnum alert_type The alert type parameter is of type AlertTypeEnum, which is an enum that
     * represents different types of alerts (e.g., Info, Success, Warning, Error).
     * @param string Is a string that represents the content of the alert message.
     * @param ?array attributes An optional array of attributes that can be used to replace placeholders in the
     * message string.
     * @param ?bool trans Is a boolean flag that indicates whether the message should be
     * translated or not.
     */
    public function addAlert(AlertTypeEnum $alert_type = AlertTypeEnum::Info, string $message = '', ?array $attributes = [], ?bool $trans = true): void
    {
        $this->alerts[] = (object) [
            'type' => $alert_type,
            'message' => ($trans) ? __($message, $attributes) : $message,
            'icon' => match ($alert_type) {
                AlertTypeEnum::Info => AlertIconEnum::Info,
                AlertTypeEnum::Error => AlertIconEnum::Error,
                AlertTypeEnum::Default => AlertIconEnum::Default,
                AlertTypeEnum::Warning => AlertIconEnum::Warning,
                AlertTypeEnum::Success => AlertIconEnum::Success
            },
        ];
    }

    public function getAlerts(): array
    {
        return session('alerts', $this->alerts);
    }
}
