<?php


namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     */
    public function show(int $id): Response
    {
        /** @var Program $program */
        $program = $this->getDoctrine()
                ->getRepository(Program::class)
                ->find($id);

        $seasons = $this->getDoctrine()
                ->getRepository(Season::class)
                ->findBy(['program_id' => $program->getId()]);

        return $this->render('program/show.html.twig', [
            'seasons' => $seasons,
            'program' => $program
        ]);
    }


    /**
     * @Route("/{programId}/seasons/{seasonId}", name="season_show")
     */
    public function showSeason(int $programId, int $seasonId): Response
    {

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->find($programId);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['number' => $seasonId, 'program' => $programId]);

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $season]);

        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'program' => $program,
            'episodes' => $episodes
        ]);
    }
}