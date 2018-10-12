<?php
namespace App\Controller;

use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Description of TestController
 *
 * @author sr_hosseini <rassoul.hosseini at gmail.com>
 *
 * @Route("/api")
 */
class TestController extends Controller
{
    /**
     * Lists all Articles.
     * @FOSRest\Get("/articles")
     *
     * @return array
     */
    public function getArticleAction(SessionInterface $session)
    {
//        $repository = $this->getDoctrine()->getRepository(Article::class);
//
//        // query for a single Product by its primary key (usually "id")
//        $article = $repository->findall();
//
//        return View::create($article, Response::HTTP_OK , []);

        // stores an attribute for reuse during a later user request
//        $session->set('foo', 'bar');

        $foo = $session->get('match');

        return View::create([$foo], Response::HTTP_OK , []);
    }

    /**
     * Create Article.
     * @FOSRest\Post("/article")
     *
     * @return array
     */
    public function postArticleAction(Request $request)
    {
//        $article = new Article();
//        $article->setName($request->get('name'));
//        $article->setDescription($request->get('description'));
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($article);
//        $em->flush();
        return View::create([], Response::HTTP_CREATED , []);

    }
}
