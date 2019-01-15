<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Models\Article;
use Anax\Models\CreatePostForm;
use Anax\Models\CommentAnswerForm;
use Anax\Models\CommentArticleForm;
use Anax\Models\AnswerForm;
use Anax\Models\Answers;
use Anax\Models\Comment;
use Anax\Models\ArticleComment;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ArticleController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * Display the stylechooser with details on current selected style.
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Start";
        $article = new Article();
        $article->setDb($this->di->get("dbqb"));

        $page = $this->di->get("page");

        $page->add("anax/view/main", [
            "items" => $article->findAll(),
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function createAction() : object
    {
        $title = "Start";
        $form = new CreatePostForm($this->di);
        $form->check();

        $page = $this->di->get("page");
        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML()
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }


    public function commentAction($id) {
        $title = "Comment";
        $comments = new CommentAnswerForm($this->di, $id);
        $comments->check();

        $page = $this->di->get("page");
        $page->add("anax/v2/article/default", [
            "content" => $comments->getHTML()
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. YOu can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll($pageId)
    {
        $article = new Article();
        $article->setDb($this->di->get("dbqb"));
        $article->find("id", $pageId);
        $title = $article->title;

        // Markdown convert
        $filter = $this->di->get("textfilter");
        $article->title = $filter->doFilter($article->title, "markdown");
        $article->content = $filter->doFilter($article->content, "markdown");

        // Create answer form
        $answer = new AnswerForm($this->di, $pageId);
        $answer->check();

        // Create comment form
        $commentForm = new CommentArticleForm($this->di, $pageId);
        $commentForm->check();

        //Find comments
        $responses = new Answers();
        $responses->setDb($this->di->get("dbqb"));

        //Find answerComments
        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));

        //Find normal comments
        $ArticleComments = new ArticleComment();
        $ArticleComments->setDb($this->di->get("dbqb"));

        $page = $this->di->get("page");
        $page->add("anax/view/article", [
            "post" => $article,
            "answers" => $responses->findAllWhere("articleId = ?", $pageId),
            "answerForm" => $answer->getHTML(),
            "articleComments" => $ArticleComments->findAllWhere("articleId = ?" , $pageId),
            "comments" => $comments->findAllWhere("articleId = ?", $pageId),
            "commentForm" => $commentForm->getHTML(),
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }
}
