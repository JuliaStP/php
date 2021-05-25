<?php
namespace Base;

class View
{
    private $tmpPath;
    private $data;
    private $twig;

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

    public function assign($data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }


    //hw-5.2

    public function getTwig(string $tpm, $data = [])
    {
        if (!$this->twig) {
            $loader = new \Twig\Loader\FilesystemLoader($this->tmpPath);
            $this->twig = new \Twig\Environment(
                $loader,
                ['cache' => $this->tmpPath . '_cache']
            );
        }

        return $this->twig->render($tpm, $data);
    }
}