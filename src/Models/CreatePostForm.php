<?php

namespace Anax\Models;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Models\Article;
use Anax\Models\UserScore;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class CreatePostForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Legend",
            ],
            [
                "Title" => [
                    "type" => "text",
                ],
                "Body" => [
                    "type" => "textarea",
                ],
                "Tags" => [
                    "type" => "text"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create post",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
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
        $title        = $this->form->value("Title");
        $content      = $this->form->value("Body");
        $tags         = explode(" ", $this->form->value("Tags"));

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $this->di->get("session")->get("username"));

        // Save to database
        $article = new Article();
        $article->setDb($this->di->get("dbqb"));
        $article->title = $title;
        $article->content = $content;
        $article->tags = json_encode($tags);
        $article->userId = $user->username;
        $article->save();

        // Save user score

        $user->posts += 1;
        $user->activityScore += 1;
        $user->save();

        $this->form->addOutput("Post was created.");
        return true;
    }
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("article")->send();
    }
}
