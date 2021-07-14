<?php
namespace App\Controller;

use App\Entity\Attestation;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{

    /**
     * @Route("/attestation/{id}/pdf", name="app_attestation_pdf", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function attestation_pdf(Attestation $attestation, Pdf $knpSnappyPdf): Response
    {
        $html = $this->renderView("pdf/attestation.html.twig", ['attestation' => $attestation]);

        return new Response(
            $knpSnappyPdf->getOutputFromHtml($html),
            // ok status code
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=attestation-{$attestation->getId()}.pdf",
            ]
        );
    }

}
