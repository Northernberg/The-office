<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "User Login"
            ],
            [
                "user" => [
                    "type"        => "text",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $username      = $this->form->value("user");
        $password      = $this->form->value("password");

        // Try to login
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->verifyPassword($username, $password);

        // $user is null if user is not found
        if (!$user || !password_verify($password, $user->password)) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $this->di->get("session")->set("username", $user->username);


        $this->form->addOutput("User " . $user->username . " logged in.");
        return true;
    }
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("")->send();
    }
}
