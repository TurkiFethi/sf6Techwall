<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderService
{
    public function __construct(private SluggerInterface $slugger)
    {
        
    }
    public function uploadFile(
        UploadedFile $file,
        string $directoryFolder
    ) {
        $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFilename);
        $newFilename = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

        try{
            $file->move(
                $directoryFolder,
                $newFilename
            );

        } catch(FileException $e){

        }
        return $newFilename;
    }
    
}
