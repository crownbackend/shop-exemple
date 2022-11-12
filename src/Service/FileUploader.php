<?php

namespace App\Service;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $slugger;
    private ParameterBagInterface $parameterBag;

    public function __construct(SluggerInterface $slugger, ParameterBagInterface $parameterBag)
    {
        $this->slugger = $slugger;
        $this->parameterBag = $parameterBag;
    }

    public function upload(UploadedFile $file, $target)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($target, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            new Response('Problème de téléchargement' . $e->getMessage());
        }

        return $fileName;
    }

    public function delete($entity, string $directory)
    {
        if(file_exists($this->parameterBag->get($directory). '/' . $entity)) {
            unlink($this->parameterBag->get($directory). '/' . $entity);
        }
    }
}
