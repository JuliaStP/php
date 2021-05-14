<?php
namespace Base;

class View
{
    private $tmpPath;
    private $data;

    public function __construct()
    {
    }

    public function setTemplatePath(string $path)
    {
        $this->tmpPath = $path;
    }

    public function __get($username)
    {
        return $this->data[$username];
    }

    public function render(string $tmp, $data = []): string
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        ob_start();
        include $this->tmpPath . '/' . $tmp;
        $data = ob_get_clean();
        return $data;
    }
}