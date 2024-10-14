<?php

namespace App\Http\Services;

use App\Models\AppSetting;

class AppSettingService
{
    /** @var array */
    protected $settings = [];

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * The function `loadSettings` retrieves and decodes application settings from the database in PHP.
     * 
     * @return void If the `->settings` is empty, an empty array `[]` will be assigned to
     * `->settings` and the function will return. Otherwise, the function will decode the JSON
     * string stored in `->settings` into an associative array and assign it to
     * `->settings`.
     */
    private function loadSettings(): void
    {
        $appSettings = AppSetting::find(1);

        if (empty($appSettings->settings)) {
            $this->settings = [];
            return;
        }

        $this->settings = json_decode($appSettings->settings, true);
    }

    public function get($field)
    {
        return $this->settings[$field] ?? null;
    }

    /**
     * The `set` function updates a specific field with a value in the settings array and then saves the
     * updated settings to the database.
     * 
     * @param string field The `field` parameter in the `set` function represents the key or field name in the
     * settings array where you want to set the value. It is used to specify which setting you want to
     * update or add in the settings array.
     * @param mixed value The `value` parameter in the `set` function represents the value that you want to set
     * for a specific field in the settings array. When you call the `set` function with a field and a
     * value, it updates the settings array with the new value for that field and then saves the updated
     */
    public function set(string $field, mixed $value): void
    {
        if (empty($this->settings)) {
            $this->settings = [];
        }

        $this->settings[$field] = $value;

        AppSetting::updateOrCreate(
            ['id' => 1],
            ['settings' => json_encode($this->settings)]
        );
    }

    /**
     * The function `setFromArray` sets the settings of an object based on an array input and updates the
     * database with the new settings.
     * 
     * @param array new_settings An array containing key-value pairs of settings that need to be updated.
     * @return void
     */
    public function setFromArray(array $new_settings): void
    {
        $settings = [];
        foreach ($new_settings as $key => $value) {
            $settings[$key] = $value;
        }

        $this->settings = $settings;

        AppSetting::updateOrCreate(
            ['id' => 1],
            ['settings' => json_encode($this->settings)]
        );
    }
}
