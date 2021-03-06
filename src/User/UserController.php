<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\Models\EditPasswordForm;
use Anax\Models\EditProfileForm;
use Anax\Models\Article;
use Anax\Models\ArticleComment;
use Anax\Models\Answers;
use Anax\Models\Comment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => $this->di->get("session")->get("username"),
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }

    public function logoutAction() : object
    {
        $page = $this->di->get("response");
        $this->di->get("session")->delete("username");

        return $page->redirect("");
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function editAction($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);

        $form = new EditProfileForm($this->di, $id);
        $form->check();

        $page = $this->di->get("page");

        $page->add("anax/view/editProfile", [
            "user" => $user,
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "Profile page",
        ]);
    }

    public function editPasswordAction($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);

        $form = new EditPasswordForm($this->di, $id);
        $form->check();

        $page = $this->di->get("page");

        $page->add("anax/view/editPassword", [
            "user" => $user,
            "form" => $form->getHTML()
        ]);

        return $page->render([
            "title" => "Profile page",
        ]);
    }

    public function profileAction($name) : object
    {

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $name);

        $articles = new Article();
        $articles->setDb($this->di->get("dbqb"));

        //Comments
        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));

        //Comments
        $answers = new Answers();
        $answers->setDb($this->di->get("dbqb"));

        //Comments
        $answerComments = new ArticleComment();
        $answerComments->setDb($this->di->get("dbqb"));


        $page = $this->di->get("page");

        $page->add("anax/view/profile", [
            "gravatar" => md5(strtolower(trim($user->email))),
            "user" => $user,
            "items" => $articles->findAllWhere("userId = ?", $user->username),
            "comments" => $comments->findAllWhere("userId = ?", $user->username),
            "answers" => $answers->findAllWhere("username = ?", $user->username),
            "articleComments" => $answerComments->findAllWhere("userId = ?", $user->username),
            "articles" => $articles->findAll(),
        ]);

        return $page->render([
            "title" => "Profile page",
        ]);
    }
}
