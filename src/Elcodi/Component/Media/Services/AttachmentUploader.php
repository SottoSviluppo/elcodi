<?php

namespace Elcodi\Component\Media\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Component\Media\Entity\Attachment;
use Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\EventDispatcher\MediaEventDispatcher;
use Elcodi\Component\Media\Exception\InvalidAttachmentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AttachmentUploader.
 */
class AttachmentUploader
{
    /**
     * @var ObjectManager
     *
     * Attachment Object manager
     */
    private $attachmentObjectManager;

    /**
     * @var FileManager
     *
     * File Manager
     */
    private $fileManager;

    /**
     * @var MediaEventDispatcher
     *
     * Media event dispatcher
     */
    private $mediaEventDispatcher;
    private $attachmentFactory;

    /**
     * Construct method.
     *
     * @param ObjectManager        $attachmentObjectManager   Attachment Object Manager
     * @param FileManager          $fileManager          File Manager
     * @param MediaEventDispatcher $mediaEventDispatcher Media event dispatcher
     */
    public function __construct(
        ObjectManager $attachmentObjectManager,
        FileManager $fileManager,
        MediaEventDispatcher $mediaEventDispatcher,
        $attachmentFactory
    ) {
        $this->attachmentObjectManager = $attachmentObjectManager;
        $this->fileManager = $fileManager;
        $this->mediaEventDispatcher = $mediaEventDispatcher;
        $this->attachmentFactory = $attachmentFactory;
    }

    /**
     * Upload an attachment.
     *
     * @param UploadedFile $file File to upload
     *
     * @return AttachmentInterface|null Uploaded attachment or false is error
     *
     * @throws InvalidAttachmentException File is not an attachment
     */
    public function uploadAttachment(UploadedFile $file)
    {
        $attachment = $this
            ->createAttachment($file);

        $this
            ->mediaEventDispatcher
            ->dispatchAttachmentPreUploadEvent($attachment);

        $this->attachmentObjectManager->persist($attachment);
        $this->attachmentObjectManager->flush($attachment);

        $this->fileManager->uploadFile(
            $attachment,
            file_get_contents($file->getRealPath()),
            true,
            'attachment_'
        );

        $this
            ->mediaEventDispatcher
            ->dispatchAttachmentOnUploadEvent($attachment);

        return $attachment;
    }

    /*
     * @return ImageInterface Image created
     */
    private function createAttachment($file)
    {
        $fileMime = $file->getMimeType();

        if ('application/octet-stream' === $fileMime) {
            $imageSizeData = getimagesize($file->getPathname());
            $fileMime = $imageSizeData['mime'];
        }

        $extension = $file->getExtension();

        if (!$extension && $file instanceof UploadedFile) {
            $extension = $file->getClientOriginalExtension();
        }

        $image = $this->attachmentFactory->create();

        $name = $file->getFilename();
        $image
            ->setContentType($fileMime)
            ->setSize($file->getSize())
            ->setExtension($extension)
            ->setName($name)
            ->setFilename($file->getClientOriginalName());

        return $image;

    }
}
