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
class EditProfileForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Edit Profile",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $user->id,
                ],
                "Username" => [
                    "type" => "text",
                    "value" => $user->username,
                ],
                "Email" => [
                    "type" => "text",
                    "validation" => ["email"],
                    "value" => $user->email,
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
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
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
        $id             = $this->form->value("id");
        $username       = $this->form->value("Username");
        $email          = $this->form->value("Email");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);

        // Save to database
        $user->email = $email;
        $user->username = $username;
        $user->save();

        $this->di->get("session")->set("username", $username);

        $this->form->addOutput("User updated.");
        return true;
    }
}
