<?php
namespace Sergejandreev\Blankphp\Core;

class Request
{
    private $requestStorage;

    public function __construct() {
        $this->requestStorage = $this->cleanInput($_REQUEST);
    }

    public function __get($name) {
        if (isset($this->requestStorage[$name])) return $this->requestStorage[$name];
    }

    private function cleanInput($data) {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES));
    }

    public function getRequestEntries()
    {
        return $this->requestStorage;
    }
}