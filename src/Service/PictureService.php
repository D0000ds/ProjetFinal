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
        $fichier = md5(uniqid(rand(), true)). '.webp';

        $picture_infos = getimagesize($picture);

        if($picture_infos === false){
            throw new Expection("Mauvais format d'image");
        }

        switch($picture_infos['mime']) {
            case 'image/png':
                $picture_source = imagecreatefrompng($picture);
                break;
            case 'image/jpeg':
                $picture_source = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $picture_source = imagecreatefromwebp($picture);
                break;
            default:
                throw new Expection("Mauvais format d'image");
        }

        $path = $this->params->get('images_directory');

        $picture->move($path . "/" . $fichier);

        return $fichier;
    }

    public function delete(string $fichier)
    {
        if($fichier !== 'default.webp'){
            $success = false;
            $path = $this->params->get('images_directory');

            $original = $path . "/" . $fichier;

            if(file_exists($original)){
                $sucess = true;
            }

            return $success;
        }
        return false;
    }
}