<?php

namespace Anax\Models;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Models\Answers;
use Anax\Models\Article;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class AnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $article = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Answer",
            ],
            [
                "articleId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $article->id,
                ],
                "Content" => [
                    "type" => "textarea",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create post",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    public function getItemDetails($id) : object
    {
        $article = new Article();
        $article->setDb($this->di->get("dbqb"));
        $article->find("id", $id);
        return $article;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $content        = $this->form->value("Content");
        $articleId      = $this->form->value("articleId");

        $article = new Article();
        $article->setDb($this->di->get("dbqb"));
        $article->find("id", $articleId);

        // Save to database
        $answer = new Answers();
        $answer->setDb($this->di->get("dbqb"));
        $answer->content = $content;
        $answer->articleId = $articleId;
        $answer->username = $this->di->get("session")->get("username");
        $answer->save();

        $this->form->addOutput("Post was created.");
        return true;
    }
}
