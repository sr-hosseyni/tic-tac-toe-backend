<?php
namespace App\Controller;

use App\Util\MoveService;
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
     * @FOSRest\Post("/move")
     *
     * @return array
     */
    public function moveAction(Request $request, MoveService $moveService)
    {
        $boardState = json_decode($request->getContent());

//        var_dump($boardState);die;


        $result = $moveService->makeMove($boardState, 'X');

        return View::create($result, Response::HTTP_OK, []);
    }
}
