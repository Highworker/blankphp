<?php
namespace Sergejandreev\Blankphp\Core;

class View
{
    protected ?Session $session = null;
    protected ?string $targetPage = null;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getSession() :Session
    {
        return $this->session;
    }

    public function getView() :View
    {
        return $this;
    }

    public function setTargetPage(string $targetPage)
    {
        $this->targetPage = $targetPage;
    }

    //TODO: добавить умолчания для $contentView
    public function pageGenerate(string $targetPage, $data, $userData)
    {
        if(isset($targetPage))
        {
            $this->pageMenuShowWithUserData($userData);
            include 'src/views/'.$targetPage;
        }
    }

    public function pageGenerateWithManage(string $contentView, string $additionalContentView, $recipesData, $ingridientsData, $userData)
    {
        $this->pageMenuShowWithUserData($userData);
        if(isset($contentView))
        {
            include 'src/views/'.$contentView;
        }

        if(isset($additionalContentView))
        {
            include 'src/views/'.$additionalContentView;
        }
    }

    public function pageMenuShowWithUserData(array|null $userData)
    {
        include 'src/views/menu.php';
    }
}