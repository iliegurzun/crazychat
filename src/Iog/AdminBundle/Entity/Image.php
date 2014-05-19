<?php

namespace Iog\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $mime_type;

    /**
     * @var string
     */
    private $original_filename;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function __construct()
    {
      $this->setHash(uniqid());
    }
    
    public function __toString() {
        return $this->filename;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set mime_type
     *
     * @param string $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mime_type = $mimeType;
    
        return $this;
    }

    /**
     * Get mime_type
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * Set original_filename
     *
     * @param string $originalFilename
     * @return Image
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->original_filename = $originalFilename;
    
        return $this;
    }

    /**
     * Get original_filename
     *
     * @return string 
     */
    public function getOriginalFilename()
    {
        return $this->original_filename;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Image
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    
    /**
     * @var string
     */
    private $hash;


    /**
     * Set hash
     *
     * @param string $hash
     * @return Image
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    
        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    public function getAbsolutePath()
    {
      return null === $this->filename ? null : $this->getUploadRootDir() . '/'. $this->filename;
    }

    public function getOldAbsolutePath()
    {
      return null === $this->old_filename ? null : $this->getUploadRootDir() . '/'. $this->old_filename;
    }

    public function getWebPath()
    {
      //var_dump();
      return null === $this->filename ? null : $this->getUploadDir() . '/' . $this->filename;
    }
    
    public function setWebPath() {
      return $this;
    }

    protected function getUploadRootDir()
    {
      // the absolute directory path where uploaded
      // documents should be saved
      return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
      // get rid of the __DIR__ so it doesn't screw up
      // when displaying uploaded doc/image in the view.
      return '/uploads/images/' . $this->getHash();
    }
    
    public function prepareFile()
    {
      if (null !== $this->file) {
        $this->filename = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
        $this->mime_type = $this->file->getMimeType();
        $this->original_filename = $this->file->getClientOriginalName();
      }
    }

    public function prepareOldFile()
    {
      $this->old_filename = $this->filename;
    }

    public function uploadFile()
    {
      if (null === $this->file) {
        return;
      }
      $this->file->move($this->getUploadRootDir(), $this->filename);
      unset($this->file);
    }

    public function removeFile()
    {
      if ($file = $this->getAbsolutePath()) {
        @unlink($file);
      }
      
      $this->removeFolder();
    }

    public function removeOldFile()
    {
      if ($file = $this->getOldAbsolutePath()) {
        @unlink($file);
      }
    }
    
    public function removeFolder()
    {
      $dir = $this->getUploadRootDir() . '/' . $this->getHash();
      if(is_dir($dir)) {
        @rmdir($dir);
      }
    }
    
    public function hasFileUploaded(\Symfony\Component\Validator\ExecutionContext $context) 
    {
      if (is_null($this->getFile()) && !$this->getFilename()) {
        $context->addViolationAtSubPath('file', 'This value should not be blank.');
      }
    }
    
    /**
      * @var \Symfony\Component\HttpFoundation\File\UploadedFile
      */
    private $file;
    
    /**
     * Set file
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return Image
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null)
    {
      $this->file = $file;
      $this->original_filename = null;
      return $this;
    }

    /**
     * Get file
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile 
     */
    public function getFile()
    {
      return $this->file;
    }

    public function getHasFile() {
      if ($this->getFilename()) {
        return true;
      }
      return false;
    }
    
    private $to_be_removed = false;
  
    public function getToBeRemoved() {
      return $this->to_be_removed;
    }

    public function setToBeRemoved($to_be_removed) {    
      $this->to_be_removed = $to_be_removed;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
