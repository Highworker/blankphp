<?php
namespace Sergejandreev\Blankphp\Core;

class Request
{
    private $storage; //плохое название

    public function __construct() {
        $this->storage = $this->cleanInput($_REQUEST);
    }

    public function __get($name) {
        if (isset($this->storage[$name])) return $this->storage[$name];
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

    public function getRequest() :Request
    {
        return $this;
    }

    public function getRequestEntries()
    {
        return $this -> storage;
    }
}