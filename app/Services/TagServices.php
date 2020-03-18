<?php


namespace App\Services;


use App\Http\Models\Tag;
use App\Http\Models\VestTag;

class TagServices
{
    public function delete($idTag){
        $tag=new Tag();
        $tagVest=new VestTag();

        $tagVest->deleteTag($idTag);
        $tag->delete($idTag);
    }
}