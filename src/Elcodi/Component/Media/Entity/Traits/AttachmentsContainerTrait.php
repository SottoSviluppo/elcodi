<?php

namespace Elcodi\Component\Media\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait AttachmentsContainerTrait.
 */
trait AttachmentsContainerTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * Attachments
     */
    protected $attachments;

	/**
	 * Set add attachment.
	 *
	 * @param \Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface $attachment Attachment object to be added
	 *
	 * @return $this Self object
	 */
	public function addAttachment( /*\Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface*/$attachment) {
		if ($this->attachments == null) {
			$this->attachments = new ArrayCollection();
		}
		$this->attachments->add($attachment);

		return $this;
	}

    /**
     * Get if entity is enabled.
     *
     * @param \Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface $attachment Attachment object to be removed
     *
     * @return $this Self object
     */
    public function removeAttachment( /*\Elcodi\Component\Media\Entity\Interfaces\AttachmentInterface*/$attachment)
    {
        $this->attachments->removeElement($attachment);

        return $this;
    }

    /**
     * Get all attachments.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set attachments.
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $attachments Attachments
     *
     * @return $this Self object
     */
    public function setAttachments(\Doctrine\Common\Collections\ArrayCollection $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

}
