<?php

namespace Lugmety\Auth\Services\Singleton;

class AppHeader
{
    /**
     * @var string
     */
    public $lang;
    /**
     * @var string
     */
    public $deviceOs;
    /**
     * @var float|int
     */
    public $appVersion;
    /**
     * @var float|int
     */
    public $deviceOsVersion;
    /**
     * @var string
     */
    public $device;
    /**
     * @var string
     */
    public $token;

    /**
     * @param string $token
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $lang
     * @return void
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @param string $device
     * @return void
     */
    public function setDevice(string $device)
    {
        $this->device = $device;
    }

    /**
     * @param string $deviceOs
     * @return void
     */
    public function setDeviceOs(string $deviceOs)
    {
        $this->deviceOs = $deviceOs;
    }

    /**
     * @param float|int $appVersion
     * @return void
     */
    public function setAppVersion($appVersion)
    {
        $this->appVersion = $appVersion;
    }

    /**
     * @param float $deviceOsVersion
     * @return void
     */
    public function setDevicesOsVersion($deviceOsVersion)
    {
        $this->deviceOsVersion = $deviceOsVersion;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getAllHeaders(): array
    {
        return [
            'x-lang' => $this->lang,
            'x-app-version' => $this->appVersion,
            'x-device' => $this->device,
            'x-device-os'  => $this->deviceOs,
            'x-device-os-version' => $this->deviceOsVersion,
            'Authorization' => $this->token
        ];
    }
}