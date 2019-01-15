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
class EditPasswordForm extends FormModel
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
                "legend" => "Password change",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $user->id,
                ],
                "OldPassword" => [
                    "type" => "password"
                ],
                "NewPassword" => [
                    "type" => "password"
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
        $password       = $this->form->value("OldPassword");
        $newPassword    = $this->form->value("NewPassword");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);

        if (!password_verify($password, $user->password)) {
            $this->form->rememberValues();
            $this->form->addOutput("Old password incorrect");
            return false;
        }

        // Save to database
        $user->setPassword($newPassword);
        $user->save();

        $this->form->addOutput("Changed password.");
        return true;
    }
}
