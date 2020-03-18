<?php


namespace App\Services;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class ImageServices
{
    private $folder;

    public function __construct(string $folder)
    {
        $this->folder=$folder;
    }

    public function storeImage(UploadedFile $file){
        $nazivFajla = time()."-".$file->getClientOriginalName();

        $file->move(\public_path().$this->folder, $nazivFajla);

        return $nazivFajla;
    }

    public function fitImage($nazivFajla,$sirina,$visina){
        $img = \Image::make(\public_path().$this->folder.$nazivFajla);

        $noviNazivFajla="fit-".$nazivFajla;

        $img->fit($sirina, $visina);

        $img->save(\public_path().$this->folder.$noviNazivFajla);

        return $noviNazivFajla;
    }

    public function obrisiSliku($naziv){
        \File::delete(\public_path().$this->folder.$naziv);
    }

}