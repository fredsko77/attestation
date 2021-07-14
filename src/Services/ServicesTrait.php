<?php
namespace App\Services;

use DateTime;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

trait ServicesTrait
{

    /**
     * @param object $errors
     *
     * @return object|null
     */
    public function sendErrors(ConstraintViolationList $violations): ?object
    {
        $response = new stdClass;
        $response->status = Response::HTTP_BAD_REQUEST;

        if (count($violations) > 0) {

            $errors = [
                'title' => 'Validation failed !',
                'violations' => [],
            ];

            foreach ($violations as $violation) {
                $errors['violations'][$violation->getPropertyPath()] = $violation->getMessage();
            }

            if (!property_exists($response, 'headers')) {
                $response->headers = [];
            }

            $response->data = $errors;

            return $response;
        }

        return null;
    }

    /**
     * @param array $violations
     *
     * @return object|null
     */
    public function sendCustomErrors(array $violations = []): ?object
    {
        $response = new stdClass;
        $response->status = Response::HTTP_BAD_REQUEST;

        if (count($violations) > 0) {

            $errors = [
                'title' => 'Validation failed !',
                'violations' => [],
            ];

            foreach ($violations as $k => $v) {
                $errors['violations'][$k] = $v;
            }

            if (!property_exists($response, 'headers')) {
                $response->headers = [];
            }

            $response->data = $errors;

            return $response;

        }

        return null;
    }

    /**
     * Generate a token
     * @param integer $length
     * @return string
     */
    public function generateShuffleChars(int $length = 10): string
    {
        $char_to_shuffle = 'azertyuiopqsdfghjklwxcvbnAZERTYUIOPQSDFGHJKLLMWXCVBN1234567890';
        return substr(str_shuffle($char_to_shuffle), 0, $length);
    }

    /**
     * @param int $length
     * @return string
     */
    public function generateToken(int $length = 50): string
    {
        return $this->generateShuffleChars($length) . (new DateTime)->format('YmdHisu');
    }

    /**
     * @return string
     */
    public function generateIdentifier(string $type = "ID"): string
    {
        return $type . '_' . $this->generateShuffleChars(10) . '_' . (new DateTime)->format('YmdHisu');
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     *
     * @return object
     */
    public function sendJson($data = [], int $status = Response::HTTP_OK, $headers = []): object
    {
        $response = new stdClass;
        $response->data = $data;
        $response->status = $status;
        $response->headers = $headers;

        return $response;
    }

    /**
     * @return object
     */
    public function sendNoContent(): object
    {
        $response = new stdClass;
        $response->data = [];
        $response->status = Response::HTTP_NO_CONTENT;
        $response->headers = [];

        return $response;
    }

}
