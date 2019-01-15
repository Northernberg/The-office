<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Models\Article;
use Anax\Models\CreatePostForm;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MainController implements ContainerInjectableInterface
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

        $all = $article->findAll();
        $arr = [];

        foreach ($all as $a) {
            foreach (json_decode($a->tags) as $t) {
                array_push($arr, $t);
            }
        }
        $arr = array_count_values($arr);
        arsort($arr);

        $page = $this->di->get("page");
        $page->add("anax/view/startPage", [
            "articles" => $article->findAll(),
            "tags" => array_slice($arr, 0, 5)
        ]);

        return $page->render([
            "title" => $title
        ]);
    }

    public function aboutAction() : object
    {
        $title = "About";

        $page = $this->di->get("page");
        $page->add("anax/view/about");

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
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return ;
    }
}
