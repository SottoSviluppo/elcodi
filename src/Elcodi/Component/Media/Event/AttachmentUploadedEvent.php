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

namespace Elcodi\Component\Media\Event;

use Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AttachmentUploadedEvent.
 */
final class AttachmentUploadedEvent extends Event
{
    /**
     * @var AttachmentInterface
     *
     * Attachment
     */
    private $attachment;

    /**
     * Construct.
     *
     * @param AttachmentInterface $attachment Attachment
     */
    public function __construct( /*AttachmentInterface*/$attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Get attachment.
     *
     * @return AttachmentInterface Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }
}
