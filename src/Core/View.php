<?php
namespace Sergejandreev\Blankphp\Core;

class View
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    //TODO: добавить умолчания для $contentView
    public function pageGenerate(string $contentView, $data = null)
    {
        if(isset($contentView))
        {
            $this->pageMenuShowWithUserData();
            include 'src/views/'.$contentView;
        }
    }

    public function pageGenerateWithManage(string $contentView, ?string $additionalContentView, $recipesData = null, $ingridientsData = null)
    {
        $this->pageMenuShowWithUserData();
        if(isset($contentView))
        {
            include 'src/views/'.$contentView;
        }

        if(isset($additionalContentView))
        {
            include 'src/views/'.$additionalContentView;
        }
    }

    public function pageMenuShowWithUserData($userData = null){
        include 'src/views/menu.php';
    }
}