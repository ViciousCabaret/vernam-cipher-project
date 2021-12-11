<?php

namespace App\Controller;

use App\Helpers\StringGenerator;
use App\Helpers\VernamValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\VernamEncryptionTool;
use App\Helpers\VernamDecryptionTool;
use Exception;

/**
 * @Route("/vernam")
 */
class VernamController extends AbstractController
{


    /**
     * @Route("/", methods={"GET", "POST"}, name="vernam_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirectToRoute('vernam_encrypt');
    }

    /**
     * @Route("/encrypt", methods={"GET", "POST"}, name="vernam_encrypt")
     * @param Request $request
     * @return Response
     */
    public function encrypt(Request $request): Response
    {
        if ($request->getMethod() == 'POST') {
            $message = $request->get('message');
            $validator = new VernamValidator();
            try {
                $validator->getMessageValidator()->validate($message);

                $key = $request->get('key');
                if ($key == null || $key == '') {
                    $key = StringGenerator::generate(strlen($message));
                }
                $validator->getKeyValidator()->validate($key);
            } catch (Exception $exception){
                return $this->render('vernam/vernam-cipher-action.html.twig', [
                    'intent' => 'encrypt',
                    'error_message' => $exception->getMessage()
                ]);
            }

            $encryptionTool = new VernamEncryptionTool($message, $key);
            $result = $encryptionTool->encrypt()->getResult();

            return $this->render('vernam/vernam-cipher-action.html.twig', [
                'intent' => 'encrypt',
                'result' => $result,
                'key' => $key
            ]);
        }
        return $this->render('vernam/vernam-cipher-action.html.twig', [
            'intent' => 'encrypt'
        ]);
    }

    /**
     * @Route("/decrypt", methods={"GET", "POST"}, name="vernam_decrypt")
     * @param Request $request
     * @return Response
     */
    public function decrypt(Request $request): Response
    {
        if ($request->getMethod() == 'POST') {

            $message = $request->get('message');
            $validator = new VernamValidator();
            try {
                $validator->getMessageValidator()->validate($message);

                $key = $request->get('key');
                if ($key == null || $key == '') {
                    throw new Exception("Key must be provided");
                }
                $validator->getKeyValidator()->validate($key);
            } catch (Exception $exception){
                return $this->render('vernam/vernam-cipher-action.html.twig', [
                    'intent' => 'encrypt',
                    'error_message' => $exception->getMessage()
                ]);
            }

            $encryptionTool = new VernamDecryptionTool($message, $key);
            $result = $encryptionTool->decode()->getResult();
            return $this->render('vernam/vernam-cipher-action.html.twig', [
                'intent' => 'decrypt',
                'result' => $result,
                'key' => $key
            ]);
        }
        return $this->render('vernam/vernam-cipher-action.html.twig', [
            'intent' => 'decrypt',
        ]);
    }

    /**
     * @Route("/generate-key", methods={"GET", "POST"}, name="vernam_generate_key")
     * @param Request $request
     * @return Response
     */
    public function generateKey(Request $request): Response
    {
        $responseData = [];
        if ($request->getMethod() == 'POST') {
            $keyLength = $request->get('keyLength');
            $responseData['key'] = StringGenerator::generate((int)$keyLength);
            if ($keyLength == "") {
                $responseData['key'] = StringGenerator::generate();
            }
        }
        return $this->render('vernam/generate-key.html.twig', $responseData);
    }
}