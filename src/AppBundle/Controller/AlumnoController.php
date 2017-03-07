<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use AppBundle\Form\Type\AlumnoType;
use AppBundle\Form\Type\GrupoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('listar_alumnos');
            }
            catch (Exception $e) {
                $this->addFlash('error', 'Error');
            }
        }

        return $this->render('alumno/form.html.twig', [
            'alumno' => $alumno,
            'formulario' => $form->createView()   //Le pasamos una vista del formulario, no el formulario
        ]);
    }

    /**
     * @Route("/alumnos/eliminar/{id}", name="borrar_alumno", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Alumno $alumno)    //Misma ruta que el siguiente pero el método es distinto
    {
        /** @var EntityManager $em */
        $em =$this->getDoctrine()->getManager();

        return $this->render('alumno/borrar.html.twig', [
            'alumno' => $alumno
        ]);
    }

    /**
     * @Route("/alumnos/eliminar/{id}", name="confirmar_borrar_alumno", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Alumno $alumno)
    {
        /** @var EntityManager $em */
        $em =$this->getDoctrine()->getManager();

        try {
            foreach ($alumno->getPartes() as $parte) {
                $em->remove($parte);
            }
            $em->remove($alumno);
            $em->flush();
            $this->addFlash('estado', 'Alumno eliminado con éxito');
        }
        catch (Exception $e) {
            $this->addFlash('error', 'No se ha podido borrar');
        }

        return $this->redirectToRoute('listar_alumnos');
    }

}
