<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    /**
     * @var $targetDirectory
     */
    private $targetDirectory;
    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * FileUploader constructor.
     * @param string $targetDirectory
     * @param SluggerInterface $slugger
     */
    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    /**
     * @param UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file): ?string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return $e->getMessage();
        }

        return $fileName;
    }

    /**
     * @param string $fileName
     */
    public function remove(string $fileName): void
    {
        $fullFileName = $this->getTargetDirectory().'/'.$fileName;
        if(file_exists($fullFileName))
        {
            unlink($fullFileName);
        }
    }

    /**
     * @return string|null
     */
    public function getTargetDirectory(): ?string
    {
        return $this->targetDirectory;
    }
}

