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
class CommentAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $answer = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Comment",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $answer->id,
                ],
                "articleId" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $answer->articleId,
                ],
                "Comment" => [
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
        $answer = new Answers();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $id);
        return $answer;
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
        $content        = $this->form->value("Comment");
        $id             = $this->form->value("id");
        $articleId      = $this->form->value("articleId");

        // Save to database
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->answerId = $id;
        $comment->articleId = $articleId;
        $comment->userId = $this->di->get("session")->get("username");
        $comment->content = $content;
        $comment->save();

        // Save score

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $this->di->get("session")->get("username"));
        
        $user->activityScore += 1;
        $user->save();


        $this->form->addOutput("Post was created.");
        return true;
    }
}
