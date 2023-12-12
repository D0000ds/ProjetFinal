<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture)
    {
        $fichier = md5(uniqid(rand(), true)). ".webp";

        $picture_infos = getimagesize($picture);

        if($picture_infos === false){
            throw new Exception("Format d'image incorrect");
        }

        $path = $this->params->get('images_directory');


       $picture->move($path , $fichier);

       return $fichier;
    }
}