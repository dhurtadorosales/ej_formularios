<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use AppBundle\Form\Type\AlumnoType;
use AppBundle\Form\Type\GrupoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AlumnoController extends Controller
{
    /**
     * @Route("/alumnos", name="listar_alumnos")
     */
    public function indexAction()
    {
    /** @var EntityManager $em */
    $em =$this->getDoctrine()->getManager();
    $alumnos = $em->createQueryBuilder()
        ->select('a')
        ->addSelect('g')
        ->from('AppBundle:Alumno', 'a')
        ->join('a.grupo', 'g')
        ->orderBy('a.apellidos')
        ->addOrderBy('a.nombre')
        ->getQuery()
        ->getResult();

        return $this->render('alumno/listar.html.twig', [
            'alumnos' => $alumnos
        ]);
    }

    /**
     * @Route("/alumnos/modificar/{id}", name="modificar_alumno")
     * @Route("/alumnos/nuevo", name="nuevo_alumno")
     */
    public function formAlumnoAction(Request $request, Alumno $alumno = null) //null es valor por defecto
    {
        /** @var EntityManager $em */
        $em =$this->getDoctrine()->getManager();

        if (null == $alumno) {
            $alumno = new Alumno();
            $em->persist($alumno);
        }

        //Reutilizamos un formulario que ya existe en AlumnoType
        $form= $this->createForm(AlumnoType::class, $alumno);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em-flush();
            return $this->redirectToRoute('listar_alumnos');
        }

        return $this->render('alumno/form.html.twig', [
            'alumno' => $alumno,
            'formulario' => $form->createView()   //Le pasamos una vista del formulario, no el formulario
        ]);
    }

}
