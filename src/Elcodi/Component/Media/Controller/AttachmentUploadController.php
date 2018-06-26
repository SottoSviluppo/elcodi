<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zattachment@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Media\Controller;

use Elcodi\Component\Media\Services\AttachmentUploader;
use Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AttachmentUploadController.
 */
class AttachmentUploadController
{
    /**
     * @var RequestStack
     *
     * Request stack
     */
    private $requestStack;

    /**
     * @var AttachmentUploader
     *
     * Attachment uploader
     */
    private $attachmentUploader;

    /**
     * @var RouterInterface
     *
     * Router
     */
    private $router;

    /**
     * @var string
     *
     * Field name when uploading
     */
    private $uploadFieldName = 'file';

    /**
     * @var string
     *
     * View attachment url name
     */
    private $viewAttachmentRouteName;

    /**
     * @var string
     *
     * Resize attachment url name
     */
    private $resizeAttachmentRouteName;
    private $attachmentRepository;
    private $fileManager;

    /**
     * Attachment uploader.
     *
     * @param RequestStack    $requestStack         Request stack
     * @param AttachmentUploader   $attachmentUploader        Attachment uploader
     * @param RouterInterface $router               Router
     * @param string          $uploadFieldName      Field name when uploading
     * @param string          $viewAttachmentRouteName   View attachment url name
     * @param string          $resizeAttachmentRouteName Resize attachment url name
     */
    public function __construct(
        RequestStack $requestStack,
        AttachmentUploader $attachmentUploader,
        RouterInterface $router,
        // $uploadFieldName,
        $viewAttachmentRouteName,
        $resizeAttachmentRouteName,
        $attachmentRepository,
        $fileManager
    ) {
        $this->requestStack = $requestStack;
        $this->attachmentUploader = $attachmentUploader;
        $this->router = $router;
        // $this->uploadFieldName = $uploadFieldName;
        $this->viewAttachmentRouteName = $viewAttachmentRouteName;
        $this->resizeAttachmentRouteName = $resizeAttachmentRouteName;
        $this->attachmentRepository = $attachmentRepository;
        $this->fileManager = $fileManager;
    }

    /**
     * Dynamic upload action.
     *
     * @return JsonResponse Upload response
     */
    public function uploadAction()
    {
        $request = $this
            ->requestStack
            ->getCurrentRequest();

        /**
         * @var UploadedFile $file
         */
        $file = $request
            ->files
            ->get($this->uploadFieldName);

        if (!($file instanceof UploadedFile)) {
            return new JsonResponse([
                'status' => 'ko',
                'response' => [
                    'message' => 'Attachment not found',
                ],
            ]);
        }

        try {
            $attachment = $this
                ->attachmentUploader
                ->uploadAttachment($file);

            $routes = $this
                ->router
                ->getRouteCollection();

            $response = [
                'status' => 'ok',
                'response' => [
                    'id' => $attachment->getId(),
                    'extension' => $attachment->getExtension(),
                    'filename' => $attachment->getFilename(),
                    'routes' => [
                        'view' => $routes
                            ->get($this->viewAttachmentRouteName)
                            ->getPath(),
                        'resize' => $routes
                            ->get($this->resizeAttachmentRouteName)
                            ->getPath(),
                    ],
                ],
            ];
        } catch (Exception $exception) {
            $response = [
                'status' => 'ko',
                'response' => [
                    'message' => $exception->getMessage(),
                ],
            ];
        }

        return new JsonResponse($response);
    }

    public function viewAction(Request $request)
    {
        $id = $request->get('id');
        $attachment = $this->attachmentRepository
            ->find($id);

        // if (!($attachment instanceof AttachmentInterface)) {
        //     throw new EntityNotFoundException($this->attachmentRepository->getClassName());
        // }

        return $this->buildResponseFromAttachment(
            $request,
            $attachment
        );
    }

    public function downloadAction(Request $request)
    {
        $id = $request->get('id');
        $attachment = $this->attachmentRepository->find($id);

        // echo $attachment->getFilename();
        // echo "o";
        // \Doctrine\Common\Util\Debug::dump($attachment);die();

        // $response = BinaryFileResponse::create($attachment->getPath());
        // $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $attachment->getFilename());

        return $this->buildResponseFromAttachment($request, $attachment);
        return $response;
    }

    /**
     * Create new response given a request and an image.
     *
     * Fill some data to this response given some Image properties and check if
     * created Response has changed.
     *
     * @param Request        $request Request
     *
     * @return Response Created response
     */
    private function buildResponseFromAttachment(
        Request $request,
        $attachment
    ) {
        $response = new Response();
        $response
            ->setLastModified($attachment->getUpdatedAt())
            ->setPublic();

        $this
            ->fileManager
            ->downloadFile($attachment, 'attachment_')
            ->getContent();

        $attachmentData = $attachment->getContent();

        $response
            ->setStatusCode(200)
            ->setContent($attachmentData);

        $filename = $attachment->getFilename();
        $response
            ->headers
            ->add([
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);

        return $response;
    }

}
