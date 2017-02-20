<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Grupo;
use AppBundle\Form\Type\GrupoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GrupoController extends Controller
{
    /**
     * @Route("/grupos", name="listar_grupos")
     */
    public function indexAction()
    {
    /** @var EntityManager $em */
    $em =$this->getDoctrine()->getManager();
    $grupos = $em->createQueryBuilder()
        ->select('g')
        ->addSelect('SIZE(g.alumnado)')
        ->addSelect('t')
        ->from('AppBundle:Grupo', 'g')
        ->join('g.tutor', 't')
        ->orderBy('g.descripcion', 'DESC')
        ->getQuery()
        ->getResult();

        return $this->render('grupo/listar.html.twig', [
            'grupos' => $grupos
        ]);
    }

    /**
     * @Route("/grupos/modificar/{descripcion}", name="modificar_grupo")
     */
    public function formGrupoAction(Request $request, Grupo $grupo)
    {
        /** @var EntityManager $em */
        $em =$this->getDoctrine()->getManager();

        //Reutilizamos un formulario que ya existe en GrupoType
        $form= $this->createForm(GrupoType::class, $grupo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em-flush();
        }
        return $this->render('grupo/form.html.twig', [
            'grupo' => $grupo,
            'formulario' => $form->createView()   //Le pasamos una vista del formulario, no el formulario
        ]);
    }

}
